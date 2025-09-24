@extends('app')

@section('title', 'Booking History - Pulau Pramuka')

@section('content')
<style>
    .booking-container {
        max-width: 100%;
        margin: 0;
        padding: 40px 40px 40px 60px;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .page-header p {
        font-size: 1.1rem;
        color: #6b7280;
        margin: 0;
    }

    .booking-tabs {
        display: flex;
        gap: 0;
        margin-bottom: 30px;
        border-bottom: 2px solid #e5e7eb;
    }

    .tab-button {
        padding: 12px 24px;
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        color: #6b7280;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .tab-button.active {
        color: #1a1a1a;
        border-bottom-color: #1a1a1a;
        font-weight: 600;
    }

    .tab-button:hover {
        color: #374151;
        text-decoration: none;
    }

    .booking-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .booking-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 24px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 16px;
        overflow: visible; /* Allow content to flow naturally */
        position: relative; /* Establish containing block */
    }

    .booking-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .booking-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0;
    }

    .booking-info {
        flex: 1;
    }

    .booking-id {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 4px;
    }

    .accommodation-name {
        font-size: 1.1rem;
        color: #374151;
        margin-bottom: 2px;
        font-weight: 600;
    }

    .room-type {
        font-size: 0.95rem;
        color: #6b7280;
    }

    .booking-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        margin-bottom: 0;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .detail-label {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 500;
    }

    .detail-value {
        font-size: 0.95rem;
        color: #1a1a1a;
        font-weight: 600;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-completed {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #dc2626;
    }

    .booking-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #f3f4f6;
    }

    .action-button {
        padding: 8px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: white;
        color: #374151;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .action-button:hover {
        background: #f9fafb;
        border-color: #d1d5db;
        text-decoration: none;
        color: #374151;
    }

    .action-button.primary {
        background: #1a1a1a;
        color: white;
        border-color: #1a1a1a;
    }

    .action-button.primary:hover {
        background: #374151;
        border-color: #374151;
        color: white;
    }

    .action-button.danger {
        background: #dc2626;
        color: white;
        border-color: #dc2626;
    }

    .action-button.danger:hover {
        background: #b91c1c;
        border-color: #b91c1c;
        color: white;
    }

    /* Review Styles */
    .review-section {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #f3f4f6;
        width: 100%;
        box-sizing: border-box;
    }

    .review-display {
        background: #f8fafc;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 12px;
        width: 100%;
        box-sizing: border-box;
    }

    .review-rating {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }

    .review-stars {
        color: #fbbf24;
        font-size: 1.1rem;
    }

    .review-comment {
        color: #374151;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 8px;
    }

    .review-date {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .review-form {
        background: #f8fafc;
        border-radius: 8px;
        padding: 16px;
        margin-top: 16px;
        overflow: hidden; /* Prevent content from overflowing */
    }

    .review-form-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 12px;
    }

    .rating-input {
        display: flex;
        gap: 4px;
        margin-bottom: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .star-input {
        font-size: 1.5rem;
        color: #d1d5db;
        cursor: pointer;
        transition: color 0.2s;
    }

    .star-input:hover,
    .star-input.active {
        color: #fbbf24;
    }

    .comment-input {
        width: 100%;
        min-height: 80px;
        max-height: 120px; /* Prevent excessive height */
        padding: 12px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 0.9rem;
        resize: vertical;
        margin-bottom: 12px;
        box-sizing: border-box; /* Include padding in width calculation */
        font-family: inherit;
        line-height: 1.4;
    }

    .comment-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .review-form-actions {
        display: flex;
        gap: 8px;
    }

    .review-form-actions .action-button {
        font-size: 0.85rem;
        padding: 6px 12px;
    }

    .no-bookings {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .no-bookings i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #d1d5db;
    }

    .no-bookings h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: #374151;
    }

    @media (max-width: 768px) {
        .booking-container {
            padding: 20px 15px;
        }

        .page-header h1 {
            font-size: 2rem;
        }

        .booking-header {
            flex-direction: column;
            gap: 12px;
            align-items: flex-start;
        }

        .booking-details {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .booking-actions {
            flex-direction: column;
        }

        .tab-button {
            padding: 10px 16px;
            font-size: 0.9rem;
        }

        .booking-tabs {
            flex-wrap: wrap;
        }

        /* Mobile review styles */
        .review-form {
            padding: 12px;
            margin-top: 12px;
        }

        .comment-input {
            min-height: 60px;
            max-height: 100px;
            font-size: 0.85rem;
        }

        .rating-input {
            justify-content: center;
            margin-bottom: 8px;
        }

        .review-form-actions {
            flex-direction: column;
            gap: 8px;
        }

        .review-form-actions .action-button {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="booking-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>Booking History</h1>
        <p>Track your accommodation reservations</p>
    </div>

    <!-- Status Tabs -->
    <div class="booking-tabs">
        <a href="{{ route('bookings.index', ['status' => 'pending']) }}"
            class="tab-button {{ $status === 'pending' ? 'active' : '' }}">
            Pending Booking
        </a>
        <a href="{{ route('bookings.index', ['status' => 'active']) }}"
            class="tab-button {{ $status === 'active' ? 'active' : '' }}">
            Active
        </a>
        <a href="{{ route('bookings.index', ['status' => 'history']) }}"
            class="tab-button {{ $status === 'history' ? 'active' : '' }}">
            History
        </a>
    </div>

    <!-- Booking List -->
    <div class="booking-list">
        @if($bookings->count() > 0)
        @foreach($bookings as $booking)
        <div class="booking-card">
            <div class="booking-header">
                <div class="booking-info">
                    <div class="booking-id">Booking ID: {{ $booking->booking_id }}</div>
                    <div class="accommodation-name">{{ $booking->accommodation->name }}</div>
                    <div class="room-type">Rooms Booked: {{ $booking->rooms_count }}</div>
                </div>
                <div class="status-badge status-{{ $booking->status }}">
                    {{ $booking->status_display }}
                </div>
            </div>

            <div class="booking-details">
                <div class="detail-item">
                    <div class="detail-label">Stay Period</div>
                    <div class="detail-value">{{ $booking->formatted_date_range }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Duration</div>
                    <div class="detail-value">{{ $booking->formatted_duration }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Total Price</div>
                    <div class="detail-value">{{ $booking->formatted_price }}</div>
                </div>
                @if($booking->status === 'active')
                <div class="detail-item">
                    <div class="detail-label">Guest Name</div>
                    <div class="detail-value">{{ $booking->user->name }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Contact</div>
                    <div class="detail-value">{{ $booking->user->phone ?: $booking->user->email }}</div>
                </div>
                @endif
                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">{{ $booking->status_display }}</div>
                </div>
            </div>

            {{-- Review Section for Completed Bookings --}}
            @if($booking->status === 'completed')
            <div class="review-section">
                @if($booking->review)
                    {{-- Display existing review --}}
                    <div class="review-display">
                        @if($booking->review->rating)
                        <div class="review-rating">
                            <span class="review-stars">{{ str_repeat('★', $booking->review->rating) }}{{ str_repeat('☆', 5 - $booking->review->rating) }}</span>
                            <span>({{ $booking->review->rating }}/5)</span>
                        </div>
                        @endif
                        @if($booking->review->comment)
                        <div class="review-comment">{{ $booking->review->comment }}</div>
                        @endif
                        <div class="review-date">Reviewed on {{ $booking->review->created_at->format('M d, Y') }}</div>
                    </div>
                @else
                    {{-- Review form for bookings without reviews --}}
                    <div class="review-form" id="review-form-{{ $booking->id }}">
                        <div class="review-form-title">Leave a Review</div>
                        <form method="POST" action="{{ route('bookings.review.store', $booking) }}">
                            @csrf
                            <div class="rating-input">
                                <span style="margin-right: 8px; font-size: 0.9rem; color: #6b7280;">Rating (optional):</span>
                                @for($i = 1; $i <= 5; $i++)
                                <span class="star-input" data-rating="{{ $i }}" onclick="setRating({{ $booking->id }}, {{ $i }})">☆</span>
                                @endfor
                                <input type="hidden" name="rating" id="rating-{{ $booking->id }}" value="">
                            </div>
                            <textarea 
                                name="comment" 
                                placeholder="Share your experience (optional)..."
                                class="comment-input"
                                maxlength="1000"
                            ></textarea>
                            <div class="review-form-actions">
                                <button type="submit" class="action-button primary">Submit Review</button>
                                <button type="button" class="action-button" onclick="hideReviewForm({{ $booking->id }})">Cancel</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
            @endif

            @if($booking->status === 'pending')
            <div class="booking-actions">
                <form method="POST" action="{{ route('bookings.updateStatus', $booking) }}" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="action-button danger"
                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                        <i class="fas fa-times"></i>
                        Cancel Booking
                    </button>
                </form>
            </div>
            @endif
        </div>
        @endforeach

        <!-- Pagination -->
        @if($bookings->hasPages())
        <div class="pagination-wrapper" style="margin-top: 40px;">
            {{ $bookings->withQueryString()->links() }}
        </div>
        @endif
        @else
        <div class="no-bookings">
            <i class="fas fa-calendar-times"></i>
            <h3>No {{ $status }} bookings found</h3>
            <p>
                @if($status === 'pending')
                You don't have any pending bookings at the moment.
                @elseif($status === 'active')
                You don't have any active bookings at the moment.
                @else
                Your booking history is empty.
                @endif
            </p>
        </div>
        @endif
    </div>
</div>

@if(session('success'))
<script>
    alert('{{ session('success') }}');
</script>
@endif

<script>
function setRating(bookingId, rating) {
    // Update hidden input
    document.getElementById('rating-' + bookingId).value = rating;
    
    // Update star display
    const stars = document.querySelectorAll(`#review-form-${bookingId} .star-input`);
    stars.forEach((star, index) => {
        if (index < rating) {
            star.textContent = '★';
            star.classList.add('active');
        } else {
            star.textContent = '☆';
            star.classList.remove('active');
        }
    });
}

function hideReviewForm(bookingId) {
    const form = document.getElementById('review-form-' + bookingId);
    if (form) {
        form.style.display = 'none';
    }
}

// Initialize star hover effects
document.addEventListener('DOMContentLoaded', function() {
    const starInputs = document.querySelectorAll('.star-input');
    starInputs.forEach(star => {
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            const formId = this.closest('.review-form').id;
            const bookingId = formId.replace('review-form-', '');
            const stars = document.querySelectorAll(`#${formId} .star-input`);
            
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.textContent = '★';
                } else {
                    s.textContent = '☆';
                }
            });
        });
        
        star.addEventListener('mouseleave', function() {
            const formId = this.closest('.review-form').id;
            const bookingId = formId.replace('review-form-', '');
            const currentRating = document.getElementById('rating-' + bookingId).value;
            const stars = document.querySelectorAll(`#${formId} .star-input`);
            
            stars.forEach((s, index) => {
                if (currentRating && index < parseInt(currentRating)) {
                    s.textContent = '★';
                } else {
                    s.textContent = '☆';
                }
            });
        });
    });
});
</script>
@endsection