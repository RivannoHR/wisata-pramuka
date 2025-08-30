<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Accommodation;
use App\Models\TouristAttraction;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $products = Product::featured()
            ->orderBy('created_at', 'desc')
            ->take(6) // Show latest 6 featured products on homepage
            ->get();

        // Get 3 random accommodations
        $accommodations = Accommodation::with(['images', 'featuredImage'])
            ->active()
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Get 3 random tourist attractions
        $touristAttractions = TouristAttraction::inRandomOrder()
            ->take(3)
            ->get();

        return view('welcome', compact('products', 'accommodations', 'touristAttractions'));
    }
}
