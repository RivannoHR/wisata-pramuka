<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Solution 1: Use secondary sort by ID for consistent ordering
        $products = Product::where('is_active', true)
            ->orderBy('order')
            ->orderBy('id') // Fallback sort for same order values
            ->get();
            
        return view('welcome', compact('products'));
    }
}