@extends('app')

@section('title', $accommodation->name . ' - Accommodations')

@section('content')
<style>
    .accommodation-detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: black;
        text-decoration: none;
        margin-bottom: 20px;
        font-weight: 500;
        transition: color 0.3s;
    }

    .back-button:hover {
        color: black;
    }

    .accommodation-header {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .accommodation-image-main {
        width: 100%;
        height: 400px;
        background-size: cover;
        background-position: center;
        background-color: #f0f0f0;
        position: relative;
    }

    .accommodation-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
        color: white;
        padding: 30px;
    }

    .accommodation-title {
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .accommodation-meta {
        display: flex;
        gap: 20px;
        align-items: center;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 1rem;
    }

    .type-badge {
        background: rgba(0, 123, 255, 0.9);
        color: white;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .type-badge {
        background: rgba(0, 123, 255, 0.9);
        color: white;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .accommodation-content {
        background: white;
        border-radius: 12px;
        padding: 0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Tab Navigation Styles */
    .tab-navigation {
        display: flex;
        border-bottom: 1px solid #e5e7eb;
        background: white;
        border-radius: 12px 12px 0 0;
    }

    .tab-button {
        flex: 1;
        padding: 20px;
        background: none;
        border: none;
        font-size: 1.1rem;
        font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .tab-button.active {
        color: #000000;
    }

    .tab-button.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: #000000;
        border-radius: 3px 3px 0 0;
    }

    .tab-button:hover {
        color: #000000;
        background: #f8fafc;
    }

    .tab-content {
        display: none;
        padding: 30px;
        animation: fadeIn 0.3s ease-in-out;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Review Styles */
    .review-item {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .review-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .review-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .review-user {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .review-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #000000, #333333);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .review-user-info h4 {
        margin: 0;
        font-size: 1.1rem;
        color: #1f2937;
    }

    .review-date {
        color: #6b7280;
        font-size: 0.9rem;
    }

    .review-rating {
        display: flex;
        gap: 2px;
    }

    .star {
        color: #fbbf24;
        font-size: 1.1rem;
    }

    .star.empty {
        color: #e5e7eb;
    }

    .review-comment {
        color: #374151;
        line-height: 1.6;
        font-size: 1rem;
    }

    .no-reviews {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .no-reviews i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #e5e7eb;
    }

    /* Tourist-attraction style reviews (unified) */
    .reviews-section { max-width: 100%; }
    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f0f0f0;
    }
    .reviews-summary { display: flex; align-items: center; gap: 15px; }
    .rating-overview { text-align: center; }
    .rating-score { font-size: 2.5rem; font-weight: 700; color: black; line-height: 1; }
    .rating-stars { color: #ffc107; margin: 5px 0; }
    .rating-count { color: #666; font-size: 0.9rem; }
    .auth-message {
        background: #e7f3ff; border: 1px solid #b3d9ff; color: #0066cc;
        padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;
    }
    .auth-message a { color: #0066cc; font-weight: 500; text-decoration: none; }
    .auth-message a:hover { text-decoration: underline; }
    .reviews-list { display: flex; flex-direction: column; gap: 20px; }
    .review-card { background: white; padding: 25px; border-radius: 12px; border: 1px solid #f0f0f0; }
    .review-card .review-header { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; }
    .reviewer-avatar { width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.2rem; }
    .review-info h4 { margin: 0 0 5px 0; font-weight: 600; color: #333; }
    .review-meta { display: flex; align-items: center; gap: 10px; color: #666; font-size: 0.9rem; }
    .review-text { line-height: 1.6; color: #555; }

    .content-section {
        margin-bottom: 30px;
    }

    .content-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .description-text {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #555;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .info-icon {
        color: #007bff;
        margin-top: 2px;
        width: 20px;
    }

    .info-content h4 {
        margin: 0 0 5px 0;
        font-weight: 600;
        color: #333;
    }

    .info-content p {
        margin: 0;
        color: #666;
    }

    .facilities-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }

    .facility-item {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #374151;
        font-size: 1rem;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .facility-icon {
        color: #007bff;
        width: 20px;
    }

    /* Image Gallery Styles */
    .image-gallery {
        margin-bottom: 30px;
    }

    .gallery-main-image {
        width: 100%;
        height: 400px;
        background-size: cover;
        background-position: center;
        border-radius: 12px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: transform 0.3s;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .gallery-main-image:hover {
        transform: scale(1.02);
    }

    .gallery-thumbnails {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding: 10px 0;
    }

    .gallery-thumbnail {
        min-width: 100px;
        width: 100px;
        height: 80px;
        background-size: cover;
        background-position: center;
        border-radius: 8px;
        cursor: pointer;
        border: 3px solid transparent;
        transition: border-color 0.3s, transform 0.3s;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .gallery-thumbnail:hover {
        transform: scale(1.05);
    }

    .gallery-thumbnail.active {
        border-color: #007bff;
    }

    .gallery-counter {
        text-align: center;
        color: #666;
        font-size: 0.9rem;
        margin-top: 10px;
    }

    /* Lightbox Styles */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
    }

    .lightbox-content {
        position: relative;
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 90%;
        top: 50%;
        transform: translateY(-50%);
    }

    .lightbox-close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #fff;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        z-index: 1001;
    }

    .lightbox-close:hover {
        opacity: 0.7;
    }

    .lightbox-close:hover {
        opacity: 0.7;
    }

    .reservation-form {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 30px;
        margin-top: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-weight: 600;
        color: #374151;
        font-size: 0.9rem;
    }

    .form-control {
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        background: white;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
    }

    .select-wrapper {
        position: relative;
    }

    .select-wrapper select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px;
        padding-right: 40px;
    }

    .reservation-button {
        width: 100%;
        background: #1a1a1a;
        color: white;
        border: none;
        padding: 16px 24px;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
    }

    .reservation-button:hover {
        background: #374151;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .room-image-container {
        position: relative;
        width: 100%;
        /* The height will be determined by the image's aspect ratio */
    }

    .room-image {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
        border-radius: 8px;
        /* Assuming you want to match the form control border radius */
    }

    .room-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 8px;
        background-image: linear-gradient(rgba(115, 115, 115, 0) 15%, rgba(0, 0, 0, 0.75) 100%);
    }

    .room-price-tag {
        position: absolute;
        bottom: 10px;
        left: 10px;
        color: white;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    @media (max-width: 768px) {
        .accommodation-detail-container {
            padding: 20px 10px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .accommodation-title {
            font-size: 2rem;
        }

        .gallery-thumbnails {
            flex-wrap: wrap;
        }

        .gallery-thumbnail {
            min-width: 80px;
            width: 80px;
            height: 60px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .facilities-list {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="accommodation-detail-container">
    <a href="{{ route('accommodations.index') }}" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Back to Accommodations
    </a>

    <div class="accommodation-header">
        <div class="accommodation-image-main" style="background-image: url('{{ $accommodation->main_image }}')">
            <div class="accommodation-overlay">
                <h1 class="accommodation-title">{{ $accommodation->name }}</h1>
                <div class="accommodation-meta">
                    <div class="type-badge">
                        Accommodation
                    </div>
                    @if($accommodation->location)
                    <div class="meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $accommodation->location }}
                    </div>
                    @endif
                    @if($accommodation->price)
                    <div class="meta-item">
                        <i class="fas fa-tag"></i>
                        Rp {{ number_format($accommodation->price, 0, ',', '.') }}/night
                    </div>
                    @endif
                    @if($accommodation->capacity)
                    <div class="meta-item">
                        <i class="fas fa-users"></i>
                        Up to {{ $accommodation->capacity }} guests
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="accommodation-content">
        <!-- Tab Navigation -->
        <div class="tab-navigation">
            <button class="tab-button active" onclick="showTab('details')">
                <i class="fas fa-info-circle"></i> Details
            </button>
            <button class="tab-button" onclick="showTab('reviews')">
                <i class="fas fa-star"></i> Reviews ({{ $reviews->count() }})
            </button>
        </div>

        <!-- Details Tab Content -->
        <div id="details-tab" class="tab-content active">
        <!-- Description Section -->
        @if($accommodation->description)
        <div class="content-section">
            <h2 class="section-title">
                <i class="fas fa-info-circle"></i>
                About This Place
            </h2>
            <p class="description-text">{{ $accommodation->description }}</p>
        </div>
        @endif

        <!-- Image Gallery Section -->
        <div class="content-section">
            <h2 class="section-title">
                <i class="fas fa-images"></i>
                Room Gallery
            </h2>
            <div class="image-gallery">
                @if($accommodation->images->count() > 0)
                <div class="gallery-main-image" id="mainImage"
                    style="background-image: url('{{ asset('storage/' . $accommodation->images->first()->image_path) }}')"
                    onclick="openLightbox(0)">
                </div>

                <div class="gallery-thumbnails">
                    @foreach($accommodation->images as $index => $image)
                    <div class="gallery-thumbnail {{ $index === 0 ? 'active' : '' }}"
                        style="background-image: url('{{ asset('storage/' . $image->image_path) }}')"
                        onclick="changeMainImage('{{ asset('storage/' . $image->image_path) }}', {{ $index }})">
                    </div>
                    @endforeach
                </div>

                <div class="gallery-counter">
                    <span id="imageCounter">1</span> of {{ $accommodation->images->count() }} images
                </div>
                @else
                <!-- Fallback to main_image if no images relationship -->
                <div class="gallery-main-image" id="mainImage"
                    style="background-image: url('{{ $accommodation->main_image }}')"
                    onclick="openLightbox(0)">
                    @if(!$accommodation->main_image)
                    No Image Available
                    @endif
                </div>

                <div class="gallery-thumbnails">
                    <div class="gallery-thumbnail active"
                        style="background-image: url('{{ $accommodation->main_image }}')"
                        onclick="changeMainImage('{{ $accommodation->main_image }}', 0)">
                        @if(!$accommodation->main_image)
                        Room 1
                        @endif
                    </div>
                </div>

                <div class="gallery-counter">
                    <span id="imageCounter">1</span> of 1 image
                </div>
                @endif
            </div>
        </div>

        <!-- Information Grid -->
        <div class="content-section">
            <h2 class="section-title">
                <i class="fas fa-list"></i>
                Details
            </h2>
            <div class="info-grid">
                @if($accommodation->location)
                <div class="info-item">
                    <i class="fas fa-map-marker-alt info-icon"></i>
                    <div class="info-content">
                        <h4>Location</h4>
                        <p>{{ $accommodation->location }}</p>
                    </div>
                </div>
                @endif

                @if($accommodation->lowest_price)
                <div class="info-item">
                    <i class="fas fa-tag info-icon"></i>
                    <div class="info-content">
                        <h4>Starting rate</h4>
                        <p>Rp {{ $accommodation->lowest_price }}</p>
                    </div>
                </div>
                @endif

                @if($accommodation->capacity)
                <div class="info-item">
                    <i class="fas fa-users info-icon"></i>
                    <div class="info-content">
                        <h4>Capacity</h4>
                        <p>Up to {{ $accommodation->capacity }} guests</p>
                    </div>
                </div>
                @endif

                @if($accommodation->average_rating || $accommodation->rating_count > 0)
                    <div class="info-item">
                        <i class="fas fa-star info-icon"></i>
                        <div class="info-content">
                            <h4>Rating</h4>
                            <div class="rating-display">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star star {{ $i <= $accommodation->average_rating ? '' : 'empty' }}"></i>
                                    @endfor
                                </div>
                                <span>{{ number_format($accommodation->average_rating, 1) }}/5 ({{ $accommodation->rating_count }} {{ $accommodation->rating_count == 1 ? 'review' : 'reviews' }})</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="info-item">
                        <i class="fas fa-star info-icon"></i>
                        <div class="info-content">
                            <h4>Rating</h4>
                            <div class="rating-display">
                                <span>N/A (No ratings yet)</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="info-item">
                    <i class="fas fa-calendar info-icon"></i>
                    <div class="info-content">
                        <h4>Added</h4>
                        <p>{{ $accommodation->created_at->format('F j, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Facilities Section -->
        @if($accommodation->facilities && count($accommodation->facilities) > 0)
        <div class="content-section">
            <h2 class="section-title">
                <i class="fas fa-star"></i>
                Facilities & Amenities
            </h2>
            <div class="facilities-list">
                @foreach($accommodation->facilities as $facility)
                <div class="facility-item">
                    <i class="fas fa-check facility-icon"></i>
                    {{ $facility }}
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Reservation Form Section -->
        <div class="content-section">
            <h2 class="section-title">
                <i class="fas fa-calendar-plus"></i>
                Make a Reservation
            </h2>
            <div class="reservation-form">
                <form id="reservationForm" method="POST" action="{{ route('bookings.store') }}">
                    @csrf
                    <input type="hidden" name="accommodation_id" value="{{ $accommodation->id }}">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="checkin_date">Check-in Date</label>
                            <input type="date" class="form-control" id="checkin_date" name="checkin_date" required>
                        </div>
                        <div class="form-group">
                            <label for="checkout_date">Check-out Date</label>
                            <input type="date" class="form-control" id="checkout_date" name="checkout_date" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Price per Night:</label>
                            <div class="price-display">
                                <span class="price-amount">Rp {{ number_format($accommodation->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="rooms_count">Number of Rooms</label>
                            <input type="number" name="rooms_count" id="rooms_count" class="form-control" value="1" min="1" required>
                        </div>
                        <div class=" form-group">
                            <label for="special_requests">Special Requests (Optional)</label>
                            <textarea class="form-control" id="special_requests" name="special_requests" rows="3" placeholder="Any special requests or notes..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="reservation-button">
                        <i class="fas fa-calendar-check"></i>
                        Make Reservation
                    </button>
                </form>
            </div>
        </div>
        </div>

        <!-- Reviews Tab Content (unified with Tourist Attractions style) -->
        <div id="reviews-tab" class="tab-content">
            <div class="reviews-section">
                <div class="reviews-header">
                    <h2 class="section-title">
                        <i class="fas fa-star"></i>
                        Reviews
                    </h2>
                    @if($reviews->count() > 0)
                    <div class="reviews-summary">
                        <div class="rating-overview">
                            <div class="rating-score">{{ number_format($accommodation->average_rating, 1) }}</div>
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star star {{ $i <= $accommodation->average_rating ? '' : 'empty' }}"></i>
                                @endfor
                            </div>
                            <div class="rating-count">{{ $accommodation->rating_count }} {{ Str::plural('review', $accommodation->rating_count) }}</div>
                        </div>
                    </div>
                    @endif
                </div>

                @guest
                <div class="auth-message">
                    <p>Please <a href="{{ route('login') }}">login</a> to post a review.</p>
                </div>
                @endguest

                @if($reviews->count() > 0)
                <div class="reviews-list">
                    @foreach($reviews as $review)
                    <div class="review-card">
                        <div class="review-header">
                            <div class="reviewer-avatar">{{ strtoupper(substr($review->user->name, 0, 1)) }}</div>
                            <div class="review-info">
                                <h4>{{ $review->user->name }}</h4>
                                <div class="review-meta">
                                    <span class="review-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star star {{ $i <= $review->rating ? '' : 'empty' }}"></i>
                                        @endfor
                                    </span>
                                    <span>•</span>
                                    <span>{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        @if($review->comment)
                        <p class="review-text">{{ $review->comment }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="no-reviews">
                    <i class="fas fa-comment-slash"></i>
                    <h3>No reviews yet</h3>
                    <p>Be the first to share your experience!</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Lightbox -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    <img class="lightbox-content" id="lightboxImage" src="" alt="">
</div>

<script>
    let currentImageIndex = 0;
const images = [
        @if($accommodation->images->count() > 0)
            @foreach($accommodation->images as $image)
                '{{ asset('storage/' . $image->image_path) }}',
            @endforeach
        @else
            '{{ $accommodation->main_image }}',
        @endif
    ];

    function changeMainImage(imageUrl, index) {
        const mainImage = document.getElementById('mainImage');
        mainImage.style.backgroundImage = `url('${imageUrl}')`;

        // Update active thumbnail
        document.querySelectorAll('.gallery-thumbnail').forEach(thumb => thumb.classList.remove('active'));
        document.querySelectorAll('.gallery-thumbnail')[index].classList.add('active');

        // Update counter
        document.getElementById('imageCounter').textContent = index + 1;
        currentImageIndex = index;
    }

    function openLightbox(index) {
        currentImageIndex = index;
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightboxImage');

        lightboxImage.src = images[index];
        lightbox.style.display = 'block';
    }

    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
    }

    // Tab switching functionality
    function showTab(tabName) {
        // Hide all tab contents
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(content => {
            content.classList.remove('active');
        });

        // Remove active class from all tab buttons
        const tabButtons = document.querySelectorAll('.tab-button');
        tabButtons.forEach(button => {
            button.classList.remove('active');
        });

        // Show selected tab content
        document.getElementById(tabName + '-tab').classList.add('active');
        
        // Add active class to clicked tab button
        event.target.classList.add('active');
    }

    // Form submission and date validation
    document.getElementById('reservationForm').addEventListener('submit', function(e) {
        const checkinDate = document.getElementById('checkin_date').value;
        const checkoutDate = document.getElementById('checkout_date').value;

        if (!checkinDate || !checkoutDate) {
            e.preventDefault();
            alert('Please fill in all required fields');
            return;
        }

        // Validate dates
        const checkin = new Date(checkinDate);
        const checkout = new Date(checkoutDate);
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        if (checkin < today) {
            e.preventDefault();
            alert('Check-in date cannot be in the past');
            return;
        }

        if (checkout <= checkin) {
            e.preventDefault();
            alert('Check-out date must be after check-in date');
            return;
        }

        // Calculate duration and add to form
        const duration = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));
        const durationInput = document.createElement('input');
        durationInput.type = 'hidden';
        durationInput.name = 'duration_days';
        durationInput.value = duration;
        this.appendChild(durationInput);
    });

    // Date input event listeners for validation
    document.getElementById('checkin_date').addEventListener('change', function() {
        const checkinDate = this.value;
        const checkoutInput = document.getElementById('checkout_date');

        if (checkinDate) {
            // Set minimum check-out date to the day after check-in
            const minCheckout = new Date(checkinDate);
            minCheckout.setDate(minCheckout.getDate() + 1);
            checkoutInput.min = minCheckout.toISOString().split('T')[0];

            // Clear check-out if it's now invalid
            if (checkoutInput.value && new Date(checkoutInput.value) <= new Date(checkinDate)) {
                checkoutInput.value = '';
            }
        }
    });

    // Set default minimum dates
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('checkin_date').min = today;

    // Close lightbox with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
</script>

<style>
    .rating-display .stars {
        display: flex;
        gap: 2px;
        margin-bottom: 4px;
    }
    
    .rating-display .star {
        color: #f59e0b;
        font-size: 14px;
    }
    
    .rating-display .star.empty {
        color: #d1d5db;
    }
</style>

<script>
</style>

<script>
    // Form submission and date validation
</script>

@endsection