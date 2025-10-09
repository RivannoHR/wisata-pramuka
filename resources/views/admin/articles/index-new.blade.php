@extends('admin.dashboard')

@section('content')
<div class="admin-container">
    <!-- Header Section -->
    <div class="admin-header">
        <h1><i class="fas fa-newspaper"></i> Articles</h1>
        <p>Manage blog posts, news articles, and content</p>
    </div>

    <!-- Main Content Card -->
    <div class="admin-card">
        <!-- Card Header with Actions -->
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-list"></i>
                Articles Management
            </div>
            <div class="action-buttons">
                <div class="filter-group">
                    <input type="text" class="search-input" placeholder="Search articles..." id="searchInput" value="{{ request('search') }}">
                </div>
                <button type="button" class="btn btn-secondary" onclick="toggleFilters()">
                    <i class="fas fa-filter"></i> Edit Data
                </button>
                <a href="{{ route('admin.articles.create') ?? '#' }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Lorem +
                </a>
            </div>
        </div>

        <!-- Filters Section (Hidden by default) -->
        <div class="filters-section" id="filtersSection" style="display: none;">
            <form method="GET" action="{{ route('admin.articles') ?? '#' }}" class="filters-row">
                <div class="filter-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="filter-input">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="filter-input">
                        <option value="">All Categories</option>
                        <option value="news" {{ request('category') == 'news' ? 'selected' : '' }}>News</option>
                        <option value="guide" {{ request('category') == 'guide' ? 'selected' : '' }}>Guide</option>
                        <option value="tips" {{ request('category') == 'tips' ? 'selected' : '' }}>Tips</option>
                        <option value="announcement" {{ request('category') == 'announcement' ? 'selected' : '' }}>Announcement</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="author">Author</label>
                    <select name="author" id="author" class="filter-input">
                        <option value="">All Authors</option>
                        @if(isset($authors))
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="filter-group">
                    <label for="date_from">From Date</label>
                    <input type="date" name="date_from" id="date_from" class="filter-input" value="{{ request('date_from') }}">
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Apply Filters
                    </button>
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <a href="{{ route('admin.articles') ?? '#' }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Content -->
        <div class="card-content">
            @if(isset($articles) && $articles->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Article</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Published</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Comments</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        @if(isset($article->featuredImage) && $article->featuredImage)
                                            <img src="{{ asset('storage/' . $article->featuredImage->image_path) }}" 
                                                 alt="{{ $article->title }}" 
                                                 class="img-thumbnail">
                                        @else
                                            <div class="img-thumbnail" style="background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-image" style="color: #9ca3af;"></i>
                                            </div>
                                        @endif
                                        <div style="max-width: 300px;">
                                            <div style="font-weight: 600; color: #1f2937;">{{ $article->title }}</div>
                                            <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem; line-height: 1.3;">
                                                {{ Str::limit($article->excerpt ?? strip_tags($article->content ?? ''), 60) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-info">
                                        {{ ucfirst($article->category ?? 'General') }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <div style="font-weight: 500; color: #374151;">{{ $article->author->name ?? 'Unknown' }}</div>
                                        <div style="font-size: 0.75rem; color: #6b7280;">
                                            {{ isset($article->author) ? $article->author->email : 'N/A' }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="color: #374151;">
                                        {{ isset($article->published_at) ? \Carbon\Carbon::parse($article->published_at)->format('M d, Y') : 'Not Published' }}
                                    </div>
                                    @if(isset($article->published_at))
                                    <div style="font-size: 0.75rem; color: #6b7280;">
                                        {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $status = $article->status ?? 'draft';
                                        $statusClass = match($status) {
                                            'published' => 'status-active',
                                            'archived' => 'status-inactive',
                                            default => 'status-warning'
                                        };
                                        $statusIcon = match($status) {
                                            'published' => 'fas fa-check-circle',
                                            'archived' => 'fas fa-archive',
                                            default => 'fas fa-edit'
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        <i class="{{ $statusIcon }}"></i> {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="fas fa-eye" style="color: #6b7280;"></i>
                                        <span style="color: #374151;">{{ $article->views_count ?? 0 }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="fas fa-comments" style="color: #6b7280;"></i>
                                        <span style="color: #374151;">{{ isset($article->comments) ? $article->comments->count() : 0 }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="#" class="btn btn-sm btn-secondary" title="View Article">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.articles.edit', $article) ?? '#' }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-secondary" title="Manage Images">
                                            <i class="fas fa-images"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info" title="Manage Comments">
                                            <i class="fas fa-comments"></i>
                                        </a>
                                        @if($status === 'draft')
                                            <button type="button" class="btn btn-sm btn-success" onclick="updateStatus({{ $article->id }}, 'published')" title="Publish Article">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        @elseif($status === 'published')
                                            <button type="button" class="btn btn-sm btn-warning" onclick="updateStatus({{ $article->id }}, 'archived')" title="Archive Article">
                                                <i class="fas fa-archive"></i>
                                            </button>
                                        @endif
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete({{ $article->id }})"
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
                @if(method_exists($articles, 'hasPages') && $articles->hasPages())
                    <div class="pagination">
                        {{ $articles->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="fas fa-newspaper"></i>
                    <h3>No Articles Found</h3>
                    <p>Start creating engaging content for your visitors.</p>
                    <br>
                    <a href="{{ route('admin.articles.create') ?? '#' }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Write First Article
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
    if (confirm('Are you sure you want to delete this article? This action cannot be undone.')) {
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/articles/${id}`;
        
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

function updateStatus(id, status) {
    if (confirm(`Are you sure you want to ${status} this article?`)) {
        // Create and submit form to update status
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/articles/${id}/update-status`;
        
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
