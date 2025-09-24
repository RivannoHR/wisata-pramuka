@extends('app')

@section('title', 'Tourist Attractions - Pulau Pramuka')

@section('hero_content')
    <div class="hero-content">
        <h1>Latest News and Articles</h1>
        <p>Stay on tune with latest news and articles</p>
    </div>
@endsection

@section('content')
<style>
    .attractions-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .filters-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .filters-row {
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

    .filter-input {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.9rem;
        min-width: 150px;
    }

    .filter-input:focus {
        outline: none;
        border-color: black;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
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

    .attractions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .attraction-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }

    .attraction-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .attraction-image {
        width: 100%;
        height: 220px;
        background-color: #f0f0f0;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .attraction-type-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(0, 123, 255, 0.9);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .attraction-type-badge.tourist_spot {
        background: rgba(40, 167, 69, 0.9);
    }

    .attraction-type-badge.restaurant {
        background: rgba(255, 193, 7, 0.9);
        color: #333;
    }

    .attraction-type-badge.shop {
        background: rgba(220, 53, 69, 0.9);
    }

    .attraction-rating {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .attraction-content {
        padding: 20px;
    }

    .attraction-name {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .attraction-location {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .attraction-description {
        color: #555;
        font-size: 0.9rem;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .no-attractions {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .no-attractions i {
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
        .attractions-grid {
            grid-template-columns: 1fr;
        }
        
        .filters-row {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-input,
        .search-input {
            min-width: auto;
            width: 100%;
        }
    }
</style>

<div class="attractions-container">
    <!-- Filters Section -->
    <div class="filters-section">
        <form method="GET" action="{{ route('articles.index') }}">
            <div class="filters-row">
                <div class="filter-group">
                    <label for="search">Search</label>
                    <input type="text" id="search" name="search" class="filter-input search-input" 
                           placeholder="Search articles, categories" value="{{ request('search') }}">
                </div>
                <div class="filter-group">
                    <button type="submit" class="filter-button">
                        <i class="fas fa-magnifying-glass"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Attractions Grid -->
    <div class="attractions-grid" id="attractionsGrid">
        @if($articles->count() > 0)
            @include('articles.partials.attraction-cards', ['articles' => $articles])
        @else
            <div class="no-attractions" style="grid-column: 1 / -1;">
                <i class="fas fa-search"></i>
                <h3>No articles found</h3>
                <p>Try adjusting your search criteria or browse articles.</p>
            </div>
        @endif
    </div>

    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <i class="fas fa-spinner"></i>
        <p>Loading more articles...</p>
    </div>

    <!-- End of Results -->
    <div class="end-of-results" id="endOfResults">
        <i class="fas fa-check-circle"></i>
        <p>You've seen all articles!</p>
    </div>
</div>

<script>
    let currentPage = 1;
    let isLoading = false;
    let hasMorePages = {{ $articles->hasMorePages() ? 'true' : 'false' }};
    let currentFilters = {};

    // Auto-submit form when filters change and reset infinite scroll
    document.querySelectorAll('#type, #sort, #order').forEach(select => {
        select.addEventListener('change', function() {
            resetAndReload();
        });
    });

    // Handle search form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        resetAndReload();
    });

    function resetAndReload() {
        currentPage = 1;
        hasMorePages = true;
        isLoading = false;
        document.getElementById('attractionsGrid').innerHTML = '';
        document.getElementById('loadingSpinner').classList.remove('show');
        document.getElementById('endOfResults').classList.remove('show');
        
        // Get current filters
        currentFilters = {
            search: document.getElementById('search').value,
            type: document.getElementById('type').value,
            sort: document.getElementById('sort').value,
            order: document.getElementById('order').value
        };
        
        loadMoreAttractions();
    }

    function loadMoreAttractions() {
        if (isLoading || !hasMorePages) return;
        
        isLoading = true;
        document.getElementById('loadingSpinner').classList.add('show');
        
        // Prepare URL with filters
        const params = new URLSearchParams({
            page: currentPage,
            ...currentFilters
        });
        
        fetch(`{{ route('articles.index') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loadingSpinner').classList.remove('show');
            
            if (data.html.trim()) {
                document.getElementById('attractionsGrid').insertAdjacentHTML('beforeend', data.html);
                currentPage = data.nextPage;
                hasMorePages = data.hasMore;
                
                if (!hasMorePages) {
                    document.getElementById('endOfResults').classList.add('show');
                }
            } else if (currentPage === 1) {
                // No results at all
                document.getElementById('attractionsGrid').innerHTML = `
                    <div class="no-attractions" style="grid-column: 1 / -1;">
                        <i class="fas fa-search"></i>
                        <h3>No articles found</h3>
                        <p>Try adjusting your search criteria or browse all articles.</p>
                    </div>
                `;
            }
            
            isLoading = false;
        })
        .catch(error => {
            console.error('Error loading articles:', error);
            document.getElementById('loadingSpinner').classList.remove('show');
            isLoading = false;
        });
    }

    // Infinite scroll functionality
    function handleScroll() {
        if (isLoading || !hasMorePages) return;
        
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;
        
        // Load more when user is 200px from bottom
        if (scrollTop + windowHeight >= documentHeight - 200) {
            loadMoreAttractions();
        }
    }

    // Throttle scroll events for better performance
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        if (scrollTimeout) {
            clearTimeout(scrollTimeout);
        }
        scrollTimeout = setTimeout(handleScroll, 100);
    });

    // Initialize filters on page load
    window.addEventListener('DOMContentLoaded', function() {
        currentFilters = {
            search: document.getElementById('search').value,
        };
        
        // If we have attractions but no more pages, show end message
        if (!hasMorePages && {{ $articles->count() }} > 0) {
            document.getElementById('endOfResults').classList.add('show');
        }
    });
</script>
@endsection
