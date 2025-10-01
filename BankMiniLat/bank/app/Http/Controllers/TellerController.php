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
use App\Models\Setting;
use App\Exports\NasabahExport;
use Maatwebsite\Excel\Facades\Excel;

class TellerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:teller']);
    }

    /**
     * Pastikan settings ada
     */
    protected function ensureSetting()
    {
        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create([
                'minimal_setor'  => 10000,
                'maksimal_setor' => 10000000,
                'minimal_tarik'  => 10000,
                'maksimal_tarik' => 5000000,
            ]);
        }
        return $setting;
    }

    public function dashboard(Request $request)
    {
        $query = Rekening::with('nasabah');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('nasabah', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis_nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhere('no_rekening', 'like', "%{$search}%");
        }

        $nasabahs = $query->paginate(10)->withQueryString();
        $pending = Transaksi::where('status', 'PENDING')->with('rekening')->get();

        return view('teller.dashboard', compact('nasabahs', 'pending'));
    }

    public function setor(Request $r, $id)
    {
        $r->validate([
            'nominal'    => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $rek = Rekening::with('nasabah')->findOrFail($id);

        if ($rek->status !== 'AKTIF' || $rek->nasabah->status !== 'AKTIF') {
            return back()->with('error', 'Rekening atau nasabah tidak aktif.');
        }

        $setting = $this->ensureSetting();

        if ($r->nominal < $setting->minimal_setor) {
            return back()->with('error', 'Setoran minimal Rp ' . number_format($setting->minimal_setor, 0, ',', '.'));
        }
        if ($r->nominal > $setting->maksimal_setor) {
            return back()->with('error', 'Setoran maksimal Rp ' . number_format($setting->maksimal_setor, 0, ',', '.'));
        }

        DB::transaction(function () use ($r, $rek) {
            $trx = Transaksi::create([
                'rekening_id'    => $rek->id,
                'user_id'        => Auth::id(),
                'jenis'          => 'SETOR',
                'nominal'        => $r->nominal,
                'status'         => 'CONFIRMED',
                'admin_approved' => true,
                'saldo_setelah'  => $rek->saldo + $r->nominal,
                'keterangan'     => $r->keterangan,
            ]);

            $rek->saldo += $r->nominal;
            $rek->save();

            AuditLog::create([
                'user_id'    => Auth::id(),
                'aksi'       => 'setor',
                'entitas'    => 'transaksi',
                'entitas_id' => $trx->id,
                'ip_addr'    => $r->ip(),
            ]);
        });

        return back()->with('success', 'Setoran berhasil.');
    }

    public function tarik(Request $r, $id)
    {
        $r->validate([
            'nominal'    => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $rek = Rekening::with('nasabah')->findOrFail($id);

        if ($rek->status !== 'AKTIF' || $rek->nasabah->status !== 'AKTIF') {
            return back()->with('error', 'Rekening atau nasabah tidak aktif.');
        }
        if ($rek->saldo < $r->nominal) {
            return back()->with('error', 'Saldo tidak cukup.');
        }

        $setting = $this->ensureSetting();

        if ($r->nominal < $setting->minimal_tarik) {
            return back()->with('error', 'Tarik minimal Rp ' . number_format($setting->minimal_tarik, 0, ',', '.'));
        }
        if ($r->nominal > $setting->maksimal_tarik) {
            return back()->with('error', 'Tarik maksimal Rp ' . number_format($setting->maksimal_tarik, 0, ',', '.'));
        }

        DB::transaction(function () use ($r, $rek) {
            $trx = Transaksi::create([
                'rekening_id'    => $rek->id,
                'user_id'        => Auth::id(),
                'jenis'          => 'TARIK',
                'nominal'        => $r->nominal,
                'status'         => 'CONFIRMED',
                'admin_approved' => true,
                'saldo_setelah'  => $rek->saldo - $r->nominal,
                'keterangan'     => $r->keterangan,
            ]);

            $rek->saldo -= $r->nominal;
            $rek->save();

            AuditLog::create([
                'user_id'    => Auth::id(),
                'aksi'       => 'tarik',
                'entitas'    => 'transaksi',
                'entitas_id' => $trx->id,
                'ip_addr'    => $r->ip(),
            ]);
        });

        return back()->with('success', 'Penarikan berhasil.');
    }

    public function rejectTransaction($id)
    {
        DB::transaction(function () use ($id) {
            $trx = Transaksi::findOrFail($id);
            
            if ($trx->status !== 'PENDING') {
                throw new \Exception('Transaksi sudah diproses');
            }
            
            $trx->update([
                'status' => 'REJECTED',
                'admin_approved' => false,
                'keterangan' => $trx->keterangan . ' (Ditolak oleh teller)'
            ]);

            AuditLog::create([
                'user_id' => Auth::id(),
                'aksi' => 'reject_transaksi',
                'entitas' => 'transaksi',
                'entitas_id' => $trx->id,
                'ip_addr' => request()->ip(),
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil ditolak'
        ]);
    }

    public function getTransactionDetails($id)
    {
        $transaction = Transaksi::with(['rekening.nasabah', 'user'])->findOrFail($id);
        
        $html = view('teller.partials.transaction-details', compact('transaction'))->render();
        
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    public function getAccountHistory($id)
    {
        $rekening = Rekening::with(['nasabah', 'transaksi' => function($q) {
            $q->orderBy('created_at', 'desc')->limit(20);
        }])->findOrFail($id);
        
        return view('teller.account-history', compact('rekening'));
    }

    public function printStatement($id)
    {
        $rekening = Rekening::with(['nasabah', 'transaksi' => function($q) {
            $q->where('status', 'CONFIRMED')->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        
        return view('teller.print.statement', compact('rekening'));
    }

    public function exportExcel()
    {
        $nasabahs = Rekening::with('nasabah')->get();
        return Excel::download(new NasabahExport($nasabahs), 'laporan-nasabah-' . date('Y-m-d') . '.xlsx');
    }

    public function printDailyReport()
    {
        $today = now()->toDateString();
        
        $data = [
            'total_nasabah'   => Nasabah::count(),
            'total_saldo'     => Rekening::sum('saldo'),
            'transaksi_hari'  => Transaksi::whereDate('created_at', $today)->get(),
            'pending_count'   => Transaksi::where('status', 'PENDING')->count(),
        ];
        
        return view('teller.print.daily-report', $data);
    }

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
            $user = User::create([
                'name'     => $r->name,
                'email'    => $r->email,
                'password' => Hash::make($r->password),
                'role_id'  => $roleId,
            ]);

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

            $noRek = 'REK' . str_pad((string)$nasabah->id, 6, '0', STR_PAD_LEFT);

            Rekening::create([
                'nasabah_id'   => $nasabah->id,
                'no_rekening'  => $noRek,
                'tanggal_buka' => now()->toDateString(),
                'status'       => 'AKTIF',
                'saldo'        => $r->saldo,
            ]);

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

        $rekening = Rekening::findOrFail($id);
        $nasabah  = $rekening->nasabah;

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
