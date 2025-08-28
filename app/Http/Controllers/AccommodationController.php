<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccommodationController extends Controller
{
    public function index(Request $request)
    {
        $query = Accommodation::with(['images', 'featuredImage'])->active();

        // Filter by type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->byType($request->type);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        // Filter by capacity
        if ($request->filled('capacity')) {
            $capacity = $request->get('capacity');
            $query->where('capacity', '>=', $capacity);
        }

        // Sorting
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');

        switch ($sortBy) {
            case 'price':
                $query->orderBy('price_per_night', $sortOrder);
                break;
            case 'rating':
                $query->orderBy('rating', $sortOrder);
                break;
            case 'capacity':
                $query->orderBy('capacity', $sortOrder);
                break;
            case 'name':
            default:
                $query->orderBy('name', $sortOrder);
                break;
        }

        // Get page number for infinite scroll
        $page = $request->get('page', 1);
        $perPage = 10;

        $accommodations = $query->paginate($perPage, ['*'], 'page', $page);

        // Get unique types for filter dropdown
        $types = [
            'all' => 'All Types',
            'hotel' => 'Hotel',
            'villa' => 'Villa',
            'guesthouse' => 'Guesthouse',
            'resort' => 'Resort'
        ];

        // If it's an AJAX request, return only the accommodation cards
        if ($request->ajax()) {
            return response()->json([
                'html' => view('accommodations.partials.accommodation-cards', compact('accommodations'))->render(),
                'hasMore' => $accommodations->hasMorePages(),
                'nextPage' => $accommodations->currentPage() + 1
            ]);
        }

        return view('accommodations.index', compact('accommodations', 'types'));
    }

    public function show($id)
    {
        $accommodation = Accommodation::with(['images', 'featuredImage'])->active()->findOrFail($id);

        return view('accommodations.show', compact('accommodation'));
    }
    public function toggleActive(Accommodation $accommodation)
    {
        $accommodation->is_active = !$accommodation->is_active;
        $accommodation->save();
        return redirect()->back();
    }
    public function apply(Request $request, Accommodation $accommodation)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:hotel,villa,guesthouse,resort',
            'location' => 'nullable|string',
            'rating' => 'nullable|min:0|max:5',
            'capacity' => 'required|integer|min:1',
            'facilities' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $validatedData = $validator->validated();
        $facilitiesArray = collect(explode(',', $validatedData['facilities'] ?? ''))
            ->map(fn($item) => trim($item))
            ->filter()
            ->values()
            ->toArray();
        $validatedData['facilities'] = $facilitiesArray;
        $accommodation->update($validatedData);
        return redirect()->route('admin.accommodations');
    }
}
