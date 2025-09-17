<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rekening;
use App\Models\Transaksi;
use App\Models\AuditLog;

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
            'rekening_id' => 'required|exists:rekenings,id',
            'nominal'     => 'required|integer|min:10000',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        $rek = Rekening::where('id', $request->rekening_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $trx = Transaksi::create([
            'rekening_id'    => $rek->id,
            'jenis'          => 'SETOR',
            'nominal'        => $request->nominal,
            'status'         => 'PENDING',
            'admin_approved' => false,
        ]);

        AuditLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => 'request_deposit',
            'entitas'    => 'transaksi',
            'entitas_id' => $trx->id,
            'ip_addr'    => $request->ip(),
        ]);

        return redirect()->back()->with('info', 'Permintaan setor berhasil dibuat. Silakan ke teller untuk konfirmasi.');
    }

    /**
     * Request tarik (withdraw) dari nasabah
     */
    public function requestWithdraw(Request $request)
    {
        $request->validate([
            'rekening_id' => 'required|exists:rekenings,id',
            'nominal'     => 'required|integer|min:10000',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        $rek = Rekening::where('id', $request->rekening_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($request->nominal > $rek->saldo) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi.');
        }

        $trx = Transaksi::create([
            'rekening_id'    => $rek->id,
            'jenis'          => 'TARIK',
            'nominal'        => $request->nominal,
            'status'         => 'PENDING',
            'admin_approved' => false,
        ]);

        AuditLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => 'request_withdraw',
            'entitas'    => 'transaksi',
            'entitas_id' => $trx->id,
            'ip_addr'    => $request->ip(),
        ]);

        return redirect()->back()->with('info', 'Permintaan tarik berhasil dibuat. Silakan ke teller untuk konfirmasi.');
    }
}
