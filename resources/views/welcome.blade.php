@extends('app')

@section('title', 'Welcome Home')

@section('hero_content')
    <div class="hero-content">
        <h1>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h1>
    </div>
@endsection

@section('content')
    <section class="products-section">
        <div class="section-header">
            <i class="fas fa-map-marker-alt icon-circle"></i>
            <h2>Meet Our Products</h2>
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
                                </div>
                                @if($product->image_path)
                                    <div class="product-image">
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}">
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
@endsection