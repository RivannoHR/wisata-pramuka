@extends('app')

@section('title', 'Products - Pulau Pramuka')

@section('content')
<style>
    .products-page-section {
        padding: 40px 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .products-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .products-header h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: #333;
    }

    .filter-container {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .filter-form {
        display: flex;
        gap: 20px;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-group label {
        font-weight: 500;
        color: #333;
        font-size: 0.9rem;
    }

    .filter-select, .search-input, .price-input {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.9rem;
        min-width: 150px;
    }

    .search-input {
        min-width: 250px;
    }

    .filter-button {
        background: black;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        margin-top: 20px;
        transition: background-color 0.3s;
    }

    .filter-button:hover {
        background: #555;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .product-card-image {
        width: 100%;
        height: 250px;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-card-image.placeholder {
        color: #999;
        font-style: italic;
    }

    .product-card-content {
        padding: 25px;
    }

    .product-card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
        line-height: 1.3;
    }

    .product-card-description {
        color: #666;
        line-height: 1.6;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }

    .product-card-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .product-price {
        font-size: 1.4rem;
        font-weight: 700;
        color: #27ae60;
    }

    .product-stock {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .product-stock.in-stock {
        background: #d4edda;
        color: #155724;
    }

    .product-stock.low-stock {
        background: #fff3cd;
        color: #856404;
    }

    .product-stock.out-of-stock {
        background: #f8d7da;
        color: #721c24;
    }

    .product-card-actions {
        display: flex;
        gap: 10px;
    }

    .view-button, .add-to-cart-button, .order-button {
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
    }

    .view-button {
        background: #f8f9fa;
        color: #333;
        border: 1px solid #e9ecef;
    }

    .view-button:hover {
        background: #e9ecef;
        text-decoration: none;
        color: #333;
    }

    .add-to-cart-button, .order-button {
        background: #25d366;
        color: white;
    }

    .add-to-cart-button:hover, .order-button:hover {
        background: #1fa851;
        text-decoration: none;
        color: white;
    }

    .add-to-cart-button.disabled, .order-button.disabled {
        background: #6c757d;
        cursor: not-allowed;
    }

    .no-products {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .no-products i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #ddd;
    }

    .loading-spinner {
        display: none;
        text-align: center;
        padding: 40px 20px;
        color: #666;
    }

    .loading-spinner.show {
        display: block;
    }

    .loading-spinner i {
        font-size: 2rem;
        animation: spin 1s linear infinite;
        color: #007bff;
        margin-bottom: 10px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .end-of-results {
        display: none;
        text-align: center;
        padding: 40px 20px;
        color: #999;
        border-top: 1px solid #eee;
        margin-top: 40px;
    }

    .end-of-results.show {
        display: block;
    }

    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: 1fr;
        }
        
        .filter-form {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-select, .search-input, .price-input {
            min-width: auto;
            width: 100%;
        }
    }
</style>

    <section class="products-page-section">
        <div class="products-header">
            <h1>Products</h1>
            <div class="filter-container">
                <form method="GET" action="{{ route('products.index') }}" class="filter-form" id="filterForm">
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

        <div class="products-grid" id="productsGrid">
            @if($products->count() > 0)
                @include('products.partials.product-cards', ['products' => $products])
            @else
                <div class="no-products" style="grid-column: 1 / -1;" id="noProductsMessage">
                    <i class="fas fa-search"></i>
                    <h3>No products found</h3>
                    <p>Try adjusting your search criteria or browse all products.</p>
                </div>
            @endif
        </div>

        <!-- Loading Spinner -->
        <div class="loading-spinner" id="loadingSpinner">
            <i class="fas fa-spinner"></i>
            <p>Loading more products...</p>
        </div>

        <div class="end-of-results" id="endOfResults">
            <p>No more products to display.</p>
        </div>
    </section>

    <script>
        // Infinite scrolling variables
        let currentPage = {{ $products->currentPage() }};
        let hasMorePages = {{ $products->hasMorePages() ? 'true' : 'false' }};
        let loading = false;
        const productsGrid = document.getElementById('productsGrid');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const endOfResults = document.getElementById('endOfResults');
        const noProductsMessage = document.getElementById('noProductsMessage');

        // Auto-submit form when filter changes
        document.querySelectorAll('.filter-select, .price-input').forEach(element => {
            element.addEventListener('change', function() {
                // Reset infinite scroll when filters change
                currentPage = 1;
                hasMorePages = true;
                this.form.submit();
            });
        });

        // Submit search on Enter
        document.querySelector('.search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                // Reset infinite scroll when search changes
                currentPage = 1;
                hasMorePages = true;
                this.form.submit();
            }
        });

        // Load more products function
        function loadMoreProducts() {
            if (loading || !hasMorePages) return;
            
            loading = true;
            loadingSpinner.classList.add('show');

            const nextPage = currentPage + 1;
            const url = new URL(window.location.href);
            url.searchParams.set('page', nextPage);

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.html && data.html.trim()) {
                    // Remove "no products" message if it exists
                    if (noProductsMessage) {
                        noProductsMessage.remove();
                    }

                    // Create temporary container to parse HTML
                    const temp = document.createElement('div');
                    temp.innerHTML = data.html;
                    
                    // Append new product cards
                    const newCards = temp.querySelectorAll('.product-card');
                    newCards.forEach(card => {
                        productsGrid.appendChild(card);
                    });

                    currentPage = data.nextPage - 1;
                    hasMorePages = data.hasMore;

                    if (!hasMorePages) {
                        endOfResults.classList.add('show');
                    }
                } else {
                    hasMorePages = false;
                    endOfResults.classList.add('show');
                }
            })
            .catch(error => {
                console.error('Error loading more products:', error);
                hasMorePages = false;
                endOfResults.classList.add('show');
            })
            .finally(() => {
                loading = false;
                loadingSpinner.classList.remove('show');
            });
        }

        // Scroll event listener for infinite scrolling
        window.addEventListener('scroll', function() {
            if (loading || !hasMorePages) return;

            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;

            // Load more when user is 300px from bottom
            if (scrollTop + windowHeight >= documentHeight - 300) {
                loadMoreProducts();
            }
        });

        // Show end message if no more pages on initial load
        if (!hasMorePages && currentPage === 1 && productsGrid.children.length > 0) {
            endOfResults.classList.add('show');
        }
    </script>