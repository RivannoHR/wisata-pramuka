@extends('admin.dashboard')

@section('content')
<div class="admin-container">
    <!-- Header Section -->
    <div class="admin-header">
        <h1><i class="fas fa-box"></i> Products</h1>
        <p>Manage your products, inventory, and pricing</p>
    </div>

    <!-- Main Content Card -->
    <div class="admin-card">
        <!-- Card Header with Actions -->
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-list"></i>
                Products Management
            </div>
            <div class="action-buttons">
                <div class="filter-group">
                    <input type="text" class="search-input" placeholder="Search products..." id="searchInput" value="{{ request('search') }}">
                </div>
                <button type="button" class="btn btn-secondary" onclick="toggleFilters()">
                    <i class="fas fa-filter"></i> Filter Data
                </button>
                <a href="{{ route('admin.products.create') ?? '#' }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Product
                </a>
            </div>
        </div>

        <!-- Filters Section (Hidden by default) -->
        <div class="filters-section" id="filtersSection" style="display: none;">
            <form method="GET" action="{{ route('admin.products') ?? '#' }}" class="filters-row">
                <div class="filter-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="filter-input">
                        <option value="">All Categories</option>
                        <option value="equipment" {{ request('category') == 'equipment' ? 'selected' : '' }}>Equipment</option>
                        <option value="clothing" {{ request('category') == 'clothing' ? 'selected' : '' }}>Clothing</option>
                        <option value="accessories" {{ request('category') == 'accessories' ? 'selected' : '' }}>Accessories</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="is_featured">Featured</label>
                    <select name="is_featured" id="is_featured" class="filter-input">
                        <option value="">All Products</option>
                        <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>Featured</option>
                        <option value="0" {{ request('is_featured') == '0' ? 'selected' : '' }}>Not Featured</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="min_price">Min Price</label>
                    <input type="number" name="min_price" id="min_price" class="filter-input" placeholder="0" value="{{ request('min_price') }}">
                </div>
                <div class="filter-group">
                    <label for="max_price">Max Price</label>
                    <input type="number" name="max_price" id="max_price" class="filter-input" placeholder="1000000" value="{{ request('max_price') }}">
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Apply Filters
                    </button>
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <a href="{{ route('admin.products') ?? '#' }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Content -->
        <div class="card-content">
            @if(isset($products) && $products->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        @if($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}" 
                                                 alt="{{ $product->title }}" 
                                                 class="img-thumbnail">
                                        @else
                                            <div class="img-thumbnail" style="background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-image" style="color: #9ca3af;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight: 600; color: #1f2937;">{{ $product->title }}</div>
                                            <div style="font-size: 0.75rem; color: #6b7280;">ID: {{ $product->id }}</div>
                                            @if($product->is_featured ?? false)
                                                <span class="status-badge status-featured" style="font-size: 0.7rem; margin-top: 0.25rem;">
                                                    <i class="fas fa-star"></i> Featured
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-info">
                                        {{ ucfirst($product->category) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #059669;">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        @if(($product->stock ?? 0) > 10)
                                            <div class="status-indicator" style="background: #10b981;"></div>
                                            <span style="color: #10b981; font-weight: 500;">{{ $product->stock ?? 0 }}</span>
                                        @elseif(($product->stock ?? 0) > 5)
                                            <div class="status-indicator" style="background: #f59e0b;"></div>
                                            <span style="color: #f59e0b; font-weight: 500;">{{ $product->stock ?? 0 }}</span>
                                        @else
                                            <div class="status-indicator" style="background: #ef4444;"></div>
                                            <span style="color: #ef4444; font-weight: 500;">{{ $product->stock ?? 0 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if(($product->stock ?? 0) > 0)
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle"></i> In Stock
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-times-circle"></i> Out of Stock
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.products.edit', $product) ?? '#' }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete({{ $product->id }})"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(method_exists($products, 'hasPages') && $products->hasPages())
                    <div class="pagination">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="fas fa-box"></i>
                    <h3>No Products Found</h3>
                    <p>Start by adding your first product to begin selling.</p>
                    <br>
                    <a href="{{ route('admin.products.create') ?? '#' }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add First Product
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function toggleFilters() {
    const filtersSection = document.getElementById('filtersSection');
    filtersSection.style.display = filtersSection.style.display === 'none' ? 'block' : 'none';
}

function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/products/delete/${id}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

function toggleFeatured(id, featured) {
    // Create and submit form to toggle featured status
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/products/${id}/toggle-featured`;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    
    const featuredField = document.createElement('input');
    featuredField.type = 'hidden';
    featuredField.name = 'is_featured';
    featuredField.value = featured ? '1' : '0';
    
    form.appendChild(csrfToken);
    form.appendChild(featuredField);
    document.body.appendChild(form);
    form.submit();
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.admin-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
});
</script>
@endsection
