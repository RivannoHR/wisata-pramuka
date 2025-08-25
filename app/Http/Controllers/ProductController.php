<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Show only active products by default (can be overridden with show_all=1)
        if (!$request->has('show_all')) {
            $query->active();
        }

        $query = ProductFilter::apply($query, $request);

        // Get page number for infinite scroll
        $page = $request->get('page', 1);
        $perPage = 12;

        $products = $query->paginate($perPage, ['*'], 'page', $page);

        // If it's an AJAX request, return only the product cards
        if ($request->ajax()) {
            return response()->json([
                'html' => view('products.partials.product-cards', compact('products'))->render(),
                'hasMore' => $products->hasMorePages(),
                'nextPage' => $products->currentPage() + 1
            ]);
        }

        return view('products.index', compact('products'));
    }

    public function show($product_id)
    {
        $product = Product::where('product_id', $product_id)->firstOrFail();
        return view('products.show', compact('product'));
    }
    public function deleteAllProducts()
    {
        // The truncate() method will remove all records and reset the auto-incrementing ID
        Product::truncate();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'All products have been successfully deleted.');
    }
}
