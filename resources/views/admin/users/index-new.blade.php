@extends('admin.dashboard')

@section('content')
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
                    <i class="fas fa-filter"></i> Edit Data
                </button>
                <a href="{{ route('admin.users.create') ?? '#' }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Lorem +
                </a>
            </div>
        </div>

        <!-- Filters Section (Hidden by default) -->
        <div class="filters-section" id="filtersSection" style="display: none;">
            <form method="GET" action="{{ route('admin.users') ?? '#' }}" class="filters-row">
                <div class="filter-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="filter-input">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="moderator" {{ request('role') == 'moderator' ? 'selected' : '' }}>Moderator</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="filter-input">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Banned</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="verified">Email Verified</label>
                    <select name="verified" id="verified" class="filter-input">
                        <option value="">All Users</option>
                        <option value="1" {{ request('verified') == '1' ? 'selected' : '' }}>Verified</option>
                        <option value="0" {{ request('verified') == '0' ? 'selected' : '' }}>Unverified</option>
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
                                <th>Email Status</th>
                                <th>Joined</th>
                                <th>Last Active</th>
                                <th>Status</th>
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
                                    @php
                                        $role = $user->role ?? 'user';
                                        $roleClass = match($role) {
                                            'admin' => 'status-featured',
                                            'moderator' => 'status-warning',
                                            default => 'status-info'
                                        };
                                        $roleIcon = match($role) {
                                            'admin' => 'fas fa-crown',
                                            'moderator' => 'fas fa-shield-alt',
                                            default => 'fas fa-user'
                                        };
                                    @endphp
                                    <span class="status-badge {{ $roleClass }}">
                                        <i class="{{ $roleIcon }}"></i> {{ ucfirst($role) }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle"></i> Verified
                                        </span>
                                    @else
                                        <span class="status-badge status-warning">
                                            <i class="fas fa-exclamation-circle"></i> Unverified
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
                                    <div style="color: #374151;">
                                        {{ isset($user->last_login_at) ? \Carbon\Carbon::parse($user->last_login_at)->format('M d, Y') : 'Never' }}
                                    </div>
                                    @if(isset($user->last_login_at))
                                    <div style="font-size: 0.75rem; color: #6b7280;">
                                        {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $status = $user->status ?? 'active';
                                        $statusClass = match($status) {
                                            'active' => 'status-active',
                                            'banned' => 'status-inactive',
                                            default => 'status-warning'
                                        };
                                        $statusIcon = match($status) {
                                            'active' => 'fas fa-check-circle',
                                            'banned' => 'fas fa-ban',
                                            default => 'fas fa-pause-circle'
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        <i class="{{ $statusIcon }}"></i> {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="#" class="btn btn-sm btn-secondary" title="View Profile">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) ?? '#' }}" class="btn btn-sm btn-primary" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($status === 'active')
                                            <button type="button" class="btn btn-sm btn-warning" onclick="updateStatus({{ $user->id }}, 'inactive')" title="Deactivate User">
                                                <i class="fas fa-pause"></i>
                                            </button>
                                        @elseif($status === 'inactive')
                                            <button type="button" class="btn btn-sm btn-success" onclick="updateStatus({{ $user->id }}, 'active')" title="Activate User">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        @endif
                                        @if($status !== 'banned')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="updateStatus({{ $user->id }}, 'banned')" title="Ban User">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        @endif
                                        @if(!$user->email_verified_at)
                                            <button type="button" class="btn btn-sm btn-info" onclick="resendVerification({{ $user->id }})" title="Resend Verification">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        @endif
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

function resendVerification(id) {
    if (confirm('Resend email verification to this user?')) {
        // Create and submit form to resend verification
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${id}/resend-verification`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        form.appendChild(csrfToken);
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
