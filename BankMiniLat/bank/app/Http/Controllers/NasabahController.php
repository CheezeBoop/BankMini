<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Nasabah;

class NasabahController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:nasabah']);
    }

    /**
     * Dashboard Nasabah
     */
    public function dashboard()
    {
        // Ambil data nasabah dari user yang login
        $nasabah = Nasabah::where('user_id', Auth::id())
            ->with(['rekening.transaksi' => function ($q) {
                $q->orderBy('created_at', 'desc');
            }])
            ->first();

        if (!$nasabah) {
            return view('nasabah.dashboard')->with('error', 'Data nasabah tidak ditemukan.');
        }

        // karena 1 nasabah hanya punya 1 rekening
        $rekening = $nasabah->rekening ?? null;

        return view('nasabah.dashboard', compact('nasabah', 'rekening'));
    }
}
