<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Accommodation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display booking history page
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        // Get bookings for the authenticated user only
        $bookingsQuery = Booking::with(['accommodation', 'user', 'review'])
            ->where('user_id', auth()->id());

        if ($status === 'pending') {
            $bookingsQuery->byStatus('pending');
        } elseif ($status === 'active') {
            $bookingsQuery->byStatus('active');
        } elseif ($status === 'history') {
            // History tab shows completed and cancelled bookings
            $bookingsQuery->whereIn('status', ['completed', 'cancelled']);
        } else {
            // Default to pending if invalid status
            $bookingsQuery->byStatus('pending');
            $status = 'pending';
        }

        $bookings = $bookingsQuery->orderBy('created_at', 'desc')->paginate(10);

        return view('bookings.index', compact('bookings', 'status'));
    }

    /**
     * Store a new booking
     */
    public function store(Request $request)
    {
        $request->validate([
            'accommodation_id' => 'required|exists:accommodations,id',
            'checkin_date' => 'required|date|after_or_equal:today',
            'checkout_date' => 'required|date|after:checkin_date',
            'rooms_count' => 'required|integer|min:1',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        // Retrieve the accommodation to get its price
        $accommodation = Accommodation::findOrFail($request->accommodation_id);

        // Calculate the duration of the stay
        $checkinDate = new \DateTime($request->checkin_date);
        $checkoutDate = new \DateTime($request->checkout_date);
        $duration = $checkinDate->diff($checkoutDate)->days;

        // Calculate the total price based on the accommodation price, duration, and number of rooms
        $totalPrice = $accommodation->price * $duration * $request->rooms_count;

        // Generate a unique booking ID
        $bookingId = $this->generateBookingId();

        $booking = Booking::create([
            'booking_id' => $bookingId,
            'user_id' => auth()->id(),
            'accommodation_id' => $request->accommodation_id,
            'rooms_count' => $request->rooms_count,
            'booking_date' => now(), // Use the current date for the booking date
            'check_in_date' => $request->checkin_date,
            'check_out_date' => $request->checkout_date,
            'duration_days' => $duration,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'special_requests' => $request->special_requests,
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully! ' . $bookingId);
    }

    /**
     * Update booking status (for user cancellation)
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,active,completed,cancelled'
        ]);
        // Check if booking belongs to the authenticated user
        if (auth()->user()->is_admin) {
            $booking->update([
                'status' => $request->status
            ]);
            
            $statusMessage = match($request->status) {
                'active' => 'Booking confirmed successfully!',
                'cancelled' => 'Booking cancelled successfully!',
                'completed' => 'Booking marked as completed!',
                default => 'Booking status updated successfully!'
            };
            
            return back()->with('success', $statusMessage);
        }

        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this booking.');
        }
        // Users can only cancel their own pending bookings
        if ($request->status === 'cancelled' && $booking->status === 'pending') {
            $booking->update([
                'status' => 'cancelled'
            ]);
            return back()->with('success', 'Booking cancelled successfully!');
        }

        return back()->with('error', 'Unable to update booking status.');
    }

    /**
     * Delete a booking (admin only)
     */
    public function destroy(Booking $booking)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $booking->delete();
        return back()->with('success', 'Booking deleted successfully!');
    }

    private function generateBookingId(): string
    {
        do {
            $number = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $bookingId = 'BK' . $number;
        } while (Booking::where('booking_id', $bookingId)->exists());

        return $bookingId;
    }
}
