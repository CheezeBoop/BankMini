<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Nasabah;
use App\Models\Rekening;
use App\Models\Transaksi;
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

    public function requestDeposit(Request $request)
    {
        $request->validate([
            'rekening_id' => 'required|exists:rekening,id',
            'nominal' => 'required|numeric|min:1'
        ]);

        try {
            $rekening = Rekening::where('id', $request->rekening_id)
                ->whereHas('nasabah', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->firstOrFail();

            if ($rekening->nasabah->status !== 'AKTIF') {
                return redirect()->route('nasabah.dashboard')
                    ->with('error', 'Akun Anda tidak aktif. Tidak dapat melakukan transaksi.');
            }

            $setting = Setting::first();
            if ($setting && $request->nominal < $setting->minimal_setor) {
                return redirect()->route('nasabah.dashboard')
                    ->with('error', 'Nominal setor minimal Rp ' . number_format($setting->minimal_setor, 0, ',', '.'));
            }

            if ($setting && $request->nominal > $setting->maksimal_setor) {
                return redirect()->route('nasabah.dashboard')
                    ->with('error', 'Nominal setor maksimal Rp ' . number_format($setting->maksimal_setor, 0, ',', '.'));
            }

            Transaksi::create([
                'rekening_id' => $rekening->id,
                'jenis' => 'SETOR',
                'nominal' => $request->nominal,
                'status' => 'PENDING',
                'keterangan' => 'Request setor tunai - Menunggu konfirmasi teller'
            ]);

            return redirect()->route('nasabah.dashboard')
                ->with('success', 'Request setor berhasil dikirim! Menunggu konfirmasi teller.');

        } catch (\Exception $e) {
            return redirect()->route('nasabah.dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function requestWithdraw(Request $request)
    {
        $request->validate([
            'rekening_id' => 'required|exists:rekening,id',
            'nominal' => 'required|numeric|min:1'
        ]);

        try {
            $rekening = Rekening::where('id', $request->rekening_id)
                ->whereHas('nasabah', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->firstOrFail();

            if ($rekening->nasabah->status !== 'AKTIF') {
                return redirect()->route('nasabah.dashboard')
                    ->with('error', 'Akun Anda tidak aktif. Tidak dapat melakukan transaksi.');
            }

            $setting = Setting::first();
            if ($setting && $request->nominal < $setting->minimal_tarik) {
                return redirect()->route('nasabah.dashboard')
                    ->with('error', 'Nominal tarik minimal Rp ' . number_format($setting->minimal_tarik, 0, ',', '.'));
            }

            if ($setting && $request->nominal > $setting->maksimal_tarik) {
                return redirect()->route('nasabah.dashboard')
                    ->with('error', 'Nominal tarik maksimal Rp ' . number_format($setting->maksimal_tarik, 0, ',', '.'));
            }

            if ($rekening->saldo < $request->nominal) {
                return redirect()->route('nasabah.dashboard')
                    ->with('error', 'Saldo tidak mencukupi. Saldo Anda: Rp ' . number_format($rekening->saldo, 0, ',', '.'));
            }

            Transaksi::create([
                'rekening_id' => $rekening->id,
                'jenis' => 'TARIK',
                'nominal' => $request->nominal,
                'status' => 'PENDING',
                'keterangan' => 'Request tarik tunai - Menunggu konfirmasi teller'
            ]);

            return redirect()->route('nasabah.dashboard')
                ->with('success', 'Request tarik berhasil dikirim! Menunggu konfirmasi teller.');

        } catch (\Exception $e) {
            return redirect()->route('nasabah.dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
