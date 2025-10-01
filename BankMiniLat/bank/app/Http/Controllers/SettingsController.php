<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
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

        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'minimal_setor'  => 'required|integer|min:0',
            'maksimal_setor' => 'required|integer|min:0',
            'minimal_tarik'  => 'required|integer|min:0',
            'maksimal_tarik' => 'required|integer|min:0',
        ]);

        $setting = Setting::firstOrCreate(['id' => 1]);
        $setting->update($request->only([
            'minimal_setor',
            'maksimal_setor',
            'minimal_tarik',
            'maksimal_tarik',
        ]));

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
