<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('mahasiswa.dashboard');
    }
}