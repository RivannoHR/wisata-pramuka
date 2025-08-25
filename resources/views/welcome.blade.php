@extends('app')

@section('title', 'Discover Pulau Pramuka - Your Gateway to Paradise')

@section('hero_content')
<div class="hero-content">
    <h1>Discover the Hidden Gems of Pulau Pramuka</h1>
    <p>Experience pristine beaches, crystal-clear waters, and unforgettable adventures in Indonesia's marine paradise.</p>
</div>
@endsection

@section('content')
<section class="products-section">
    <div class="section-header">
        <i class="fas fa-map-marker-alt icon-circle"></i>
        <h2>Discover Our Specialties</h2>
    </div>

    {{-- Carousel Container --}}
    <div class="carousel-container">
        @if($products->count() > 0)
        <button class="carousel-button prev" onclick="moveCarousel(-1)">❮</button>

        <div class="carousel-track">
            @foreach($products as $product)
            <div class="carousel-slide">
                <div class="product-point-item">
                    <div class="product-content">
                        <h3>{{ $product->title }}</h3>
                        <p>{{ $product->description }}</p>
                        <div class="product-actions">
                            <a href="{{ route('products.show', $product->product_id) }}" class="product-button">
                                View Details
                            </a>
                        </div>
                    </div>
                    @if($product->image_path)
                    <div class="product-image">
                        <img src="{{ asset('images/' . $product->image_path) }}" alt="{{ $product->title }}">
                    </div>
                    @else
                    <div class="product-image placeholder">
                        <div class="placeholder-text">No Image</div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <button class="carousel-button next" onclick="moveCarousel(1)">❯</button>

        {{-- Carousel Navigation Dots --}}
        <div class="carousel-dots">
            @foreach($products as $index => $product)
            <span class="dot {{ $index === 0 ? 'active' : '' }}"
                onclick="goToSlide({{ $index }})"></span>
            @endforeach
        </div>
        @else
        <p>No products found.</p>
        @endif
    </div>
</section>

{{-- Top Accommodations Section --}}
<section class="accommodations-section">
    <div class="section-header">
        <i class="fas fa-bed icon-circle"></i>
        <h2>Comfortable Accommodations</h2>
    </div>

    <div class="cards-grid">
        @if($accommodations->count() > 0)
        @foreach($accommodations as $accommodation)
        <div class="feature-card">
            <div class="card-image">
                @if($accommodation->main_image)
                <img src="{{ $accommodation->main_image }}" alt="{{ $accommodation->name }}">
                @else
                <div class="placeholder-image">
                    <i class="fas fa-bed"></i>
                </div>
                @endif
            </div>
            <div class="card-content">
                <h3>{{ $accommodation->name }}</h3>
                <p class="card-location">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $accommodation->location ?? 'Pulau Pramuka' }}
                </p>
                <p class="card-description">{{ Str::limit($accommodation->description, 100) }}</p>
                <div class="card-meta">
                    @if($accommodation->capacity)
                    <span class="meta-item">
                        <i class="fas fa-users"></i>
                        Up to {{ $accommodation->capacity }} guests
                    </span>
                    @endif
                    @if($accommodation->price_per_night)
                    <span class="meta-price">
                        Rp {{ number_format($accommodation->price_per_night, 0, ',', '.') }}/night
                    </span>
                    @endif
                </div>
                <a href="{{ route('accommodations.show', $accommodation->id) }}" class="card-button">
                    View Details
                </a>
            </div>
        </div>
        @endforeach
        @else
        <p>No accommodations found.</p>
        @endif
    </div>

    @if($accommodations->count() > 0)
    <div style="text-align: center; margin-top: 40px;">
        <a href="{{ route('accommodations.index') }}" class="view-all-button">
            <i class="fas fa-th-large"></i>
            View All Accommodations
        </a>
    </div>
    @endif
</section>

{{-- Top Tourist Attractions Section --}}
<section class="attractions-section">
    <div class="section-header">
        <i class="fas fa-map-marked-alt icon-circle"></i>
        <h2>Amazing Tourist Attractions</h2>
    </div>

    <div class="cards-grid">
        @if($touristAttractions->count() > 0)
        @foreach($touristAttractions as $attraction)
        <div class="feature-card">
            <div class="card-image">
                @if($attraction->main_image)
                <img src="{{ $attraction->main_image }}" alt="{{ $attraction->name }}">
                @elseif($attraction->images->count() > 0)
                <img src="{{ $attraction->images->first()->image_url }}" alt="{{ $attraction->name }}">
                @else
                <div class="placeholder-image">
                    <i class="fas fa-camera"></i>
                </div>
                @endif
            </div>
            <div class="card-content">
                <h3>{{ $attraction->name }}</h3>
                <p class="card-location">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $attraction->location ?? 'Pulau Pramuka' }}
                </p>
                <p class="card-description">{{ Str::limit($attraction->description, 100) }}</p>
                <div class="card-meta">
                    <span class="meta-item type-badge {{ $attraction->type }}">
                        {{ $attraction->formatted_type }}
                    </span>
                    @if($attraction->rating)
                    <span class="meta-rating">
                        <i class="fas fa-star"></i>
                        {{ number_format($attraction->rating, 1) }}
                    </span>
                    @endif
                </div>
                <a href="{{ route('tourist-attractions.show', $attraction->id) }}" class="card-button">
                    Explore Now
                </a>
            </div>
        </div>
        @endforeach
        @else
        <p>No tourist attractions found.</p>
        @endif
    </div>

    @if($touristAttractions->count() > 0)
    <div style="text-align: center; margin-top: 40px;">
        <a href="{{ route('tourist-attractions.index') }}" class="view-all-button">
            <i class="fas fa-map-marked-alt"></i>
            View All Attractions
        </a>
    </div>
    @endif
</section>

@endsection