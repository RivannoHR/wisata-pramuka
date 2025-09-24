<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Booking $booking)
    {
        // Validate that the booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this booking.');
        }

        // Validate that the booking is completed
        if ($booking->status !== 'completed') {
            return redirect()->back()->with('error', 'You can only review completed bookings.');
        }

        // Check if review already exists
        if ($booking->review) {
            return redirect()->back()->with('error', 'You have already reviewed this booking.');
        }

        // Validate the request
        $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Ensure at least one field is provided
        if (!$request->rating && !$request->comment) {
            return redirect()->back()->with('error', 'Please provide either a rating or a comment.');
        }

        // Create the review
        Review::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Thank you for your review!');
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Review $review)
    {
        // Validate that the review belongs to the authenticated user
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this review.');
        }

        // Validate the request
        $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Ensure at least one field is provided
        if (!$request->rating && !$request->comment) {
            return redirect()->back()->with('error', 'Please provide either a rating or a comment.');
        }

        // Update the review
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Your review has been updated!');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        // Validate that the review belongs to the authenticated user
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this review.');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Your review has been deleted.');
    }

    /**
     * Display reviews for an accommodation
     */
    public function accommodationReviews($accommodationId)
    {
        $reviews = Review::whereHas('booking', function($query) use ($accommodationId) {
            $query->where('accommodation_id', $accommodationId);
        })->with(['user', 'booking.accommodation'])->latest()->paginate(10);

        return view('reviews.accommodation', compact('reviews', 'accommodationId'));
    }
}
