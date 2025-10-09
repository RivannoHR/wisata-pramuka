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
                    <i class="fas fa-filter"></i> Edit Data
                </button>
                <a href="{{ route('admin.tourist-attractions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Lorem +
                </a>
            </div>
        </div>

        <!-- Filters Section (Hidden by default) -->
        <div class="filters-section" id="filtersSection" style="display: none;">
            <form method="GET" action="{{ route('admin.tourist-attractions') }}" class="filters-row">
                <div class="filter-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="filter-input">
                        <option value="">All Types</option>
                        @foreach($types as $key => $label)
                            <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
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
                    <a href="{{ route('admin.tourist-attractions') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Content -->
        <div class="card-content">
            @if($touristAttractions->count() > 0)
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
                                        @if($attraction->featuredImage)
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
                                        {{ $types[$attraction->type] ?? ucfirst(str_replace('_', ' ', $attraction->type)) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="color: #374151;">{{ $attraction->location }}</div>
                                </td>
                                <td>
                                    <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #6b7280;">
                                        {{ Str::limit($attraction->description, 50) }}
                                    </div>
                                </td>
                                <td>
                                    @if($attraction->is_active)
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
                                        <span style="color: #374151;">{{ $attraction->images->count() }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.tourist-attractions.show', $attraction->id) }}" 
                                           class="btn btn-sm btn-secondary" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.tourist-attractions.edit', $attraction->id) }}" 
                                           class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.tourist-attractions.images.index', $attraction->id) }}" 
                                           class="btn btn-sm btn-secondary" title="Manage Images">
                                            <i class="fas fa-images"></i>
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
                @if($touristAttractions->hasPages())
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
                    <a href="{{ route('admin.tourist-attractions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add First Tourist Attraction
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 2rem; border-radius: 12px; max-width: 400px; width: 90%; text-align: center;">
        <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #f59e0b; margin-bottom: 1rem;"></i>
        <h3 style="margin-bottom: 0.5rem; color: #1f2937;">Confirm Deletion</h3>
        <p style="color: #6b7280; margin-bottom: 1.5rem;">Are you sure you want to delete this tourist attraction? This action cannot be undone.</p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function toggleFilters() {
    const filtersSection = document.getElementById('filtersSection');
    filtersSection.style.display = filtersSection.style.display === 'none' ? 'block' : 'none';
}

function confirmDelete(id) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    form.action = `/admin/tourist-attractions/${id}`;
    modal.style.display = 'flex';
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'none';
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.admin-table tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endsection
