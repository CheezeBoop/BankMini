<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Redirect user ke dashboard sesuai role
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isTeller()) {
            return redirect()->route('teller.dashboard');
        } elseif ($user->isNasabah()) {
            return redirect()->route('nasabah.dashboard');
        }

        // fallback kalau role belum jelas
        return view('dashboard');
    }
}
