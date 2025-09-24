@extends('admin.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-tables.css') }}">
<style>
    .header-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-info h1 {
        margin: 0 0 10px 0;
        color: #333;
        font-size: 1.8rem;
    }

    .header-info p {
        margin: 0;
        color: #666;
        font-size: 1rem;
    }

    .back-link {
        background: #6c757d;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 8px;
        transition: background-color 0.3s;
    }

    .back-link:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
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
    }

    .comments-table {
        width: 100%;
        border-collapse: collapse;
    }

    .comments-table th,
    .comments-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
        vertical-align: top;
    }

    .comments-table th {
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

    .comment-cell {
        max-width: 350px;
        word-wrap: break-word;
        line-height: 1.5;
    }

    .comment-preview {
        color: #333;
        font-size: 0.95rem;
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

    .no-comments {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .no-comments i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #ddd;
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

    .comment-checkbox {
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

    .article-title {
        color: #007bff;
        font-weight: 600;
    }
</style>

<div class="header-section">
    <div class="header-info">
        <h1>Comments for <span class="article-title">{{ $article->title }}</span></h1>
        <p>Manage reader comments and feedback</p>
    </div>
    <a href="{{ route('admin.articles') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Articles
    </a>
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

@if($comments->count() > 0)
<div class="bulk-actions">
    <label>
        <input type="checkbox" id="select-all" class="select-all-checkbox"> Select All
    </label>
    <button type="button" id="bulk-delete-btn" class="bulk-delete-btn" disabled>
        <i class="fas fa-trash"></i> Delete Selected
    </button>
    <span id="selected-count">0 comments selected</span>
</div>

<div class="table-container">
    <table class="comments-table">
        <thead>
            <tr>
                <th class="checkbox-cell">
                    <i class="fas fa-check"></i>
                </th>
                <th>User</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
            <tr>
                <td class="checkbox-cell">
                    <input type="checkbox" name="comment_ids[]" value="{{ $comment->id }}" class="comment-checkbox">
                </td>
                <td>
                    <div class="user-info">
                        <div class="user-name">{{ $comment->user->name }}</div>
                        <div class="user-email">{{ $comment->user->email }}</div>
                    </div>
                </td>
                <td class="comment-cell">
                    <div class="comment-preview">
                        {{ Str::limit($comment->content, 150) }}
                    </div>
                </td>
                <td class="date-cell">
                    {{ $comment->created_at->format('M d, Y') }}<br>
                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                </td>
                <td class="action-cell">
                    <form action="{{ route('admin.articles.comments.delete', $comment->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this comment?')">
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
    {{ $comments->links() }}
</div>

<!-- Bulk Delete Form -->
<form id="bulk-delete-form" action="{{ route('admin.articles.comments.bulk-delete', $article->id) }}" method="POST" style="display: none;">
    @csrf
    <div id="bulk-delete-inputs"></div>
</form>

@else
<div class="table-container">
    <div class="no-comments">
        <i class="fas fa-comment-slash"></i>
        <h3>No Comments Found</h3>
        <p>This article doesn't have any comments yet.</p>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const commentCheckboxes = document.querySelectorAll('.comment-checkbox');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    const selectedCountSpan = document.getElementById('selected-count');
    const bulkDeleteForm = document.getElementById('bulk-delete-form');
    const bulkDeleteInputs = document.getElementById('bulk-delete-inputs');

    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.comment-checkbox:checked');
        const count = checkedBoxes.length;
        
        selectedCountSpan.textContent = `${count} comments selected`;
        bulkDeleteBtn.disabled = count === 0;
        
        // Update select all checkbox state
        if (count === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (count === commentCheckboxes.length) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
        }
    }

    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        commentCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    // Individual checkbox functionality
    commentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });

    // Bulk delete functionality
    bulkDeleteBtn.addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('.comment-checkbox:checked');
        
        if (checkedBoxes.length === 0) {
            alert('Please select comments to delete.');
            return;
        }

        if (confirm(`Are you sure you want to delete ${checkedBoxes.length} selected comments? This action cannot be undone.`)) {
            // Clear previous inputs
            bulkDeleteInputs.innerHTML = '';
            
            // Add checked comment IDs to form
            checkedBoxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'comment_ids[]';
                input.value = checkbox.value;
                bulkDeleteInputs.appendChild(input);
            });
            
            // Submit form
            bulkDeleteForm.submit();
        }
    });

    // Initialize state
    updateBulkActions();
});
</script>

@endsection
