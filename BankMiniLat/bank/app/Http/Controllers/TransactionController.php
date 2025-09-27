<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Rekening;
use App\Models\Transaksi;
use App\Models\AuditLog;
use App\Models\Nasabah;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:nasabah']);
    }

    /**
     * Request setor (deposit) dari nasabah
     */
    public function requestDeposit(Request $request)
    {
        $request->validate([
            'rekening_id' => 'required|exists:rekening,id',
            'nominal'     => 'required|integer|min:10000',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        // pastikan rekening milik nasabah login
        $nasabah = Nasabah::where('user_id', Auth::id())->firstOrFail();
        $rek = Rekening::where('id', $request->rekening_id)
            ->where('nasabah_id', $nasabah->id)
            ->firstOrFail();

        DB::transaction(function () use ($request, $rek) {
            $trx = Transaksi::create([
                'rekening_id'    => $rek->id,
                'jenis'          => 'SETOR',
                'nominal'        => $request->nominal,
                'status'         => 'PENDING',
                'admin_approved' => false,
                'saldo_setelah'  => null,
                'keterangan'     => $request->keterangan,
                'user_id'        => null, // teller yang input nanti
            ]);

            AuditLog::create([
                'user_id'    => Auth::id(),
                'aksi'       => 'request_deposit',
                'entitas'    => 'transaksi',
                'entitas_id' => $trx->id,
                'ip_addr'    => $request->ip(),
            ]);
        });

        return back()->with('info', 'Permintaan setor berhasil dibuat. Silakan ke teller untuk konfirmasi.');
    }

    /**
     * Request tarik (withdraw) dari nasabah
     */
    public function requestWithdraw(Request $request)
    {
        $request->validate([
            'rekening_id' => 'required|exists:rekening,id',
            'nominal'     => 'required|integer|min:10000',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        // pastikan rekening milik nasabah login
        $nasabah = Nasabah::where('user_id', Auth::id())->firstOrFail();
        $rek = Rekening::where('id', $request->rekening_id)
            ->where('nasabah_id', $nasabah->id)
            ->firstOrFail();

        if ($request->nominal > $rek->saldo) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        DB::transaction(function () use ($request, $rek) {
            $trx = Transaksi::create([
                'rekening_id'    => $rek->id,
                'jenis'          => 'TARIK',
                'nominal'        => $request->nominal,
                'status'         => 'PENDING',
                'admin_approved' => false,
                'saldo_setelah'  => null,
                'keterangan'     => $request->keterangan,
                'user_id'        => null, // teller yang input nanti
            ]);

            AuditLog::create([
                'user_id'    => Auth::id(),
                'aksi'       => 'request_withdraw',
                'entitas'    => 'transaksi',
                'entitas_id' => $trx->id,
                'ip_addr'    => $request->ip(),
            ]);
        });

        return back()->with('info', 'Permintaan tarik berhasil dibuat. Silakan ke teller untuk konfirmasi.');
    }
}
