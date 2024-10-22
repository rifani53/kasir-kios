<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data yang ingin dikirim ke view (opsional)
        $data = [
            'title' => 'Dashboard',
            'welcomeMessage' => 'Selamat datang di halaman Dashboard1',
        ];

        // Return view dashboard
        return view('pages.dashboard.index', $data);
    }
}
