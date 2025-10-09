@extends('admin.dashboard')

@section('content')
<div class="admin-container" style="margin: 0; max-width: 100%; padding: 2rem;">
    <!-- Header Section -->
    <div class="admin-header" style="border-radius: 16px; margin-bottom: 2rem; padding: 1.5rem; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div>
            <h1><i class="fas fa-star"></i> Reviews for {{ $accommodation->name }}</h1>
            <p>Manage visitor reviews and ratings</p>
        </div>
        <a href="{{ route('admin.accommodations') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Accommodations
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

    <div class="admin-card" style="border-radius: 16px; margin-bottom: 2rem; padding: 1.5rem; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div class="card-header" style="margin-bottom: 1.5rem;">
            <div class="card-title" style="font-size: 1.25rem; font-weight: 600; color: #374151;">
                <i class="fas fa-chart-bar" style="margin-right: 0.5rem;"></i>
                Rating Overview
            </div>
        </div>
        <div class="card-content">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin: 0 -0.5rem;">
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
    <div class="admin-card" style="border-radius: 16px; padding: 1.5rem; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <!-- Card Header with Actions -->
        <div class="header-section">
            <div class="header-info">
                <h1>Reviews for {{ $accommodation->name }}</h1>
                <p>Manage visitor reviews and feedback</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($reviews->count() > 0)
        <div class="bulk-actions">
            <label>
                <input type="checkbox" id="select-all" class="select-all-checkbox"> Select All
            </label>
            <button type="button" id="bulk-delete-btn" class="bulk-delete-btn" disabled>
                <i class="fas fa-trash"></i> Delete Selected
            </button>
            <span id="selected-count">0 reviews selected</span>
        </div>

        <div class="table-container">
            <table class="reviews-table">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" id="select-all-header" style="cursor: pointer;">
                        </th>
                        <th>User</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Date</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                    <tr>
                        <td class="checkbox-cell">
                            <input type="checkbox" class="review-checkbox" value="{{ $review->id }}" style="cursor: pointer;">
                        </td>
                        <td>
                            <div class="user-info">
                                <div class="user-name">{{ $review->user->name ?? 'Anonymous' }}</div>
                                <div class="user-email">{{ $review->user->email ?? 'No email' }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="rating-display">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star" style="color: {{ $i <= $review->rating ? '#ffc107' : '#e9ecef' }};"></i>
                                    @endfor
                                </div>
                                <span class="rating-number">{{ $review->rating }}/5</span>
                            </div>
                        </td>
                        <td class="comment-cell">
                            {{ $review->comment ?: 'No comment provided' }}
                        </td>
                        <td class="date-cell">
                            {{ $review->created_at->format('M d, Y') }}<br>
                            <small>{{ $review->created_at->format('h:i A') }}</small>
                        </td>
                        <td class="action-cell">
                            <form method="POST" action="{{ route('admin.accommodations.reviews.delete', $review->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $reviews->links() }}
        </div>
        @else
        <div class="no-reviews">
            <i class="fas fa-comment-slash"></i>
            <h3>No Reviews Found</h3>
            <p>This accommodation doesn't have any reviews yet.</p>
        </div>
        @endif
    </div>
</div>

<style>
    .admin-container {
        padding: 2rem !important;
        margin: 0 !important;
        max-width: 100% !important;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        margin-bottom: 2rem;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .admin-card {
        padding: 1.5rem;
        margin-bottom: 2rem;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 1rem 0;
    }

    .bulk-actions {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .select-all-checkbox {
        margin-right: 10px;
    }

    .bulk-delete-btn {
        background: #dc3545;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: background-color 0.3s;
    }

    .bulk-delete-btn:hover {
        background: #c82333;
    }

    .bulk-delete-btn:disabled {
        background: #6c757d;
        cursor: not-allowed;
    }

    .table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin: 1rem 0;
    }

    .reviews-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .reviews-table th,
    .reviews-table td {
        padding: 18px 20px;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
        vertical-align: top;
    }

    .reviews-table th:first-child,
    .reviews-table td:first-child {
        padding-left: 24px;
    }

    .reviews-table th:last-child,
    .reviews-table td:last-child {
        padding-right: 24px;
    }

    .reviews-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #333;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .user-name {
        font-weight: 600;
        color: #333;
    }

    .user-email {
        color: #666;
        font-size: 0.9rem;
    }

    .rating-display {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .stars {
        color: #ffc107;
    }

    .rating-number {
        font-weight: 600;
        color: #333;
    }

    .comment-cell {
        max-width: 300px;
        word-wrap: break-word;
        line-height: 1.5;
    }

    .date-cell {
        color: #666;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .action-cell {
        text-align: center;
    }

    .delete-btn {
        background: #dc3545;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.85rem;
        transition: background-color 0.3s;
    }

    .delete-btn:hover {
        background: #c82333;
    }

    .no-reviews {
        text-align: center;
        padding: 80px 30px;
        color: #666;
        margin: 2rem 0;
    }

    .no-reviews i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #ddd;
    }

    .no-reviews h3 {
        margin: 20px 0 10px 0;
        color: #374151;
        font-size: 1.5rem;
    }

    .no-reviews p {
        margin: 0;
        font-size: 1rem;
        line-height: 1.5;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }

    .checkbox-cell {
        text-align: center;
        width: 50px;
    }

    .review-checkbox {
        cursor: pointer;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
    }

    .alert-success {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .alert-error {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const reviewCheckboxes = document.querySelectorAll('.review-checkbox');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    const selectedCountSpan = document.getElementById('selected-count');

    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
        const count = checkedBoxes.length;
        
        selectedCountSpan.textContent = `${count} reviews selected`;
        bulkDeleteBtn.disabled = count === 0;
        
        // Update select all checkbox state
        if (count === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (count === reviewCheckboxes.length) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
        }
    }

    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            reviewCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });
    }

    // Individual checkbox functionality
    reviewCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });

    // Initialize state
    updateBulkActions();
});
</script>

@endsection
