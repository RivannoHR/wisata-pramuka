@extends('admin.dashboard')

@section('content')
<div class="admin-container">
    <!-- Header Section -->
    <div class="admin-header">
        <h1><i class="fas fa-bed"></i> Accommodations</h1>
        <p>Manage hotels, lodges, and accommodation bookings</p>
    </div>

    <!-- Main Content Card -->
    <div class="admin-card">
        <!-- Card Header with Actions -->
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-list"></i>
                Accommodations Management
            </div>
            <div class="action-buttons">
                <div class="filter-group">
                    <input type="text" class="search-input" placeholder="Search accommodations..." id="searchInput" value="{{ request('search') }}">
                </div>
                <button type="button" class="btn btn-secondary" onclick="toggleFilters()">
                    <i class="fas fa-filter"></i> Edit Data
                </button>
                <a href="{{ route('admin.accommodations.create') ?? '#' }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Lorem +
                </a>
            </div>
        </div>

        <!-- Filters Section (Hidden by default) -->
        <div class="filters-section" id="filtersSection" style="display: none;">
            <form method="GET" action="{{ route('admin.accommodations') ?? '#' }}" class="filters-row">
                <div class="filter-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="filter-input">
                        <option value="">All Types</option>
                        <option value="hotel" {{ request('type') == 'hotel' ? 'selected' : '' }}>Hotel</option>
                        <option value="lodge" {{ request('type') == 'lodge' ? 'selected' : '' }}>Lodge</option>
                        <option value="guesthouse" {{ request('type') == 'guesthouse' ? 'selected' : '' }}>Guesthouse</option>
                        <option value="camping" {{ request('type') == 'camping' ? 'selected' : '' }}>Camping</option>
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
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" class="filter-input" placeholder="Search location..." value="{{ request('location') }}">
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Apply Filters
                    </button>
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <a href="{{ route('admin.accommodations') ?? '#' }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Content -->
        <div class="card-content">
            @if(isset($accommodations) && $accommodations->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Accommodation</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>Price/Night</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Visits</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accommodations as $accommodation)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        @if(isset($accommodation->featuredImage) && $accommodation->featuredImage)
                                            <img src="{{ asset('storage/' . $accommodation->featuredImage->image_path) }}" 
                                                 alt="{{ $accommodation->name }}" 
                                                 class="img-thumbnail">
                                        @else
                                            <div class="img-thumbnail" style="background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-image" style="color: #9ca3af;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight: 600; color: #1f2937;">{{ $accommodation->name }}</div>
                                            <div style="font-size: 0.75rem; color: #6b7280;">ID: {{ $accommodation->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-info">
                                        {{ ucfirst($accommodation->type ?? 'Hotel') }}
                                    </span>
                                </td>
                                <td>
                                    <div style="color: #374151;">
                                        <i class="fas fa-map-marker-alt" style="color: #6b7280; margin-right: 0.5rem;"></i>
                                        {{ $accommodation->location ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #059669;">
                                        Rp {{ number_format($accommodation->price ?? 0, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="fas fa-users" style="color: #6b7280;"></i>
                                        <span style="color: #374151;">{{ $accommodation->capacity ?? 'N/A' }} guests</span>
                                    </div>
                                </td>
                                <td>
                                    @if($accommodation->is_available ?? true)
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle"></i> Available
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-times-circle"></i> Unavailable
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="fas fa-eye" style="color: #6b7280;"></i>
                                        <span style="color: #374151;">{{ $accommodation->visit_count ?? 0 }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="#" class="btn btn-sm btn-secondary" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.accommodations.edit', $accommodation) ?? '#' }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-secondary" title="Manage Images">
                                            <i class="fas fa-images"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info" title="Manage Bookings">
                                            <i class="fas fa-calendar-check"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete({{ $accommodation->id }})"
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
                @if(method_exists($accommodations, 'hasPages') && $accommodations->hasPages())
                    <div class="pagination">
                        {{ $accommodations->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="fas fa-bed"></i>
                    <h3>No Accommodations Found</h3>
                    <p>Start by adding your first accommodation to offer lodging services.</p>
                    <br>
                    <a href="{{ route('admin.accommodations.create') ?? '#' }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add First Accommodation
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
    if (confirm('Are you sure you want to delete this accommodation? This action cannot be undone.')) {
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/accommodations/${id}`;
        
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
