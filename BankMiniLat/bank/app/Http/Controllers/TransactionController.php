<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Rekening;
use App\Models\Transaksi;
use App\Models\AuditLog;
use App\Models\Nasabah;
use App\Models\Setting;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:nasabah']);
    }

    /**
     * Permintaan setor tunai oleh nasabah
     */
    public function requestDeposit(Request $request)
    {
        $request->validate([
            'rekening_id' => 'required|exists:rekening,id',
            'nominal'     => 'required|integer|min:1',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        $nasabah = Nasabah::where('user_id', Auth::id())->firstOrFail();
        $rek = Rekening::where('id', $request->rekening_id)
            ->where('nasabah_id', $nasabah->id)
            ->firstOrFail();

        $setting = Setting::firstOrFail();

        // ✅ Validasi batas setor
        if ($request->nominal < $setting->minimal_setor) {
            return back()->with('error', 'Setoran minimal adalah Rp ' . number_format($setting->minimal_setor, 0, ',', '.'));
        }

        if ($request->nominal > $setting->maksimal_setor) {
            return back()->with('error', 'Setoran maksimal adalah Rp ' . number_format($setting->maksimal_setor, 0, ',', '.'));
        }

        // ✅ Simpan transaksi setor
        DB::transaction(function () use ($request, $rek) {
            $trx = Transaksi::create([
                'rekening_id'    => $rek->id,
                'jenis'          => 'SETOR',
                'nominal'        => $request->nominal,
                'status'         => 'PENDING',
                'admin_approved' => false,
                'saldo_setelah'  => null,
                'keterangan'     => $request->keterangan,
                'user_id'        => Auth::id(),
            ]);

            AuditLog::create([
                'user_id'    => Auth::id(),
                'aksi'       => 'request_deposit',
                'entitas'    => 'transaksi',
                'entitas_id' => $trx->id,
                'ip_addr'    => request()->ip(),
            ]);
        });

        return redirect()->route('nasabah.dashboard')
            ->with('info', 'Permintaan setor berhasil dibuat. Silakan ke teller untuk konfirmasi.');
    }

    public function index()
    {
        $nasabah = Nasabah::where('user_id', Auth::id())
            ->with('rekening.transaksi')
            ->firstOrFail();

        $rekening = $nasabah->rekening ?? null;

        return view('nasabah.transaksi.index', compact('nasabah', 'rekening'));
    }

    public function show($id)
    {
        $nasabah = Nasabah::where('user_id', Auth::id())->firstOrFail();

        $trx = Transaksi::whereHas('rekening', function($q) use ($nasabah) {
            $q->where('nasabah_id', $nasabah->id);
        })->findOrFail($id);

        return view('nasabah.transaksi.show', compact('trx'));
    }

        // app/Http/Controllers/TransactionController.php
    public function history()
    {
        $nasabah = \App\Models\Nasabah::where('user_id', Auth::id())
            ->with(['rekening.transaksi' => function($q) {
                $q->orderBy('created_at','desc');
            }])
            ->firstOrFail();

        $transaksi = $nasabah->rekening ? $nasabah->rekening->transaksi : collect([]);

        return view('nasabah.transaksi.index', compact('nasabah','transaksi'));
    }

    public function requestWithdraw(Request $request)
    {
        $request->validate([
            'rekening_id' => 'required|exists:rekening,id',
            'nominal'     => 'required|integer|min:1',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        $nasabah = Nasabah::where('user_id', Auth::id())->firstOrFail();
        $rek = Rekening::where('id', $request->rekening_id)
            ->where('nasabah_id', $nasabah->id)
            ->firstOrFail();

        $setting = Setting::firstOrFail();

        // ✅ Validasi batas tarik
        if ($request->nominal < $setting->minimal_tarik) {
            return back()->with('error', 'Tarik tunai minimal adalah Rp ' . number_format($setting->minimal_tarik, 0, ',', '.'));
        }

        if ($request->nominal > $setting->maksimal_tarik) {
            return back()->with('error', 'Tarik tunai maksimal adalah Rp ' . number_format($setting->maksimal_tarik, 0, ',', '.'));
        }

        if ($request->nominal > $rek->saldo) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        // ✅ Simpan transaksi tarik
        DB::transaction(function () use ($request, $rek) {
            $trx = Transaksi::create([
                'rekening_id'    => $rek->id,
                'jenis'          => 'TARIK',
                'nominal'        => $request->nominal,
                'status'         => 'PENDING',
                'admin_approved' => false,
                'saldo_setelah'  => null,
                'keterangan'     => $request->keterangan,
                'user_id'        => Auth::id(),
            ]);

            AuditLog::create([
                'user_id'    => Auth::id(),
                'aksi'       => 'request_withdraw',
                'entitas'    => 'transaksi',
                'entitas_id' => $trx->id,
                'ip_addr'    => request()->ip(),
            ]);
        });

        return redirect()->route('nasabah.dashboard')
            ->with('info', 'Permintaan tarik berhasil dibuat. Silakan ke teller untuk konfirmasi.');
    }
}
