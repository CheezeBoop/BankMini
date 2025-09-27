<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Nasabah;
use App\Models\Rekening;
use App\Models\Transaksi;
use App\Models\AuditLog;
use App\Models\User;
use App\Models\Role;

class TellerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:teller']);
    }

    /**
     * Dashboard Teller
     */
    public function dashboard(Request $request)
{
    $query = Rekening::with('nasabah');

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->whereHas('nasabah', function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('nis_nip', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        })
        ->orWhere('no_rekening', 'like', "%{$search}%");
    }

    // 🚀 paginate 10 per halaman
    $nasabahs = $query->paginate(10)->withQueryString();

    $pending = Transaksi::where('status', 'PENDING')->with('rekening')->get();

    return view('teller.dashboard', compact('nasabahs', 'pending'));
}



    /**
     * Setor tunai
     */
    public function setor(Request $r, $id)
    {
        $r->validate(['nominal' => 'required|numeric|min:1']);
        $rek = Rekening::with('nasabah')->findOrFail($id);

        if ($rek->status !== 'AKTIF' || $rek->nasabah->status !== 'AKTIF') {
            return back()->with('error', 'Rekening atau nasabah tidak aktif.');
        }

        DB::transaction(function () use ($r, $rek) {
            $needsApprove = $r->nominal > 1_000_000;

            $trx = Transaksi::create([
                'rekening_id'    => $rek->id,
                'user_id'        => Auth::id(), // teller yang input
                'jenis'          => 'SETOR',
                'nominal'        => $r->nominal,
                'status'         => $needsApprove ? 'PENDING' : 'CONFIRMED',
                'admin_approved' => !$needsApprove,
                'saldo_setelah'  => $needsApprove ? null : ($rek->saldo + $r->nominal),
                'keterangan'     => $r->keterangan ?? null,
            ]);

            if ($trx->status === 'CONFIRMED') {
                $rek->saldo += $r->nominal;
                $rek->save();
            }

            AuditLog::create([
                'user_id'    => Auth::id(),
                'aksi'       => 'setor',
                'entitas'    => 'transaksi',
                'entitas_id' => $trx->id,
                'ip_addr'    => $r->ip(),
            ]);
        });

        return back()->with('success', 'Setoran berhasil');
    }

    /**
     * Tarik tunai
     */
    public function tarik(Request $r, $id)
    {
        $r->validate(['nominal' => 'required|numeric|min:1']);
        $rek = Rekening::with('nasabah')->findOrFail($id);

        if ($rek->status !== 'AKTIF' || $rek->nasabah->status !== 'AKTIF') {
            return back()->with('error', 'Rekening atau nasabah tidak aktif.');
        }

        if ($rek->saldo < $r->nominal) {
            return back()->with('error', 'Saldo tidak cukup');
        }

        DB::transaction(function () use ($r, $rek) {
            $needsApprove = $r->nominal > 1_000_000;

            $trx = Transaksi::create([
                'rekening_id'    => $rek->id,
                'user_id'        => Auth::id(), // teller yang input
                'jenis'          => 'TARIK',
                'nominal'        => $r->nominal,
                'status'         => $needsApprove ? 'PENDING' : 'CONFIRMED',
                'admin_approved' => !$needsApprove,
                'saldo_setelah'  => $needsApprove ? null : ($rek->saldo - $r->nominal),
                'keterangan'     => $r->keterangan ?? null,
            ]);

            if ($trx->status === 'CONFIRMED') {
                $rek->saldo -= $r->nominal;
                $rek->save();
            }

            AuditLog::create([
                'user_id'    => Auth::id(),
                'aksi'       => 'tarik',
                'entitas'    => 'transaksi',
                'entitas_id' => $trx->id,
                'ip_addr'    => $r->ip(),
            ]);
        });

        return back()->with('success', 'Penarikan berhasil');
    }

    /**
     * Buat nasabah baru
     */
    public function storeNasabah(Request $r)
    {
        $r->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:6',
            'saldo'         => 'required|numeric|min:0',
            'nis_nip'       => 'nullable|string|max:50',
            'no_hp'         => 'nullable|string|max:30',
            'alamat'        => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
        ]);

        $roleId = Role::firstOrCreate(['name' => 'nasabah'])->id;

        DB::transaction(function () use ($r, $roleId) {
            // 1) Buat akun user untuk login
            $user = User::create([
                'name'     => $r->name,
                'email'    => $r->email,
                'password' => Hash::make($r->password),
                'role_id'  => $roleId,
            ]);

            // 2) Buat data profil nasabah
            $nasabah = Nasabah::create([
                'user_id'       => $user->id,
                'nis_nip'       => $r->nis_nip,
                'nama'          => $r->name,
                'jenis_kelamin' => $r->jenis_kelamin,
                'alamat'        => $r->alamat,
                'no_hp'         => $r->no_hp,
                'email'         => $r->email,
                'status'        => 'AKTIF',
            ]);

            // 3) Buat rekening untuk nasabah ini
            $noRek = 'REK' . str_pad((string)$nasabah->id, 6, '0', STR_PAD_LEFT);

            Rekening::create([
                'nasabah_id'   => $nasabah->id,
                'no_rekening'  => $noRek,
                'tanggal_buka' => now()->toDateString(),
                'status'       => 'AKTIF',
                'saldo'        => $r->saldo,
            ]);

            // 4) Log audit
            AuditLog::create([
                'user_id'    => Auth::id(),
                'aksi'       => 'create_nasabah',
                'entitas'    => 'users',
                'entitas_id' => $user->id,
                'ip_addr'    => $r->ip(),
            ]);
        });

        return back()->with('success', 'Nasabah baru berhasil dibuat!');
    }

    /**
     * Konfirmasi transaksi pending
     */
    public function confirmTransaksi($id)
    {
        DB::transaction(function () use ($id) {
            $trx = Transaksi::with('rekening')->lockForUpdate()->findOrFail($id);

            if ($trx->status !== 'PENDING') {
                return;
            }

            $rek = $trx->rekening;

            if ($trx->jenis === 'TARIK' && $rek->saldo < $trx->nominal) {
                abort(400, 'Saldo tidak cukup untuk konfirmasi.');
            }

            if ($trx->jenis === 'SETOR') {
                $rek->saldo += $trx->nominal;
            } else {
                $rek->saldo -= $trx->nominal;
            }
            $rek->save();

            $trx->status = 'CONFIRMED';
            $trx->admin_approved = true;
            $trx->saldo_setelah = $rek->saldo;
            $trx->save();

            AuditLog::create([
                'user_id'    => Auth::id(),
                'aksi'       => 'confirm_transaksi',
                'entitas'    => 'transaksi',
                'entitas_id' => $trx->id,
                'ip_addr'    => request()->ip(),
            ]);
        });

        return back()->with('success', 'Transaksi berhasil dikonfirmasi!');
    }

    public function updateNasabah(Request $r, $id)
{
    $r->validate([
        'nama'          => 'required|string|max:255',
        'email'         => 'required|email',
        'no_hp'         => 'nullable|string|max:20',
        'alamat'        => 'nullable|string',
        'jenis_kelamin' => 'nullable|in:L,P',
    ]);

    $rekening = \App\Models\Rekening::findOrFail($id);
    $nasabah = $rekening->nasabah; // relasi ke tabel nasabah

    if (!$nasabah) {
        return back()->with('error', 'Data nasabah tidak ditemukan.');
    }

    $nasabah->update([
        'nis_nip'       => $r->nis_nip,
        'nama'          => $r->nama,
        'email'         => $r->email,
        'no_hp'         => $r->no_hp,
        'alamat'        => $r->alamat,
        'jenis_kelamin' => $r->jenis_kelamin,
        'status'        => $r->status,
    ]);

    return back()->with('success', 'Profil nasabah berhasil diperbarui.');
}


}
