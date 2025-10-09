@extends('admin.dashboard')

@section('content')
<div class="admin-container">
    <!-- Header Section -->
    <div class="admin-header">
        <h1><i class="fas fa-map-marked-alt"></i> Tourist Attraction</h1>
        <p>Manage tourist attractions, locations, and visitor information</p>
    </div>

    <!-- Main Content Card -->
    <div class="admin-card">
        <!-- Card Header with Actions -->
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-list"></i>
                Tourist Attractions Management
            </div>
            <div class="action-buttons">
                <div class="filter-group">
                    <input type="text" class="search-input" placeholder="Search tourist attractions..." id="searchInput" value="{{ request('search') }}">
                </div>
                <button type="button" class="btn btn-secondary" onclick="toggleFilters()">
                    <i class="fas fa-filter"></i> Filter Data
                </button>
                <a href="{{ route('admin.tourist-attractions.create') ?? '#' }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Tourist Attraction
                </a>
            </div>
        </div>

        <!-- Filters Section (Hidden by default) -->
        <div class="filters-section" id="filtersSection" style="display: none;">
            <form method="GET" action="{{ route('admin.tourist-attractions') ?? '#' }}" class="filters-row">
                <div class="filter-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="filter-input">
                        <option value="">All Types</option>
                        @if(isset($types))
                            @foreach($types as $key => $label)
                                <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="filter-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="filter-input">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Apply Filters
                    </button>
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <a href="{{ route('admin.tourist-attractions') ?? '#' }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Content -->
        <div class="card-content">
            @if(isset($touristAttractions) && $touristAttractions->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Images</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($touristAttractions as $attraction)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        @if(isset($attraction->featuredImage) && $attraction->featuredImage)
                                            <img src="{{ asset('storage/' . $attraction->featuredImage->image_path) }}" 
                                                 alt="{{ $attraction->name }}" 
                                                 class="img-thumbnail">
                                        @else
                                            <div class="img-thumbnail" style="background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-image" style="color: #9ca3af;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight: 600; color: #1f2937;">{{ $attraction->name }}</div>
                                            <div style="font-size: 0.75rem; color: #6b7280;">ID: {{ $attraction->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-featured">
                                        {{ isset($types[$attraction->type]) ? $types[$attraction->type] : ucfirst(str_replace('_', ' ', $attraction->type)) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="color: #374151;">{{ $attraction->location ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #6b7280;">
                                        {{ Str::limit($attraction->description ?? '', 50) }}
                                    </div>
                                </td>
                                <td>
                                    @if($attraction->is_active ?? true)
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle"></i> Active
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-times-circle"></i> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="fas fa-images" style="color: #6b7280;"></i>
                                        <span style="color: #374151;">{{ isset($attraction->images) ? $attraction->images->count() : 0 }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.tourist-attractions.edit', $attraction->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.tourist-attractions.images', $attraction->id) }}" class="btn btn-sm btn-secondary" title="Manage Images">
                                            <i class="fas fa-images"></i>
                                        </a>
                                        <a href="{{ route('admin.tourist-attractions.reviews', $attraction) ?? '#' }}" class="btn btn-sm btn-warning" title="Manage Reviews">
                                            <i class="fas fa-star"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete({{ $attraction->id }})"
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
                @if(method_exists($touristAttractions, 'hasPages') && $touristAttractions->hasPages())
                    <div class="pagination">
                        {{ $touristAttractions->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="fas fa-map-marked-alt"></i>
                    <h3>No Tourist Attractions Found</h3>
                    <p>Start by adding your first tourist attraction to showcase amazing destinations.</p>
                    <br>
                    <a href="{{ route('admin.tourist-attractions.create') ?? '#' }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add First Tourist Attraction
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
    if (confirm('Are you sure you want to delete this tourist attraction? This action cannot be undone.')) {
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/tourist-attractions/${id}`;
        
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
