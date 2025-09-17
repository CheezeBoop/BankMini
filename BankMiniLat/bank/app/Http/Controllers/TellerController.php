<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rekening;
use App\Models\Transaksi;
use App\Models\AuditLog;

class TellerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:teller']);
    }

    public function dashboard()
    {
        $nasabahs = Rekening::with('user')->get();
        return view('teller.dashboard', compact('nasabahs'));
    }

    public function setor(Request $r, $id)
    {
        $r->validate(['nominal' => 'required|numeric|min:1']);

        $rek = Rekening::findOrFail($id);

        $trx = Transaksi::create([
            'rekening_id' => $rek->id,
            'jenis'       => 'SETOR',
            'nominal'     => $r->nominal,
            'status'      => $r->nominal > 1000000 ? 'PENDING' : 'CONFIRMED',
            'admin_approved' => $r->nominal > 1000000 ? false : true
        ]);

        if ($trx->status === 'CONFIRMED') {
            $rek->saldo += $r->nominal;
            $rek->save();
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'aksi'    => 'setor',
            'entitas' => 'transaksi',
            'entitas_id' => $trx->id,
            'ip_addr' => $r->ip()
        ]);

        return redirect()->back()->with('success', 'Setoran berhasil');
    }

    public function tarik(Request $r, $id)
    {
        $r->validate(['nominal' => 'required|numeric|min:1']);

        $rek = Rekening::findOrFail($id);

        if ($rek->saldo < $r->nominal) {
            return redirect()->back()->with('error', 'Saldo tidak cukup');
        }

        $trx = Transaksi::create([
            'rekening_id' => $rek->id,
            'jenis'       => 'TARIK',
            'nominal'     => $r->nominal,
            'status'      => $r->nominal > 1000000 ? 'PENDING' : 'CONFIRMED',
            'admin_approved' => $r->nominal > 1000000 ? false : true
        ]);

        if ($trx->status === 'CONFIRMED') {
            $rek->saldo -= $r->nominal;
            $rek->save();
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'aksi'    => 'tarik',
            'entitas' => 'transaksi',
            'entitas_id' => $trx->id,
            'ip_addr' => $r->ip()
        ]);

        return redirect()->back()->with('success', 'Penarikan berhasil');
    }
}
