@extends('app')

@section('title', $product->title . ' - Pulau Pramuka')

@section('content')
    <section class="product-detail-section">
        <div class="product-detail-container">
            <a href="{{ route('products.index') }}" class="back-button">← Back to Products</a>
            
            <div class="product-detail-grid">
                <div class="product-detail-image">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}">
                    @else
                        <div class="placeholder-image">
                            <div class="placeholder-text">No Image Available</div>
                        </div>
                    @endif
                </div>
                
                <div class="product-detail-info">
                    <h1 class="product-title">{{ $product->title }}</h1>
                    <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    
                    <div class="product-stock-status {{ $product->stock <= 0 ? 'out-of-stock' : ($product->stock <= 5 ? 'low-stock' : 'in-stock') }}">
                        @if($product->stock <= 0)
                            <span class="stock-badge out-of-stock">Out of Stock</span>
                        @elseif($product->stock <= 5)
                            <span class="stock-badge low-stock">Low Stock - Only {{ $product->stock }} left</span>
                        @else
                            <span class="stock-badge in-stock">{{ $product->stock }} in stock</span>
                        @endif
                    </div>
                    
                    <div class="product-description">
                        <h3>Description</h3>
                        <p>{{ $product->description }}</p>
                    </div>
                    
                    @auth
                        @if($product->stock > 0)
                            <div class="product-actions">
                                <div class="quantity-selector">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock }}" value="1" class="quantity-input">
                                </div>
                                <button class="add-to-cart-button" onclick="showCartMessage()">Add to Cart</button>
                            </div>
                        @else
                            <div class="product-actions">
                                <button class="add-to-cart-button disabled" disabled>Out of Stock</button>
                            </div>
                        @endif
                    @else
                        <div class="product-actions">
                            <a href="{{ route('login') }}" class="add-to-cart-button">Login to Add to Cart</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <script>
        function showCartMessage() {
            alert('Cart feature is not available at the moment. This feature will be available soon!');
        }
    </script>
@endsection
