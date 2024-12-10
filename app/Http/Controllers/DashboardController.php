<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data yang ingin dikirim ke view (opsional)
        $data = [
            'title' => 'Dashboard',
            'welcomeMessage' => 'Selamat datang di halaman Dashboard',
        ];

        $products = Product::all();
        // Return view dashboard
        return view('pages.dashboard.index', compact('products'));
    }
    public function dashboard()
{
    $products = Product::select('nama', 'total_sold', 'sales_count')->get();
    return view('pages.dashboard.index', compact('products'));
}

}
