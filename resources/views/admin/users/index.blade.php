@extends('admin.dashboard')

@section('content')
<style>
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .status-featured {
        background: #ddd6fe;
        color: #7c3aed;
    }

    .status-info {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-danger {
        background: #fee2e2;
        color: #dc2626;
    }
</style>
<div class="admin-container">
    <!-- Header Section -->
    <div class="admin-header">
        <h1><i class="fas fa-users"></i> Users</h1>
        <p>Manage user accounts and permissions</p>
    </div>

    <!-- Main Content Card -->
    <div class="admin-card">
        <!-- Card Header with Actions -->
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-list"></i>
                Users Management
            </div>
            <div class="action-buttons">
                <div class="filter-group">
                    <input type="text" class="search-input" placeholder="Search users..." id="searchInput" value="{{ request('search') }}">
                </div>
                <button type="button" class="btn btn-secondary" onclick="toggleFilters()">
                    <i class="fas fa-filter"></i> Filter Data
                </button>
                <a href="{{ route('admin.users.create') ?? '#' }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add User
                </a>
            </div>
        </div>

        <!-- Filters Section (Hidden by default) -->
        <div class="filters-section" id="filtersSection" style="display: none;">
            <form method="GET" action="{{ route('admin.users') ?? '#' }}" class="filters-row">
                <div class="filter-group">
                    <label for="is_admin">Role</label>
                    <select name="is_admin" id="is_admin" class="filter-input">
                        <option value="">All Roles</option>
                        <option value="1" {{ request('is_admin') == '1' ? 'selected' : '' }}>Admin</option>
                        <option value="0" {{ request('is_admin') == '0' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="date_from">Joined From</label>
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
                    <a href="{{ route('admin.users') ?? '#' }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Content -->
        <div class="card-content">
            @if(isset($users) && $users->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div class="user-avatar" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 600; color: #1f2937;">{{ $user->name ?? 'Unknown' }}</div>
                                            <div style="font-size: 0.75rem; color: #6b7280;">{{ $user->email }}</div>
                                            <div style="font-size: 0.75rem; color: #6b7280;">ID: {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->is_admin)
                                        <span class="status-badge status-featured">
                                            <i class="fas fa-crown"></i> Admin
                                        </span>
                                    @else
                                        <span class="status-badge status-info">
                                            <i class="fas fa-user"></i> User
                                        </span>
                                    @endif
                                </td>
                                
                                <td>
                                    <div style="color: #374151;">
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}
                                    </div>
                                    <div style="font-size: 0.75rem; color: #6b7280;">
                                        {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.users.edit', $user) ?? '#' }}" class="btn btn-sm btn-primary" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->role !== 'admin')
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="confirmDelete({{ $user->id }})"
                                                    title="Delete User">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(method_exists($users, 'hasPages') && $users->hasPages())
                    <div class="pagination">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h3>No Users Found</h3>
                    <p>No users have registered yet.</p>
                    <br>
                    <a href="{{ route('admin.users.create') ?? '#' }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add First User
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
    if (confirm('Are you sure you want to delete this user? This action cannot be undone and will remove all user data.')) {
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${id}`;
        
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
    if (confirm(`Are you sure you want to ${status} this user?`)) {
        // Create and submit form to update status
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${id}/update-status`;
        
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

// email verification resend removed

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
