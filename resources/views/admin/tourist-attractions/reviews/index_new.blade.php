@extends('admin.dashboard')

@section('content')
<div class="admin-container" style="margin: 0; max-width: 100%; padding: 1.5rem;">
    <!-- Header Section -->
    <div class="admin-header" style="border-radius: 16px; margin-bottom: 2rem;">
        <div>
            <h1><i class="fas fa-star"></i> Reviews for {{ $attraction->name }}</h1>
            <p>Manage visitor reviews and ratings</p>
        </div>
        <a href="{{ route('admin.tourist-attractions') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Tourist Attractions
        </a>
    </div>

    <!-- Rating Statistics -->
    @php
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? $reviews->avg('rating') : 0;
        $ratingCounts = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];
    @endphp

    <div class="admin-card" style="border-radius: 16px; margin-bottom: 2rem;">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-chart-bar"></i>
                Rating Overview
            </div>
        </div>
        <div class="card-content">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div style="text-align: center; padding: 1.5rem; background: linear-gradient(135deg, #fbbf24, #f59e0b); border-radius: 12px; color: white;">
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">
                        {{ number_format($averageRating, 1) }}
                    </div>
                    <div style="font-size: 1.1rem; opacity: 0.9;">Average Rating</div>
                    <div style="font-size: 0.9rem; opacity: 0.8;">{{ $totalReviews }} review{{ $totalReviews != 1 ? 's' : '' }}</div>
                </div>
                
                @foreach($ratingCounts as $rating => $count)
                <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f9fafb; border-radius: 8px;">
                    <div style="display: flex; gap: 0.25rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star" style="color: {{ $i <= $rating ? '#fbbf24' : '#e5e7eb' }};"></i>
                        @endfor
                    </div>
                    <div style="flex: 1; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 500;">{{ $rating }} Star{{ $rating != 1 ? 's' : '' }}</span>
                        <span style="font-weight: 600; color: #374151;">{{ $count }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="admin-card" style="border-radius: 16px;">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-list"></i>
                Reviews Management
            </div>
            <div class="action-buttons">
                @if($reviews->count() > 0)
                <button type="button" class="btn btn-danger" onclick="bulkDelete()">
                    <i class="fas fa-trash-alt"></i> Delete Selected
                </button>
                @endif
            </div>
        </div>

        <!-- Bulk Actions -->
        @if($reviews->count() > 0)
        <div class="bulk-actions" id="bulkActions" style="display: none;">
            <div class="bulk-actions-content">
                <span id="selectedCount">0</span> review(s) selected
                <div class="bulk-buttons">
                    <button type="button" class="btn btn-danger btn-sm" onclick="bulkDeleteSelected()">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>
        @endif

        <!-- Table Content -->
        <div class="card-content">
            @if($reviews->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width: 40px;">
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                </th>
                                <th>User</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviews as $review)
                            <tr>
                                <td>
                                    <input type="checkbox" class="review-checkbox" value="{{ $review->id }}" onchange="updateBulkActions()">
                                </td>
                                <td>
                                    <div>
                                        <div style="font-weight: 600; color: #1f2937;">{{ $review->user->name }}</div>
                                        <div style="font-size: 0.75rem; color: #6b7280;">{{ $review->user->email }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div style="display: flex; gap: 0.125rem;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star" style="color: {{ $i <= $review->rating ? '#fbbf24' : '#e5e7eb' }}; font-size: 0.875rem;"></i>
                                            @endfor
                                        </div>
                                        <span style="font-weight: 600; color: #374151;">{{ $review->rating }}/5</span>
                                    </div>
                                </td>
                                <td>
                                    <div style="max-width: 300px; line-height: 1.5; color: #374151;">
                                        {{ Str::limit($review->comment, 100) }}
                                    </div>
                                </td>
                                <td>
                                    <div style="color: #374151;">
                                        {{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') }}
                                    </div>
                                    <div style="font-size: 0.75rem; color: #6b7280;">
                                        {{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete({{ $review->id }})"
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
            @else
                <div class="empty-state">
                    <i class="fas fa-star"></i>
                    <h3>No Reviews Found</h3>
                    <p>This tourist attraction doesn't have any reviews yet.</p>
                    <br>
                    <a href="{{ route('admin.tourist-attractions') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Back to Tourist Attractions
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.review-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateBulkActions();
}

function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.review-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    if (bulkActions && selectedCount) {
        selectedCount.textContent = checkboxes.length;
        bulkActions.style.display = checkboxes.length > 0 ? 'block' : 'none';
    }
}

function bulkDelete() {
    const checkboxes = document.querySelectorAll('.review-checkbox');
    let hasChecked = false;
    
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            hasChecked = true;
        }
    });
    
    if (!hasChecked) {
        alert('Please select reviews to delete.');
        return;
    }
    
    // Check all boxes to show bulk actions
    checkboxes.forEach(checkbox => {
        if (!checkbox.checked) {
            checkbox.checked = true;
        }
    });
    
    updateBulkActions();
}

function bulkDeleteSelected() {
    const checkboxes = document.querySelectorAll('.review-checkbox:checked');
    const ids = Array.from(checkboxes).map(cb => cb.value);
    
    if (ids.length === 0) {
        alert('Please select reviews to delete.');
        return;
    }
    
    if (confirm(`Are you sure you want to delete ${ids.length} review(s)? This action cannot be undone.`)) {
        // Create and submit bulk delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/tourist-attractions/{{ $attraction->id }}/reviews/bulk-delete`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        ids.forEach(id => {
            const idField = document.createElement('input');
            idField.type = 'hidden';
            idField.name = 'review_ids[]';
            idField.value = id;
            form.appendChild(idField);
        });
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}

function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this review? This action cannot be undone.')) {
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/tourist-attractions/reviews/${id}`;
        
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
</script>
@endsection
