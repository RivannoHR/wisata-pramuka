<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Accommodation;
use App\Models\TouristAttraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ratable_type' => 'required|string|in:App\Models\Accommodation,App\Models\TouristAttraction',
            'ratable_id' => 'required|integer'
        ]);

        // Validate that the ratable entity exists
        $ratableClass = $request->ratable_type;
        $ratable = $ratableClass::findOrFail($request->ratable_id);

        // Create or update the rating
        Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'ratable_type' => $request->ratable_type,
                'ratable_id' => $request->ratable_id,
            ],
            [
                'rating' => $request->rating
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Rating submitted successfully!',
            'average_rating' => $ratable->average_rating,
            'rating_count' => $ratable->rating_count
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'ratable_type' => 'required|string|in:App\Models\Accommodation,App\Models\TouristAttraction',
            'ratable_id' => 'required|integer'
        ]);

        $rating = Rating::where([
            'user_id' => Auth::id(),
            'ratable_type' => $request->ratable_type,
            'ratable_id' => $request->ratable_id,
        ])->first();

        if ($rating) {
            $rating->delete();
            
            // Get updated averages
            $ratableClass = $request->ratable_type;
            $ratable = $ratableClass::findOrFail($request->ratable_id);

            return response()->json([
                'success' => true,
                'message' => 'Rating removed successfully!',
                'average_rating' => $ratable->average_rating,
                'rating_count' => $ratable->rating_count
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Rating not found!'
        ], 404);
    }
}
