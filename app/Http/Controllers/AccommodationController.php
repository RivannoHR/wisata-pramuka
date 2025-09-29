<?php

namespace App\Http\Controllers;

use App\Filters\GeneralFilter;
use App\Http\Requests\StoreAccommodationRequest;
use App\Models\Accommodation;
use App\Models\AccommodationImage;
use App\Models\Review;
use App\Traits\TrackVisits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AccommodationController extends Controller
{
    use TrackVisits;
    public function index(Request $request)
    {
        $query = Accommodation::with(['images', 'featuredImage', 'reviews'])
            ->active();

        $query = GeneralFilter::accommodation($query, $request);

        $page = $request->get('page', 1);
        $perPage = 10;
        $accommodations = $query->paginate($perPage, ['*'], 'page', $page);

        $types = [
            'all' => 'All Types',
            'hotel' => 'Hotel',
            'villa' => 'Villa',
            'guesthouse' => 'Guesthouse',
            'resort' => 'Resort',
            'homestay' => 'Homestay'
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
        $accommodation = Accommodation::with(['images', 'reviews'])
            ->active()
            ->findOrFail($id);

        // Track visit
        $this->trackVisit('accommodation', $accommodation->id, $accommodation->name);

        // Get reviews from completed bookings for this accommodation
        $reviews = Review::whereHas('booking', function($query) use ($id) {
            $query->where('accommodation_id', $id)
                  ->where('status', 'completed');
        })
        ->with(['user', 'booking'])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('accommodations.show', compact('accommodation', 'reviews'));
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
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
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
    public function store(StoreAccommodationRequest $request)
    {
        return DB::transaction(function () use ($request) {


            $validated = $request->validated();
            $facilitiesArray = collect(explode(',', $validated['facilities'] ?? ''))
                ->map(fn($item) => trim($item))
                ->filter()
                ->values()
                ->toArray();

            $accommodationData = array_merge($validated, ['facilities' => $facilitiesArray]);
            $accommodation = Accommodation::create($accommodationData);
            $imagePath = $request->file('product_image')->store('accommodations/' . $accommodation->id, 'public');
            $accommodationImage = new AccommodationImage([
                'accommodation_id' => $accommodation->id,
                'image_path' => $imagePath,
                'alt_text' => $validated['alt_text'],
                'sort_order' => 1,
            ]);
            $accommodationImage->save();

            return redirect()->route('admin.accommodations');
        });
    }
    public function delete(Accommodation $accommodation)
    {
        Storage::disk('public')->delete('accommodations/' . $accommodation->id);
        $accommodation->delete();
        return redirect()->back();
    }

    public function deleteAll()
    {
        Storage::disk('public')->deleteDirectory('accommodations');
        Accommodation::truncate();
        Storage::disk('public')->makeDirectory('accommodations');
        return redirect()->back();
    }
}
