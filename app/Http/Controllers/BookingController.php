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
        $bookingsQuery = Booking::with(['accommodation', 'user'])
            ->where('user_id', auth()->id());
        
        if ($status === 'pending') {
            $bookingsQuery->byStatus('pending');
        } elseif ($status === 'active') {
            $bookingsQuery->byStatus('active');
        } elseif ($status === 'history') {
            // History tab shows cancelled bookings
            $bookingsQuery->byStatus('cancelled');
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
            'room_type' => 'required|string',
            'booking_date' => 'required|date|after_or_equal:today',
        ]);

        $accommodation = Accommodation::findOrFail($request->accommodation_id);
        
        // Generate unique booking ID
        $bookingId = $this->generateBookingId();
        
        // Calculate total price (for now, use accommodation price)
        $totalPrice = $accommodation->price_per_night ?? 500000;

        $booking = Booking::create([
            'booking_id' => $bookingId,
            'user_id' => auth()->id(),
            'accommodation_id' => $request->accommodation_id,
            'room_type' => $request->room_type,
            'booking_date' => $request->booking_date,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $request->notes
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully! Booking ID: ' . $bookingId);
    }

    /**
     * Update booking status (for user cancellation)
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        // Check if booking belongs to the authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this booking.');
        }
        
        $request->validate([
            'status' => 'required|in:pending,active,cancelled'
        ]);

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
     * Generate unique booking ID
     */
    private function generateBookingId(): string
    {
        do {
            $number = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $bookingId = 'BK' . $number;
        } while (Booking::where('booking_id', $bookingId)->exists());

        return $bookingId;
    }
}
