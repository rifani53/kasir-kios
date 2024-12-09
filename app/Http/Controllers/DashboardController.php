<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    
    public function dashboard()
{
    $products = Product::select('nama', 'total_sold', 'sales_count')->get();
    return view('pages.dashboard.index', compact('products'));
}

}
