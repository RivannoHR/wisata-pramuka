<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminRenderController extends Controller
{
    public function dashboardRender(Request $request)
    {
        return view('admin.dashboard');
    }
    public function productRender(Request $request)
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }
    public function productCreateRender(Request $request)
    {
        return view('admin.products.create');
    }
    public function toggleStatus(Request $request, Product $product)
    {
        // Validate the request to ensure a valid field is being toggled
        $request->validate([
            'field' => 'required|in:is_shown,is_featured'
        ]);

        // Get the field name from the request
        $field = $request->input('field');

        // Toggle the boolean value
        $product->{$field} = !$product->{$field};
        $product->save();

        // Return a JSON response with the new status
        return response()->json([
            'success' => true,
            'newStatus' => $product->{$field} ? 'Yes' : 'No',
            'is_shown' => $product->is_shown, // You might need this for frontend logic
            'is_featured' => $product->is_featured,
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' status updated successfully.'
        ]);
    }
    
}
