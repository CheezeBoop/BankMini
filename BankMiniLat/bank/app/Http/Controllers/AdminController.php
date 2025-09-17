<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\AuditLog;
use App\Models\Transaksi;

class AdminController extends Controller
{
    // Middleware auth + role admin
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    // Dashboard admin: lihat teller
    public function dashboard()
    {
        $tellers = User::whereHas('role', fn($q) => $q->where('name', 'teller'))->get();
        return view('admin.dashboard', compact('tellers'));
    }

    // Form buat teller baru
    public function createTellerForm()
    {
        return view('admin.create_teller');
    }

    // Simpan teller baru
    public function storeTeller(Request $r)
    {
        $r->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $role = Role::firstOrCreate(['name' => 'teller']);

        $teller = User::create([
            'name' => $r->name,
            'email' => $r->email,
            'password' => Hash::make($r->password),
            'role_id' => $role->id
        ]);

        AuditLog::create([
            'user_id'   => Auth::id(),
            'aksi'      => 'create_teller',
            'entitas'   => 'users',
            'entitas_id'=> $teller->id,
            'ip_addr'   => $r->ip()
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Teller created successfully');
    }

    // Hapus teller
    public function removeTeller($id)
    {
        $teller = User::findOrFail($id);
        $teller->delete();

        AuditLog::create([
            'user_id'   => Auth::id(),
            'aksi'      => 'delete_teller',
            'entitas'   => 'users',
            'entitas_id'=> $id,
            'ip_addr'   => request()->ip()
        ]);

        return redirect()->back()->with('success', 'Teller removed successfully');
    }

    // Approve transaksi (khusus >1jt)
    public function approveTransaction(Request $r, $id)
    {
        $trx = Transaksi::findOrFail($id);
        $trx->admin_approved = true;
        $trx->status = 'CONFIRMED';
        $trx->save();

        // update saldo rekening
        $rek = $trx->rekening;
        if ($trx->jenis === 'SETOR') {
            $rek->saldo += $trx->nominal;
        } else {
            $rek->saldo -= $trx->nominal;
        }
        $rek->save();

        AuditLog::create([
            'user_id'   => Auth::id(),
            'aksi'      => 'approve_transaksi',
            'entitas'   => 'transaksi',
            'entitas_id'=> $trx->id,
            'ip_addr'   => $r->ip()
        ]);

        return redirect()->back()->with('success', 'Transaction approved successfully');
    }
}
