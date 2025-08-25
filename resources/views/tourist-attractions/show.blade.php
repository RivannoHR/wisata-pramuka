@extends('app')

@section('title', $attraction->name . ' - Tourist Attractions')

@section('content')
<style>
    .attraction-detail-container {
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

    .attraction-header {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .attraction-image-main {
        width: 100%;
        height: 400px;
        background-size: cover;
        background-position: center;
        background-color: #f0f0f0;
        position: relative;
    }

    .attraction-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
        color: white;
        padding: 30px;
    }

    .attraction-title {
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .attraction-meta {
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

    .type-badge.tourist_spot {
        background: rgba(40, 167, 69, 0.9);
    }

    .type-badge.restaurant {
        background: rgba(255, 193, 7, 0.9);
        color: #333;
    }

    .type-badge.shop {
        background: rgba(220, 53, 69, 0.9);
    }

    .attraction-content {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

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

    .rating-display {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.2rem;
    }

    .stars {
        display: flex;
        gap: 2px;
    }

    .star {
        color: #ffc107;
    }

    .star.empty {
        color: #ddd;
    }

    .operating-hours {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid #007bff;
    }

    .hours-list {
        list-style: none;
        padding: 0;
        margin: 10px 0 0 0;
    }

    .hours-list li {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .hours-list li:last-child {
        border-bottom: none;
    }

    .day {
        font-weight: 500;
    }

    .no-info {
        color: #999;
        font-style: italic;
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
        min-width: 80px;
        height: 80px;
        background-size: cover;
        background-position: center;
        border-radius: 8px;
        cursor: pointer;
        border: 3px solid transparent;
        transition: border-color 0.3s, transform 0.3s;
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

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 20px;
        font-size: 20px;
        cursor: pointer;
        z-index: 1001;
    }

    .lightbox-nav:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .lightbox-prev {
        left: 20px;
    }

    .lightbox-next {
        right: 20px;
    }

    @media (max-width: 768px) {
        .attraction-title {
            font-size: 2rem;
        }
        
        .attraction-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .attraction-content {
            padding: 20px;
        }
    }
</style>

<div class="attraction-detail-container">
    <a href="{{ route('tourist-attractions.index') }}" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Back to Tourist Attractions
    </a>

    <div class="attraction-header">
        <div class="attraction-image-main" style="background-image: url('{{ $attraction->main_image }}')">
            <div class="attraction-overlay">
                <h1 class="attraction-title">{{ $attraction->name }}</h1>
                <div class="attraction-meta">
                    <div class="type-badge {{ $attraction->type }}">
                        {{ $attraction->formatted_type }}
                    </div>
                    @if($attraction->location)
                        <div class="meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $attraction->location }}
                        </div>
                    @endif
                    @if($attraction->rating)
                        <div class="meta-item">
                            <i class="fas fa-star"></i>
                            {{ number_format($attraction->rating, 1) }} Rating
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="attraction-content">
        <!-- Description Section -->
        <div class="content-section">
            <h2 class="section-title">
                <i class="fas fa-info-circle"></i>
                About This Place
            </h2>
            <p class="description-text">{{ $attraction->description }}</p>
        </div>

        <!-- Image Gallery Section -->
        @if($attraction->images->count() > 0)
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-images"></i>
                    Photo Gallery
                </h2>
                <div class="image-gallery">
                    <div class="gallery-main-image" id="mainImage" 
                         style="background-image: url('{{ $attraction->images->first()->image_url }}')"
                         onclick="openLightbox(0)">
                    </div>
                    
                    @if($attraction->images->count() > 1)
                        <div class="gallery-thumbnails">
                            @foreach($attraction->images as $index => $image)
                                <div class="gallery-thumbnail {{ $index === 0 ? 'active' : '' }}" 
                                     style="background-image: url('{{ $image->image_url }}')"
                                     onclick="changeMainImage('{{ $image->image_url }}', {{ $index }})">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="gallery-counter">
                        <span id="imageCounter">1</span> of {{ $attraction->images->count() }} photos
                    </div>
                </div>
            </div>
        @endif

        <!-- Information Grid -->
        <div class="content-section">
            <h2 class="section-title">
                <i class="fas fa-list"></i>
                Details
            </h2>
            <div class="info-grid">
                @if($attraction->location)
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt info-icon"></i>
                        <div class="info-content">
                            <h4>Location</h4>
                            <p>{{ $attraction->location }}</p>
                        </div>
                    </div>
                @endif

                <div class="info-item">
                    <i class="fas fa-tag info-icon"></i>
                    <div class="info-content">
                        <h4>Category</h4>
                        <p>{{ $attraction->formatted_type }}</p>
                    </div>
                </div>

                @if($attraction->rating)
                    <div class="info-item">
                        <i class="fas fa-star info-icon"></i>
                        <div class="info-content">
                            <h4>Rating</h4>
                            <div class="rating-display">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star star {{ $i <= $attraction->rating ? '' : 'empty' }}"></i>
                                    @endfor
                                </div>
                                <span>{{ number_format($attraction->rating, 1) }}/5</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="info-item">
                    <i class="fas fa-calendar info-icon"></i>
                    <div class="info-content">
                        <h4>Added</h4>
                        <p>{{ $attraction->created_at->format('F j, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Operating Hours Section -->
        @if($attraction->operating_hours && count($attraction->operating_hours) > 0)
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-clock"></i>
                    Operating Hours
                </h2>
                <div class="operating-hours">
                    <ul class="hours-list">
                        @foreach($attraction->operating_hours as $day => $hours)
                            <li>
                                <span class="day">{{ ucfirst($day) }}</span>
                                <span>{{ $hours ?: 'Closed' }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Lightbox -->
@if($attraction->images->count() > 0)
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        @if($attraction->images->count() > 1)
            <button class="lightbox-nav lightbox-prev" onclick="event.stopPropagation(); changeLightboxImage(-1)">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="lightbox-nav lightbox-next" onclick="event.stopPropagation(); changeLightboxImage(1)">
                <i class="fas fa-chevron-right"></i>
            </button>
        @endif
        <img class="lightbox-content" id="lightboxImage" onclick="event.stopPropagation()">
    </div>

    <script>
        const images = @json($attraction->images->map(function($image) {
            return $image->image_url;
        }));
        
        let currentImageIndex = 0;

        function changeMainImage(imageUrl, index) {
            document.getElementById('mainImage').style.backgroundImage = `url('${imageUrl}')`;
            document.getElementById('imageCounter').textContent = index + 1;
            currentImageIndex = index;
            
            // Update active thumbnail
            document.querySelectorAll('.gallery-thumbnail').forEach((thumb, i) => {
                thumb.classList.toggle('active', i === index);
            });
        }

        function openLightbox(index) {
            currentImageIndex = index;
            document.getElementById('lightboxImage').src = images[index];
            document.getElementById('lightbox').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function changeLightboxImage(direction) {
            currentImageIndex += direction;
            
            if (currentImageIndex >= images.length) {
                currentImageIndex = 0;
            } else if (currentImageIndex < 0) {
                currentImageIndex = images.length - 1;
            }
            
            document.getElementById('lightboxImage').src = images[currentImageIndex];
            
            // Update main gallery to match
            changeMainImage(images[currentImageIndex], currentImageIndex);
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('lightbox').style.display === 'block') {
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    changeLightboxImage(-1);
                } else if (e.key === 'ArrowRight') {
                    changeLightboxImage(1);
                }
            }
        });
    </script>
@endif
@endsection
