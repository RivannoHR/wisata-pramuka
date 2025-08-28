<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Filters\ProductFilter;
use App\Http\Requests\StoreProductRequest;
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
    public function deleteAll()
    {
        Product::truncate();
        return redirect()->back()->with('success', 'All products have been successfully deleted.');
    }
    public function toggleActive(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();
        return redirect()->route('admin.products');
    }
    public function toggleFeatured(Product $product)
    {
        $product->is_featured = !$product->is_featured;
        $product->save();
        return redirect()->route('admin.products');
    }
    public function store(StoreProductRequest $request)
    {
        // Validation has already passed if this code is reached
        $validatedData = $request->validated();

        // Handle file upload
        if ($request->hasFile('product_image')) {
            $path = $request->file('product_image')->store('products', 'public');
            $validatedData['image_path'] = $path;
        }

        // Create the product
        Product::create($validatedData);

        return redirect()->route('admin.products')
            ->with('success', 'Product created successfully!');
    }
    public function productEditApply(StoreProductRequest $request, Product $product)
    {
        // Get the validated data from the form request.
        $validatedData = $request->validated();

        // Check if a new image was uploaded.
        if ($request->hasFile('product_image')) {

            // 1. Delete the old image if it exists.
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            // 2. Store the new image in the 'products' directory.
            $path = $request->file('product_image')->store('products', 'public');

            // 3. Update the image_path in the validated data.
            $validatedData['image_path'] = $path;
        }

        // Update the product with the validated data (including the new image path if applicable).
        // The `fill` method is a clean way to mass-assign attributes.
        $product->fill($validatedData);
        $product->save();

        // Redirect the user to a product page or a success message.
        return redirect()->route('admin.products');
    }
    public function productDelete(Product $product)
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        // 2. Delete the product record from the database.
        $product->delete();

        // 3. Redirect the user back with a success message.
        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
}
