@extends('admin.dashboard')

@section('content')
<div class="admin-container" style="margin: 0; max-width: 100%; padding: 1.5rem;">
    <!-- Header Section -->
    <div class="admin-header" style="border-radius: 16px; margin-bottom: 2rem;">
        <div>
            <h1><i class="fas fa-comments"></i> Article Comments</h1>
            <p>Manage comments for "{{ $article->title ?? 'Article' }}"</p>
        </div>
        <a href="{{ route('admin.articles') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Articles
        </a>
    </div>

    <!-- Main Content Card -->
    <div class="admin-card" style="border-radius: 16px;">
        <!-- Card Header with Actions -->
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-list"></i>
                Comments Management
            </div>
            <div class="action-buttons">
                <div class="filter-group">
                    <input type="text" class="search-input" placeholder="Search comments..." id="searchInput" value="{{ request('search') }}">
                </div>
                <button type="button" class="btn btn-secondary" onclick="toggleFilters()">
                    <i class="fas fa-filter"></i> Filter Data
                </button>
                @if(isset($comments) && $comments->count() > 0)
                <button type="button" class="btn btn-danger" onclick="bulkDelete()">
                    <i class="fas fa-trash-alt"></i> Delete Selected
                </button>
                @endif
            </div>
        </div>

        <!-- Filters Section (Hidden by default) -->
        <div class="filters-section" id="filtersSection" style="display: none;">
            <form method="GET" action="{{ route('admin.articles.comments', $article) }}" class="filters-row">
                <div class="filter-group">
                    <label for="date_from">From Date</label>
                    <input type="date" name="date_from" id="date_from" class="filter-input" value="{{ request('date_from') }}">
                </div>
                <div class="filter-group">
                    <label for="date_from">From Date</label>
                    <input type="date" name="date_from" id="date_from" class="filter-input" value="{{ request('date_from') }}">
                </div>
                <div class="filter-group">
                    <label for="date_to">To Date</label>
                    <input type="date" name="date_to" id="date_to" class="filter-input" value="{{ request('date_to') }}">
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Apply Filters
                    </button>
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <a href="{{ route('admin.articles.comments', $article) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Bulk Actions -->
        @if(isset($comments) && $comments->count() > 0)
        <div class="bulk-actions" id="bulkActions" style="display: none;">
            <div class="bulk-actions-content">
                <span id="selectedCount">0</span> comment(s) selected
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
            @if(isset($comments) && $comments->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width: 40px;">
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                </th>
                                <th>Comment</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($comments as $comment)
                            <tr>
                                <td>
                                    <input type="checkbox" class="comment-checkbox" value="{{ $comment->id }}" onchange="updateBulkActions()">
                                </td>
                                <td>
                                    <div style="max-width: 400px;">
                                        <div style="color: #374151; line-height: 1.5; margin-bottom: 0.5rem;">
                                            {{ Str::limit($comment->content ?? '', 150) }}
                                        </div>
                                        @if(strlen($comment->content ?? '') > 150)
                                        <button type="button" class="btn btn-sm btn-link" onclick="toggleFullComment({{ $comment->id }})" style="padding: 0; font-size: 0.75rem;">
                                            <span id="toggle-text-{{ $comment->id }}">Show more</span>
                                        </button>
                                        <div id="full-comment-{{ $comment->id }}" style="display: none; color: #374151; line-height: 1.5; margin-top: 0.5rem;">
                                            {{ $comment->content }}
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        @if(isset($comment->user))
                                        <div style="font-weight: 600; color: #1f2937;">{{ $comment->user->name }}</div>
                                        <div style="font-size: 0.75rem; color: #6b7280;">
                                            <i class="fas fa-envelope" style="margin-right: 0.25rem;"></i>
                                            {{ $comment->user->email }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: #059669;">
                                            <i class="fas fa-user" style="margin-right: 0.25rem;"></i>
                                            Registered User
                                        </div>
                                        @else
                                        <div style="font-weight: 600; color: #1f2937;">{{ $comment->name ?? 'Anonymous' }}</div>
                                        <div style="font-size: 0.75rem; color: #6b7280;">
                                            <i class="fas fa-envelope" style="margin-right: 0.25rem;"></i>
                                            {{ $comment->email ?? 'No email' }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: #9ca3af;">
                                            <i class="fas fa-user-slash" style="margin-right: 0.25rem;"></i>
                                            Guest User
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="color: #374151;">
                                        {{ \Carbon\Carbon::parse($comment->created_at)->format('M d, Y') }}
                                    </div>
                                    <div style="font-size: 0.75rem; color: #6b7280;">
                                        {{ \Carbon\Carbon::parse($comment->created_at)->format('H:i') }}
                                    </div>
                                    <div style="font-size: 0.75rem; color: #6b7280;">
                                        {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete({{ $comment->id }})"
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
                @if(method_exists($comments, 'hasPages') && $comments->hasPages())
                    <div class="pagination">
                        {{ $comments->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="fas fa-comments"></i>
                    <h3>No Comments Found</h3>
                    <p>This article doesn't have any comments yet.</p>
                    <br>
                    <a href="{{ route('admin.articles') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Back to Articles
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.bulk-actions {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.bulk-actions-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.bulk-buttons {
    display: flex;
    gap: 0.5rem;
}
</style>

<script>
function toggleFilters() {
    const filtersSection = document.getElementById('filtersSection');
    filtersSection.style.display = filtersSection.style.display === 'none' ? 'block' : 'none';
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.comment-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateBulkActions();
}

function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.comment-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    if (bulkActions && selectedCount) {
        if (checkboxes.length > 0) {
            bulkActions.style.display = 'block';
            selectedCount.textContent = checkboxes.length;
        } else {
            bulkActions.style.display = 'none';
        }
    }
}

function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this comment? This action cannot be undone.')) {
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/articles/comments/${id}`;
        
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

function updateCommentStatus(id, status) {
    // Create and submit form to update status
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/articles/comments/${id}/update-status`;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    
    const statusField = document.createElement('input');
    statusField.type = 'hidden';
    statusField.name = 'status';
    statusField.value = status;
    
    form.appendChild(csrfToken);
    form.appendChild(statusField);
    document.body.appendChild(form);
    form.submit();
}

function bulkDeleteSelected() {
    const checkboxes = document.querySelectorAll('.comment-checkbox:checked');
    const ids = Array.from(checkboxes).map(cb => cb.value);
    
    if (ids.length === 0) {
        alert('Please select comments to delete.');
        return;
    }
    
    if (confirm(`Are you sure you want to delete ${ids.length} comment(s)? This action cannot be undone.`)) {
        // Create and submit bulk delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/articles/{{ $article->id }}/comments/bulk-delete`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        ids.forEach(id => {
            const idField = document.createElement('input');
            idField.type = 'hidden';
            idField.name = 'comment_ids[]';
            idField.value = id;
            form.appendChild(idField);
        });
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}

function toggleFullComment(id) {
    const fullComment = document.getElementById(`full-comment-${id}`);
    const toggleText = document.getElementById(`toggle-text-${id}`);
    
    if (fullComment.style.display === 'none') {
        fullComment.style.display = 'block';
        toggleText.textContent = 'Show less';
    } else {
        fullComment.style.display = 'none';
        toggleText.textContent = 'Show more';
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
