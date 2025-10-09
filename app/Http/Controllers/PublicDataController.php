<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Accommodation;
use App\Models\TouristAttraction;
use App\Models\Article;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class PublicDataController extends Controller
{
    /**
     * Display all data in a public HTML format
     */
    public function index()
    {
        $data = [
            'products' => Product::where('is_active', true)->get(),
            'accommodations' => Accommodation::where('is_active', true)->with('images')->get(),
            'attractions' => TouristAttraction::where('is_active', true)->with('images')->get(),
            'articles' => Article::where('is_published', true)->with('images')->get(),
        ];

        return view('public.data-display', compact('data'));
    }

    /**
     * Display products as HTML
     */
    public function products()
    {
        $products = Product::where('is_active', true)->get();
        return view('public.products-display', compact('products'));
    }

    /**
     * Display accommodations as HTML
     */
    public function accommodations()
    {
        $accommodations = Accommodation::where('is_active', true)->with('images')->get();
        return view('public.accommodations-display', compact('accommodations'));
    }

    /**
     * Display tourist attractions as HTML
     */
    public function attractions()
    {
        $attractions = TouristAttraction::where('is_active', true)->with('images')->get();
        return view('public.attractions-display', compact('attractions'));
    }

    /**
     * Display articles as HTML
     */
    public function articles()
    {
        $articles = Article::where('is_published', true)->with('images')->get();
        return view('public.articles-display', compact('articles'));
    }

    /**
     * Export data as JSON (for API access)
     */
    public function exportJson()
    {
        $data = [
            'products' => Product::where('is_active', true)->get(),
            'accommodations' => Accommodation::where('is_active', true)->with('images')->get(),
            'attractions' => TouristAttraction::where('is_active', true)->with('images')->get(),
            'articles' => Article::where('is_published', true)->with('images')->get(),
        ];

        return response()->json($data);
    }
}
