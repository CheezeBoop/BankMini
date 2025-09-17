<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Rekening;

class NasabahController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:nasabah']);
    }

    public function dashboard()
    {
        $rekening = Rekening::where('user_id', Auth::id())->with('transaksi')->first();
        return view('nasabah.dashboard', compact('rekening'));
    }
}
