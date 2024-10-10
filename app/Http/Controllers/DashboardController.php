<?php

namespace App\Http\Controllers;

use App\Models\medikaPasien;
use App\Models\medikaDokter;
use App\Models\medikaPoliklinik;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pasienCount = medikaPasien::count();
        $dokterCount = medikaDokter::count();
        $poliklinikCount = medikaPoliklinik::count();

        return view('dashboard', compact('pasienCount', 'dokterCount', 'poliklinikCount'));
    }
}
