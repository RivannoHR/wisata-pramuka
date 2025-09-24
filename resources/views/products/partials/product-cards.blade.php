@foreach($products as $product)
    <div class="product-card">
        @if($product->image_path)
        <div class="product-card-image">
            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}">
        </div>
        @else
        <div class="product-card-image placeholder">
            <div class="placeholder-text">No Image</div>
        </div>
        @endif

        <div class="product-card-content">
            <h3 class="product-card-title">{{ $product->title }}</h3>
            <p class="product-card-description">{{ Str::limit($product->description, 100) }}</p>

            <div class="product-card-details">
                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                <div class="product-stock {{ $product->stock <= 0 ? 'out-of-stock' : ($product->stock <= 5 ? 'low-stock' : 'in-stock') }}">
                    @if($product->stock <= 0)
                        Out of Stock
                    @elseif($product->stock <= 5)
                        Low Stock ({{ $product->stock }})
                    @else
                        In Stock ({{ $product->stock }})
                    @endif
                </div>
            </div>

            <div class="product-card-actions">
                <a href="{{ route('products.show', $product->product_id) }}" class="view-button">View Details</a>
                @if($product->stock > 0)
                <a href="http://wa.me/6281213643354?text=Saya tertarik untuk memesan {{ $product->title }}" class="order-button">Make Order</a>
                @else
                <a href="#" class="order-button disabled">Out of Stock</a>
                @endif
            </div>
        </div>
    </div>
@endforeach