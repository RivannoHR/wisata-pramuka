<?php

namespace App\Http\Controllers;

use App\Models\TouristAttraction;
use App\Models\TouristAttractionImage;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TouristAttractionController extends Controller
{
    public function index(Request $request)
    {
        $query = TouristAttraction::with(['featuredImage', 'images', 'ratings'])->active();

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

        // Sorting
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');

        switch ($sortBy) {
            case 'date_added':
                $query->orderBy('created_at', $sortOrder);
                break;
            case 'rating':
                $query->withAvg('ratings', 'rating')
                      ->orderBy('ratings_avg_rating', $sortOrder);
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
        $attraction = TouristAttraction::with(['images', 'ratings.user'])
            ->active()
            ->findOrFail($id);

        // Get reviews (ratings with comments)
        $reviews = $attraction->ratings()
            ->whereNotNull('comment')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tourist-attractions.show', compact('attraction', 'reviews'));
    }

    public function storeReview(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to post a review.');
        }

        $attraction = TouristAttraction::findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Check if user already reviewed this attraction
        $existingReview = $attraction->ratings()
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            // Update existing review
            $existingReview->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
            $message = 'Your review has been updated successfully!';
        } else {
            // Create new review
            $attraction->ratings()->create([
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
            $message = 'Your review has been posted successfully!';
        }

        return redirect()->route('tourist-attractions.show', $id)
            ->with('success', $message);
    }
    public function toggleActive(TouristAttraction $touristAttraction)
    {
        $touristAttraction->is_active = !$touristAttraction->is_active;
        $touristAttraction->save();
        return redirect()->back();
    }
    public function store(Request $request)
    {

        return DB::transaction(function () use ($request) {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'type' => 'required|string|in:tourist_spot,restaurant,shop',
            'operating_hours' => 'nullable',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_text' => 'required|string|max:255',
        ];            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $validatedData = $validator->validated();
            $operatingHours = [];
            if (!empty($validatedData['operating_hours'])) {
                try {
                    $operatingHours = json_decode($validatedData['operating_hours'], true);
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Invalid operating hours format.')->withInput();
                }
            }
            $touristAttraction = TouristAttraction::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'location' => $validatedData['location'],
                'type' => $validatedData['type'],
                'operating_hours' => $operatingHours,
            ]);

            // Handle image upload
            $imageFile = $request->file('product_image');
            $imagePath = $imageFile->store('attractions/' . $touristAttraction->id, 'public');


            // Create the main image record for the new attraction
            TouristAttractionImage::create([
                'tourist_attraction_id' => $touristAttraction->id,
                'image_path' => $imagePath,
                'alt_text' => $validatedData['alt_text'],
                'sort_order' => 1,
                'is_featured' => true,
            ]);

            return redirect()->route('admin.tourist-attractions')->with('success', 'Tourist attraction created successfully!');
        });
    }
    public function apply(Request $request, TouristAttraction $touristAttraction)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string',
            'type' => 'required|string|in:tourist_spot,restaurant,shop',
            'operating_hours' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        // Decode the JSON string for operating hours
        try {
            if (isset($validatedData['operating_hours'])) {
                $validatedData['operating_hours'] = json_decode($validatedData['operating_hours'], true);
            }
        } catch (\Exception $e) {
            // Handle JSON decoding errors if necessary
            return redirect()->back()->with('error', 'Invalid operating hours format.');
        }

        $touristAttraction->update($validatedData);

        return redirect()->route('admin.tourist-attractions')->with('success', 'Tourist attraction updated successfully.');
    }
    public function delete(TouristAttraction $touristAttraction)
    {
        Storage::disk('public')->delete('tourist-attraction/' . $touristAttraction->id);
        $touristAttraction->delete();
        return redirect()->back();
    }
    public function deleteAll()
    {
        Storage::disk('public')->deleteDirectory('tourist-attractions');
        TouristAttraction::truncate();
        Storage::disk('public')->makeDirectory('tourist-attractions');
        return redirect()->back();
    }
}
