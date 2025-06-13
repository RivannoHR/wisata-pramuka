<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $products = Product::featured()
            ->orderBy('created_at', 'desc')
            ->take(6) // Show latest 6 featured products on homepage
            ->get();
            
        return view('welcome', compact('products'));
    }
}