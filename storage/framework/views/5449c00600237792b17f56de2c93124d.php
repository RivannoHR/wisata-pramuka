<?php $__env->startSection('title', 'Accommodations - Pulau Pramuka'); ?>

<?php $__env->startSection('hero_content'); ?>
<div class="hero-content">
    <h1>Recharge Your Energy in Our Comfortable Hotels</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
    .accommodations-container {
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

    .accommodations-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
        padding: 20px 0;
    }

    .accommodation-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        height: 480px;
    }

    .accommodation-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .accommodation-image {
        width: 100%;
        height: 240px;
        background-color: #f0f0f0;
        background-size: cover;
        background-position: center;
        position: relative;
        overflow: hidden;
    }

    .accommodation-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.1) 100%);
        z-index: 1;
    }

    .rating-overlay {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(10px);
        padding: 8px 12px;
        border-radius: 20px;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.85rem;
        font-weight: 600;
        color: white;
    }

    .rating-overlay .star {
        color: white;
        font-size: 0.8rem;
    }

    .accommodation-content {
        flex: 1;
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .accommodation-header {
        margin-bottom: 16px;
    }

    .accommodation-name {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .accommodation-location {
        color: #666;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 2px;
    }

    .accommodation-type {
        color: #007bff;
        font-size: 0.85rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .accommodation-description {
        color: #555;
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 16px 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }

    .accommodation-facilities {
        margin: 16px 0;
    }

    .facilities-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .facility-item {
        background: #f1f5f9;
        color: #475569;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 500;
    }

    .facility-item i {
        font-size: 0.7rem;
        color: #22c55e;
    }

    .accommodation-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
        margin-top: auto;
    }

    .price-section {
        text-align: right;
    }

    .price-label {
        font-size: 0.8rem;
        color: #6b7280;
        margin-bottom: 2px;
    }

    .price-value {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1a1a;
    }

    .price-unit {
        font-size: 0.85rem;
        font-weight: 400;
        color: #6b7280;
    }

    .no-accommodations {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .no-accommodations i {
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
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
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
        .accommodations-list {
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 10px 0;
        }

        .accommodation-card {
            height: auto;
            min-height: 400px;
        }

        .accommodation-image {
            height: 200px;
        }

        .accommodation-content {
            padding: 20px;
        }

        .accommodation-name {
            font-size: 1.2rem;
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

        .accommodations-container {
            padding: 0 15px;
        }
    }

    @media (max-width: 480px) {
        .accommodations-list {
            grid-template-columns: 1fr;
        }

        .accommodation-card {
            min-height: 380px;
        }

        .accommodation-image {
            height: 180px;
        }

        .rating-overlay {
            top: 10px;
            right: 10px;
            padding: 6px 10px;
            font-size: 0.8rem;
        }

        .price-value {
            font-size: 1.1rem;
        }
    }
</style>

<div class="accommodations-container">
    <!-- Filters Section -->
    <div class="filters-section">
        <form method="GET" action="<?php echo e(route('accommodations.index')); ?>">
            <div class="filters-row">
                <div class="filter-group">
                    <label for="search">Search</label>
                    <input type="text" id="search" name="search" class="filter-input search-input"
                        placeholder="Search hotels, locations..." value="<?php echo e(request('search')); ?>">
                </div>

                <div class="filter-group">
                    <label for="type">Type</label>
                    <select id="type" name="type" class="filter-input">
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>" <?php echo e(request('type') == $value ? 'selected' : ''); ?>>
                            <?php echo e($label); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="sort">Sort By</label>
                    <select id="sort" name="sort" class="filter-input">
                        <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Name</option>
                        <option value="price" <?php echo e(request('sort') == 'price' ? 'selected' : ''); ?>>Price</option>
                        <option value="rating" <?php echo e(request('sort') == 'rating' ? 'selected' : ''); ?>>Rating</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="order">Order</label>
                    <select id="order" name="order" class="filter-input">
                        <option value="asc" <?php echo e(request('order') == 'asc' ? 'selected' : ''); ?>>Ascending</option>
                        <option value="desc" <?php echo e(request('order') == 'desc' ? 'selected' : ''); ?>>Descending</option>
                    </select>
                </div>

                <div class="filter-group">
                    <button type="submit" class="filter-button">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Accommodations List -->
    <div class="accommodations-list" id="accommodationsList">
        <?php if($accommodations->count() > 0): ?>
        <?php echo $__env->make('accommodations.partials.accommodation-cards', ['accommodations' => $accommodations], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
        <div class="no-accommodations">
            <i class="fas fa-bed"></i>
            <h3>No accommodations found</h3>
            <p>Try adjusting your search criteria or browse all accommodations.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <i class="fas fa-spinner"></i>
        <p>Loading more accommodations...</p>
    </div>

    <!-- End of Results -->
    <div class="end-of-results" id="endOfResults">
        <i class="fas fa-check-circle"></i>
        <p>You've seen all accommodations!</p>
    </div>
</div>

<script>
    let currentPage = 1;
    let isLoading = false;
    let hasMorePages = {
        {
            $accommodations - > hasMorePages() ? 'true' : 'false'
        }
    };
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
        document.getElementById('accommodationsList').innerHTML = '';
        document.getElementById('loadingSpinner').classList.remove('show');
        document.getElementById('endOfResults').classList.remove('show');

        // Get current filters
        currentFilters = {
            search: document.getElementById('search').value,
            type: document.getElementById('type').value,
            sort: document.getElementById('sort').value,
            order: document.getElementById('order').value
        };

        loadMoreAccommodations();
    }

    function loadMoreAccommodations() {
        if (isLoading || !hasMorePages) return;

        isLoading = true;
        document.getElementById('loadingSpinner').classList.add('show');

        // Prepare URL with filters
        const params = new URLSearchParams({
            page: currentPage,
            ...currentFilters
        });

        fetch(`<?php echo e(route('accommodations.index')); ?>?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loadingSpinner').classList.remove('show');

                if (data.html.trim()) {
                    document.getElementById('accommodationsList').insertAdjacentHTML('beforeend', data.html);
                    currentPage = data.nextPage;
                    hasMorePages = data.hasMore;

                    if (!hasMorePages) {
                        document.getElementById('endOfResults').classList.add('show');
                    }
                } else if (currentPage === 1) {
                    // No results at all
                    document.getElementById('accommodationsList').innerHTML = `
                    <div class="no-accommodations">
                        <i class="fas fa-bed"></i>
                        <h3>No accommodations found</h3>
                        <p>Try adjusting your search criteria or browse all accommodations.</p>
                    </div>
                `;
                }

                isLoading = false;
            })
            .catch(error => {
                console.error('Error loading accommodations:', error);
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
            loadMoreAccommodations();
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
            type: document.getElementById('type').value,
            sort: document.getElementById('sort').value,
            order: document.getElementById('order').value
        };

        // If we have accommodations but no more pages, show end message
        if (!hasMorePages && {
                {
                    $accommodations - > count()
                }
            } > 0) {
            document.getElementById('endOfResults').classList.add('show');
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/accommodations/index.blade.php ENDPATH**/ ?>