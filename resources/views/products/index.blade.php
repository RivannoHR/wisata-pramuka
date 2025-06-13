@extends('app')

@section('title', 'Products - Pulau Pramuka')

@section('content')
    <section class="products-page-section">
        <div class="products-header">
            <h1>Products</h1>
            <div class="filter-container">
                <form method="GET" action="{{ route('products.index') }}" class="filter-form">
                    <div class="filter-group">
                        <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" class="search-input">
                    </div>
                    
                    <div class="filter-group">
                        <select name="sort_by" class="filter-select">
                            <option value="">Sort by</option>
                            <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                            <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                            <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                            <option value="stock_asc" {{ request('sort_by') == 'stock_asc' ? 'selected' : '' }}>Stock (Low to High)</option>
                            <option value="stock_desc" {{ request('sort_by') == 'stock_desc' ? 'selected' : '' }}>Stock (High to Low)</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <input type="number" name="min_price" placeholder="Min Price" value="{{ request('min_price') }}" class="price-input">
                        <input type="number" name="max_price" placeholder="Max Price" value="{{ request('max_price') }}" class="price-input">
                    </div>
                    
                    <div class="filter-group">
                        <select name="stock_filter" class="filter-select">
                            <option value="">Stock Status</option>
                            <option value="in_stock" {{ request('stock_filter') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                            <option value="low_stock" {{ request('stock_filter') == 'low_stock' ? 'selected' : '' }}>Low Stock (≤5)</option>
                            <option value="out_of_stock" {{ request('stock_filter') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="filter-button">Filter</button>
                </form>
            </div>
        </div>

        <div class="products-grid">
            @if($products->count() > 0)
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
                                    <button class="add-to-cart-button" onclick="showCartMessage()">Add to Cart</button>
                                @else
                                    <button class="add-to-cart-button disabled" disabled>Out of Stock</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no-products">
                    <p>No products found matching your criteria.</p>
                </div>
            @endif
        </div>

        @if($products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </section>

    <script>
        // Cart message function
        function showCartMessage() {
            alert('Cart feature is not available at the moment. This feature will be available soon!');
        }

        // Auto-submit form when filter changes
        document.querySelectorAll('.filter-select, .search-input, .price-input').forEach(element => {
            element.addEventListener('change', function() {
                if (this.name === 'search') return; // Don't auto-submit on search input
                this.form.submit();
            });
        });

        // Submit search on Enter
        document.querySelector('.search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    </script>
@endsection
