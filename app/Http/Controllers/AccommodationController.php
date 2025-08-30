<?php

namespace App\Http\Controllers;

use App\Filters\GeneralFilter;
use App\Http\Requests\StoreAccommodationRequest;
use App\Models\Accommodation;
use App\Models\AccommodationImage;
use App\Models\AccommodationRoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AccommodationController extends Controller
{
    public function index(Request $request)
    {
        $query = Accommodation::with(['images', 'featuredImage'])
            ->active()
            ->leftJoin('accommodation_room_types', 'accommodations.id', '=', 'accommodation_room_types.accommodation_id')
            ->selectRaw('accommodations.*, MIN(accommodation_room_types.price) as price')
            ->groupBy('accommodations.id');

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

        $accommodation = Accommodation::with(['images', 'roomTypes'])
            ->active()
            ->selectRaw('accommodations.*, (SELECT MIN(price) FROM accommodation_room_types WHERE accommodation_id = accommodations.id) as lowest_price')
            ->findOrFail($id); 

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

            $roomImagePath = $request->file('room_image')->store('accommodations/' . $accommodation->id . '/rooms', 'public');

            $accommodationRoomType = new AccommodationRoomType([
                'accommodation_id' => $accommodation->id,
                'name' => $validated['room_name'],
                'image_path' => $roomImagePath,
                'price' => $validated['room_price'],
            ]);
            $accommodationRoomType->save();


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
