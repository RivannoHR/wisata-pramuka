<?php

namespace App\Http\Controllers;

use App\Models\TouristAttraction;
use Illuminate\Http\Request;

class TouristAttractionController extends Controller
{
    public function index(Request $request)
    {
        $query = TouristAttraction::with(['featuredImage', 'images'])->active();

        // Filter by type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->byType($request->type);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        // Sorting
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');

        switch ($sortBy) {
            case 'date_added':
                $query->orderBy('created_at', $sortOrder);
                break;
            case 'rating':
                $query->orderBy('rating', $sortOrder);
                break;
            case 'name':
            default:
                $query->orderBy('name', $sortOrder);
                break;
        }

        // Get page number for infinite scroll
        $page = $request->get('page', 1);
        $perPage = 20;
        
        $attractions = $query->paginate($perPage, ['*'], 'page', $page);

        // Get unique types for filter dropdown
        $types = [
            'all' => 'All Types',
            'tourist_spot' => 'Tourist Spot',
            'restaurant' => 'Restaurant',
            'shop' => 'Shop'
        ];

        // If it's an AJAX request, return only the attraction cards
        if ($request->ajax()) {
            return response()->json([
                'html' => view('tourist-attractions.partials.attraction-cards', compact('attractions'))->render(),
                'hasMore' => $attractions->hasMorePages(),
                'nextPage' => $attractions->currentPage() + 1
            ]);
        }

        return view('tourist-attractions.index', compact('attractions', 'types'));
    }

    public function show($id)
    {
        $attraction = TouristAttraction::with('images')->active()->findOrFail($id);
        
        return view('tourist-attractions.show', compact('attraction'));
    }
}
