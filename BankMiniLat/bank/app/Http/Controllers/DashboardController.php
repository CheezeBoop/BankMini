<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isTeller()) {
            return redirect()->route('teller.dashboard');
        } else {
            // Default untuk nasabah
            return view('home');
        }
    }
}
