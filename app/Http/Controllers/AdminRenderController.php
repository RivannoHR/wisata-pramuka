<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\AccommodationImage;
use App\Models\Booking;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Request as HttpRequest;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class AdminRenderController extends Controller
{
    public function dashboardRender(Request $request)
    {
        return view('admin.dashboard');
    }
    public function productRender(Request $request)
    {
        if (!$request->has('filter_yes')) {
            $products = Product::all();
            return view('admin.products.index', compact('products'));
        }
        $query = Product::query();
        $query = ProductFilter::apply($query, $request);
        $products = $query->get();
        return view('admin.products.index', compact('products'));
    }
    public function productCreateRender(Request $request)
    {
        $button = "Create Product";
        return view('admin.products.create', compact('button'));
    }
    public function productEditRender(Product $product)
    {
        $button = "Apply Edit";
        return view('admin.products.create', compact('button', 'product'));
    }
    public function bookingRender(Request $request)
    {
        if (!$request->has('filter_yes')) {
            $bookings = Booking::all();
            return view('admin.bookings.index', compact('bookings'));
        }
        // $query = Product::query();
        // $query = ProductFilter::apply($query, $request);
        // $products = $query->get();
        return view('admin.bookings.index', compact('bookings'));
    }
    public function orderRender(Request $request) {}
    public function touristattractionRender(Request $request) {}
    public function accommodationRender(Request $request)
    {
        $accommodations = Accommodation::all();
        $typesfilter = ['Hotel', 'Villa', 'Guesthouse', 'Resort'];
        return view('admin.accommodations.index', compact('accommodations', 'typesfilter'));
    }

    public function accommodationImagesRender(Accommodation $accommodation)
    {
        $images = $accommodation->images;
        return view('admin.accommodations.images.index', compact('images', 'accommodation'));
    }
    public function accommodationEditRender(Accommodation $accommodation)
    {
        $button = "Apply Edit";
        $typesfilter = ['hotel', 'villa', 'guesthouse', 'resort'];
        return view('admin.accommodations.create', compact('button', 'accommodation', 'typesfilter'));
    }
}
