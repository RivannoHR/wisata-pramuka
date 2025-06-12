<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)
            ->orderBy('order')
            ->orderBy('id')
            ->get();
            
        return view('welcome', compact('products'));
    }
}