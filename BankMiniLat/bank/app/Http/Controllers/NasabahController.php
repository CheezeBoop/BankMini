<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Nasabah;
use App\Models\Setting;

class NasabahController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:nasabah']);
    }

    public function dashboard()
    {
        // Ambil nasabah berdasarkan user yang login
        $nasabah = Nasabah::where('user_id', Auth::id())
            ->with([
                'rekening.transaksi' => function ($q) {
                    $q->orderBy('created_at', 'desc');
                }
            ])
            ->first();

        if (!$nasabah) {
            return redirect()->route('home')
                ->with('error', 'Data nasabah tidak ditemukan.');
        }

        $rekening = $nasabah->rekening ?? null;

        // Ambil setting dari database
        $setting = Setting::first();

        // Jika tabel belum ada isinya, buat default agar tidak error
        if (!$setting) {
            $setting = (object) [
                'minimal_setor'  => 10000,
                'maksimal_setor' => 10000000,
                'minimal_tarik'  => 10000,
                'maksimal_tarik' => 5000000,
            ];
        }

        return view('nasabah.dashboard', compact('nasabah', 'rekening', 'setting'));
    }

    public function profile()
    {
        $nasabah = Nasabah::where('user_id', Auth::id())
                    ->with('rekening')
                    ->firstOrFail();

        return view('nasabah.profile', compact('nasabah'));
    }
}
