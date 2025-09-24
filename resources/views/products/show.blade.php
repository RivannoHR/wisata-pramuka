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
                                <button class="order-button" onclick="makeOrder()">Make Order</button>
                            </div>
                        @else
                            <div class="product-actions">
                                <button class="order-button disabled" disabled>Out of Stock</button>
                            </div>
                        @endif
                    @else
                        <div class="product-actions">
                            <a href="http://wa.me/6281213643354?text=Saya tertarik untuk memesan {{ $product->title }}" class="order-button">Make Order</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <script>
        function makeOrder() {
            const quantity = document.getElementById('quantity').value;
            const productTitle = "{{ $product->title }}";
            const productPrice = "{{ number_format($product->price, 0, ',', '.') }}";
            const totalPrice = {{ $product->price }} * quantity;
            const formattedTotalPrice = totalPrice.toLocaleString('id-ID');
            
            const message = `Saya tertarik untuk memesan:
Produk: ${productTitle}
Jumlah: ${quantity}
Harga satuan: Rp ${productPrice}
Total harga: Rp ${formattedTotalPrice}

Terima kasih!`;
            
            const whatsappUrl = `http://wa.me/6281213643354?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        }
    </script>
@endsection
