<?php

namespace App\Http\Controllers;

use App\Filters\GeneralFilter;
use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\AccommodationImage;
use App\Models\Article;
use App\Models\Booking;
use App\Models\Product;
use App\Models\SiteStatistic;
use App\Models\TouristAttraction;
use App\Traits\TrackVisits;
use Illuminate\Http\Request;
use Illuminate\Http\Request as HttpRequest;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class AdminRenderController extends Controller
{
    use TrackVisits;
    public function dashboardRender(Request $request)
    {
        // Get pending bookings count
        $pendingBookingsCount = Booking::where('status', 'pending')->count();
        
        // Get pending bookings for notification
        $pendingBookings = Booking::where('status', 'pending')
            ->with(['user', 'accommodation'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get top 5 most visited items by category using real visit tracking data
        
        // Get visit counts for each category
        $productVisits = $this->getVisitCounts('product', 5);
        $accommodationVisits = $this->getVisitCounts('accommodation', 5);
        $attractionVisits = $this->getVisitCounts('tourist_attraction', 5);

        // Get actual models with visit data
        $topProducts = collect();
        foreach ($productVisits as $visit) {
            $product = Product::find($visit->item_id);
            if ($product && $product->is_active) {
                $product->view_count = $visit->total_visits;
                $topProducts->push($product);
            }
        }

        $topAccommodations = collect();
        foreach ($accommodationVisits as $visit) {
            $accommodation = Accommodation::find($visit->item_id);
            if ($accommodation && $accommodation->is_active) {
                $accommodation->view_count = $visit->total_visits;
                $topAccommodations->push($accommodation);
            }
        }

        $topAttractions = collect();
        foreach ($attractionVisits as $visit) {
            $attraction = TouristAttraction::find($visit->item_id);
            if ($attraction && $attraction->is_active) {
                $attraction->view_count = $visit->total_visits;
                $topAttractions->push($attraction);
            }
        }

        // If no visit data exists yet, fallback to some items with zero visits
        if ($topProducts->isEmpty()) {
            $topProducts = Product::where('is_active', true)
                ->limit(5)
                ->get()
                ->map(function ($product) {
                    $product->view_count = 0;
                    return $product;
                });
        }

        if ($topAccommodations->isEmpty()) {
            $topAccommodations = Accommodation::where('is_active', true)
                ->limit(5)
                ->get()
                ->map(function ($accommodation) {
                    $accommodation->view_count = 0;
                    return $accommodation;
                });
        }

        if ($topAttractions->isEmpty()) {
            $topAttractions = TouristAttraction::where('is_active', true)
                ->limit(5)
                ->get()
                ->map(function ($attraction) {
                    $attraction->view_count = 0;
                    return $attraction;
                });
        }

        return view('admin.dashboard-content', compact(
            'pendingBookingsCount',
            'pendingBookings',
            'topProducts',
            'topAccommodations',
            'topAttractions'
        ));
    }
    public function productRender(Request $request)
    {
        if (!$request->has('filter_yes')) {
            $products = Product::all();
            return view('admin.products.index', compact('products'));
        }
        $query = Product::query();
        $query = GeneralFilter::product($query, $request);
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
            $bookings = Booking::with(['accommodation', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();
            return view('admin.bookings.index', compact('bookings'));
        }
        $bookingsQuery = Booking::with(['accommodation', 'user']);
        if ($request->has('search')) {
            $searchTerm = $request->get('search');
            $bookingsQuery->whereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('accommodation', function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            })->orWhere('booking_id', 'like', '%' . $searchTerm . '%');
        }
        if ($request->has('status') && $request->get('status') !== '') {
            $bookingsQuery->where('status', $request->get('status'));
        }
        if ($request->has('sort_by')) {
            if ($request->get('sort_by') == 'latest') {
                $bookingsQuery->orderBy('created_at', 'desc');
            } elseif ($request->get('sort_by') == 'oldest') {
                $bookingsQuery->orderBy('created_at', 'asc');
            }
        } else {
            // Default to newest first (latest)
            $bookingsQuery->orderBy('created_at', 'desc');
        }
        $bookings = $bookingsQuery->get();

        return view('admin.bookings.index', compact('bookings'));
    }
    
    public function touristattractionRender(Request $request)
    {
        $types = [
            'all' => 'All Types',
            'tourist_spot' => 'Tourist Spot',
            'restaurant' => 'Restaurant',
            'shop' => 'Shop',
        ];
        if (!$request->has('filter_yes')) {
            $touristAttractions = TouristAttraction::all();
            return view('admin.tourist-attractions.index', compact('touristAttractions', 'types'));
        }
        $query = TouristAttraction::query();

        $query = GeneralFilter::touristAttraction($query, $request);

        $touristAttractions = $query->get();

        return view('admin.tourist-attractions.index', compact('touristAttractions', 'types'));
    }
    public function touristAttractionImagesRender(TouristAttraction $touristAttraction)
    {
        $images = $touristAttraction->images;
        return view('admin.tourist-attractions.images.index', compact('images', 'touristAttraction'));
    }

    public function touristAttractionCreateRender()
    {
        $typesfilter = [
            'tourist spot',
            'restaurant',
            'shop',
        ];
        return view('admin.tourist-attractions.create', compact('typesfilter'));
    }
    public function touristAttractionEditRender(TouristAttraction $touristAttraction)
    {
        $button = "Apply Edit";
        $typesfilter = [
            'tourist spot',
            'restaurant',
            'shop',
        ];
        return view('admin.tourist-attractions.create', compact('button', 'touristAttraction', 'typesfilter'));
    }
    public function accommodationRender(Request $request)
    {
        $types = [
            'all' => 'All Types',
            'hotel' => 'Hotel',
            'villa' => 'Villa',
            'guesthouse' => 'Guesthouse',
            'resort' => 'Resort',
            'homestay' => 'Homestay'
        ];
        if (!$request->has('filter_yes')) {
            $accommodations = Accommodation::with(['ratings', 'reviews', 'reviews.booking'])->get();
            return view('admin.accommodations.index', compact('accommodations', 'types'));
        }
        $query = Accommodation::with(['ratings', 'reviews', 'reviews.booking'])->active();

        $query = GeneralFilter::accommodation($query, $request);

        $accommodations = $query->get();

        return view('admin.accommodations.index', compact('accommodations', 'types'));
    }

    public function accommodationImagesRender(Accommodation $accommodation)
    {
        $images = $accommodation->images;
        return view('admin.accommodations.images.index', compact('images', 'accommodation'));
    }

    public function accommodationCreateRender()
    {
        $typesfilter = ['hotel', 'villa', 'guesthouse', 'resort', 'homestay'];
        return view('admin.accommodations.create', compact('typesfilter'));
    }
    public function accommodationEditRender(Accommodation $accommodation)
    {
        $button = "Apply Edit";
        $typesfilter = ['hotel', 'villa', 'guesthouse', 'resort', 'homestay'];
        return view('admin.accommodations.create', compact('button', 'accommodation', 'typesfilter'));
    }

    public function articleRender(Request $request)
    {
        if (!$request->has('filter_yes')) {
            $articles = Article::all();
            return view('admin.articles.index', compact('articles'));
        }
        $query = Article::query();
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%');
            });
        }
        $sortOrder = $request->get('order', 'asc');
        $query->orderBy('created_at', $sortOrder);
        $articles = $query->get();
        return view('admin.articles.index', compact('articles'));
    }
    public function articleCreateRender(Request $request)
    {
        return view('admin.articles.create');
    }
    public function articleEditRender(Request $request, Article $article)
    {
        return view('admin.articles.create', compact('article'));
    }
    public function articleImagesRender(Article $article)
    {
        $images = $article->images;
        return view('admin.articles.images.index', compact('images', 'article'));
    }

    public function userRender(Request $request)
    {
        $query = \App\Models\User::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Filter by admin status
        if ($request->has('filter_admin') && $request->filter_admin !== '') {
            $query->where('is_admin', $request->filter_admin);
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        return view('admin.users.index', compact('users'));
    }
}
