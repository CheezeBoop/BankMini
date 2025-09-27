<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\AuditLog;
use App\Models\Transaksi;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Dashboard admin: daftar teller + ringkasan log
     */
    public function dashboard()
    {
        $tellers = User::whereHas('role', fn($q) => $q->where('name', 'teller'))->get();

        // Ringkasan log
        $logAkun = AuditLog::with('user')
            ->whereIn('aksi', ['create_teller', 'delete_teller', 'create_nasabah', 'delete_nasabah'])
            ->latest()->take(10)->get();

        $logSetor = AuditLog::with('user')
            ->where('aksi', 'setor')
            ->latest()->take(10)->get();

        $logTarik = AuditLog::with('user')
            ->where('aksi', 'tarik')
            ->latest()->take(10)->get();

        // Log umum (20 terakhir)
        $logs = AuditLog::with('user')
            ->latest()
            ->take(20)
            ->get();

        return view('admin.dashboard', compact('tellers', 'logAkun', 'logSetor', 'logTarik', 'logs'));
    }

    /**
     * Form buat teller baru
     */
    public function createTellerForm()
    {
        return view('admin.create_teller');
    }

    /**
     * Simpan teller baru
     */
    public function storeTeller(Request $r)
    {
        $r->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $role = Role::firstOrCreate(['name' => 'teller']);

        $teller = User::create([
            'name'     => $r->name,
            'email'    => $r->email,
            'password' => Hash::make($r->password),
            'role_id'  => $role->id,
        ]);

        AuditLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => 'create_teller',
            'entitas'    => 'users',
            'entitas_id' => $teller->id,
            'ip_addr'    => $r->ip(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Teller berhasil dibuat.');
    }

    /**
     * Hapus teller
     */
    public function removeTeller($id)
    {
        $teller = User::findOrFail($id);

        $teller->delete(); // SoftDeletes kalau perlu

        AuditLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => 'delete_teller',
            'entitas'    => 'users',
            'entitas_id' => $id,
            'ip_addr'    => request()->ip(),
        ]);

        return redirect()->back()->with('success', 'Teller berhasil dihapus.');
    }

    /**
     * Approve transaksi (khusus > 1jt atau pending)
     */
    public function approveTransaction(Request $r, $id)
    {
        DB::transaction(function () use ($r, $id) {
            $trx = Transaksi::with('rekening')->lockForUpdate()->findOrFail($id);
            $rek = $trx->rekening;

            if ($trx->status !== 'PENDING') {
                throw new \Exception('Transaksi sudah diproses.');
            }

            // cek saldo kalau penarikan
            if ($trx->jenis === 'TARIK' && $rek->saldo < $trx->nominal) {
                throw new \Exception('Saldo tidak cukup untuk approve penarikan.');
            }

            // update saldo rekening
            if ($trx->jenis === 'SETOR') {
                $rek->saldo += $trx->nominal;
            } else {
                $rek->saldo -= $trx->nominal;
            }
            $rek->save();

            // update transaksi
            $trx->update([
                'admin_approved' => true,
                'status'         => 'CONFIRMED',
                'saldo_setelah'  => $rek->saldo,
            ]);

            AuditLog::create([
                'user_id'    => Auth::id(),
                'aksi'       => 'approve_transaksi',
                'entitas'    => 'transaksi',
                'entitas_id' => $trx->id,
                'ip_addr'    => $r->ip(),
            ]);
        });

        return redirect()->back()->with('success', 'Transaksi berhasil di-approve.');
    }

    /**
     * Log khusus per kategori (akun, setor, tarik) untuk modal
     */
    public function logByType($type)
    {
        switch ($type) {
            case 'akun':
                $logs = AuditLog::with('user')
                    ->whereIn('aksi', ['create_teller', 'delete_teller', 'create_nasabah', 'delete_nasabah'])
                    ->latest()->paginate(10);
                break;

            case 'setor':
                $logs = AuditLog::with('user')
                    ->where('aksi', 'setor')
                    ->latest()->paginate(10);
                break;

            case 'tarik':
                $logs = AuditLog::with('user')
                    ->where('aksi', 'tarik')
                    ->latest()->paginate(10);
                break;

            default:
                abort(404);
        }

        return view('admin.partials.log_list', compact('logs', 'type'));
    }
}
