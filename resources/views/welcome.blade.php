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
        <i class="fas fa-shopping-bag icon-circle"></i>
        <h2>Meet Our Specialties
        </h2>
    </div>

    {{-- Horizontal Scrollable Product Cards --}}
    @if($products->count() > 0)
    <div class="horizontal-scroll-container">
        <div class="horizontal-scroll-track">
            @foreach($products as $product)
            <div class="horizontal-product-card">
                <div class="horizontal-product-image">
                    @if($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}">
                    @else
                    <div class="placeholder-image">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    @endif
                </div>
                <div class="horizontal-product-content">
                    <h3>{{ $product->title }}</h3>
                    <p class="horizontal-product-description">{{ Str::limit($product->description, 80) }}</p>
                    @if($product->price)
                    <div class="horizontal-product-price">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                    @endif
                    <div class="horizontal-product-actions">
                        <a href="{{ route('products.show', $product->product_id) }}" class="horizontal-view-button-single">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @if($products->count() >= 3)
    <div style="text-align: center; margin-top: 40px;">
        <a href="{{ route('products.index') }}" class="view-all-button">
            <i class="fas fa-shopping-bag"></i>
            View All Products
        </a>
    </div>
    @endif
    @else
    <div class="no-products">
        <i class="fas fa-shopping-bag"></i>
        <h3>No products available</h3>
        <p>Check back later for our featured products!</p>
    </div>
    @endif
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
                        Starting Rp {{ $accommodation->LowestPrice }}/night
                    </span>
                    @endif
                </div>
                <a href="{{ route('accommodations.show', $accommodation->id) }}" class="card-button">
                    Explore Now
                </a>
            </div>
        </div>
        @endforeach
        @else
        <p>No accommodations found.</p>
        @endif
    </div>

    @if($accommodations->count() >= 3)
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

<section class="accommodations-section">
    <div class="section-header">
        <i class="fas fa-newspaper icon-circle"></i>
        <h2>Latest News</h2>
    </div>

    <div class="cards-grid">
        @if($articles->count() > 0)
        @foreach($articles as $article)
        <div class="feature-card">
            <div class="card-image">
                <div class="article-badge">{{ $article->capital_category }}</div>
                <img src="{{ $article->first_image ? asset('storage/' . $article->first_image) : asset('images/default-article.jpg') }}" alt="{{ $article->name }}">
            </div>
            <div class="card-content">
                <h3>{{ $article->title }}</h3>
                <p class="card-location">
                    <i class="fa-regular fa-calendar fa-xl" style="color: #7f8c8d;"></i>
                    {{ $article->formatted_date }}
                </p>
                <p class="card-description">{{ Str::limit($article->content, 200) }}</p>
                <a href="{{ route('articles.show', $article->id) }}" class="card-button">
                    Read More
                </a>
            </div>
        </div>
        @endforeach
        @else
        <p>No latest news.</p>
        @endif
    </div>

    @if($articles->count() >= 3)
    <div style="text-align: center; margin-top: 40px;">
        <a href="{{ route('articles.index') }}" class="view-all-button">
            <i class="fas fa-th-large"></i>
            View All News and Articles
        </a>
    </div>
    @endif
</section>

@endsection