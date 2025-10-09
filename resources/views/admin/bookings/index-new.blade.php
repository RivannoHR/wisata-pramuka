@extends('admin.dashboard')

@section('content')
<div class="admin-container">
    <!-- Header Section -->
    <div class="admin-header">
        <h1><i class="fas fa-calendar-check"></i> Bookings</h1>
        <p>Manage accommodation bookings and reservations</p>
    </div>

    <!-- Main Content Card -->
    <div class="admin-card">
        <!-- Card Header with Actions -->
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-list"></i>
                Bookings Management
            </div>
            <div class="action-buttons">
                <div class="filter-group">
                    <input type="text" class="search-input" placeholder="Search bookings..." id="searchInput" value="{{ request('search') }}">
                </div>
                <button type="button" class="btn btn-secondary" onclick="toggleFilters()">
                    <i class="fas fa-filter"></i> Edit Data
                </button>
                <a href="{{ route('admin.bookings.create') ?? '#' }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Lorem +
                </a>
            </div>
        </div>

        <!-- Filters Section (Hidden by default) -->
        <div class="filters-section" id="filtersSection" style="display: none;">
            <form method="GET" action="{{ route('admin.bookings') ?? '#' }}" class="filters-row">
                <div class="filter-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="filter-input">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
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
                    <label for="accommodation">Accommodation</label>
                    <select name="accommodation" id="accommodation" class="filter-input">
                        <option value="">All Accommodations</option>
                        @if(isset($accommodationsList))
                            @foreach($accommodationsList as $acc)
                                <option value="{{ $acc->id }}" {{ request('accommodation') == $acc->id ? 'selected' : '' }}>
                                    {{ $acc->name }}
                                </option>
                            @endforeach
                        @endif
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
                    <a href="{{ route('admin.bookings') ?? '#' }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Content -->
        <div class="card-content">
            @if(isset($bookings) && $bookings->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Guest</th>
                                <th>Accommodation</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Guests</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td>
                                    <div style="font-weight: 600; color: #1f2937;">#{{ $booking->id }}</div>
                                    <div style="font-size: 0.75rem; color: #6b7280;">
                                        {{ \Carbon\Carbon::parse($booking->created_at)->format('M d, Y') }}
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div style="font-weight: 600; color: #1f2937;">{{ $booking->guest_name ?? 'N/A' }}</div>
                                        <div style="font-size: 0.75rem; color: #6b7280;">
                                            <i class="fas fa-envelope" style="margin-right: 0.25rem;"></i>
                                            {{ $booking->guest_email ?? 'N/A' }}
                                        </div>
                                        @if($booking->guest_phone)
                                        <div style="font-size: 0.75rem; color: #6b7280;">
                                            <i class="fas fa-phone" style="margin-right: 0.25rem;"></i>
                                            {{ $booking->guest_phone }}
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 500; color: #374151;">
                                        {{ $booking->accommodation->name ?? 'Unknown' }}
                                    </div>
                                    @if(isset($booking->accommodation->location))
                                    <div style="font-size: 0.75rem; color: #6b7280;">
                                        <i class="fas fa-map-marker-alt" style="margin-right: 0.25rem;"></i>
                                        {{ $booking->accommodation->location }}
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <div style="color: #374151;">
                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}
                                    </div>
                                    <div style="font-size: 0.75rem; color: #6b7280;">
                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('l') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="color: #374151;">
                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}
                                    </div>
                                    <div style="font-size: 0.75rem; color: #6b7280;">
                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('l') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="fas fa-users" style="color: #6b7280;"></i>
                                        <span style="color: #374151;">{{ $booking->number_of_guests ?? 1 }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #059669;">
                                        Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $status = $booking->status ?? 'pending';
                                        $statusClass = match($status) {
                                            'confirmed' => 'status-active',
                                            'cancelled' => 'status-inactive',
                                            'completed' => 'status-featured',
                                            default => 'status-warning'
                                        };
                                        $statusIcon = match($status) {
                                            'confirmed' => 'fas fa-check-circle',
                                            'cancelled' => 'fas fa-times-circle',
                                            'completed' => 'fas fa-star',
                                            default => 'fas fa-clock'
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        <i class="{{ $statusIcon }}"></i> {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="#" class="btn btn-sm btn-secondary" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($status === 'pending')
                                            <button type="button" class="btn btn-sm btn-success" onclick="updateStatus({{ $booking->id }}, 'confirmed')" title="Confirm Booking">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="updateStatus({{ $booking->id }}, 'cancelled')" title="Cancel Booking">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @elseif($status === 'confirmed')
                                            <button type="button" class="btn btn-sm btn-info" onclick="updateStatus({{ $booking->id }}, 'completed')" title="Mark as Completed">
                                                <i class="fas fa-flag-checkered"></i>
                                            </button>
                                        @endif
                                        <a href="{{ route('admin.bookings.edit', $booking) ?? '#' }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete({{ $booking->id }})"
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
                @if(method_exists($bookings, 'hasPages') && $bookings->hasPages())
                    <div class="pagination">
                        {{ $bookings->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="fas fa-calendar-check"></i>
                    <h3>No Bookings Found</h3>
                    <p>No accommodation bookings have been made yet.</p>
                    <br>
                    <a href="{{ route('admin.accommodations') ?? '#' }}" class="btn btn-primary">
                        <i class="fas fa-bed"></i> Manage Accommodations
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
    if (confirm('Are you sure you want to delete this booking? This action cannot be undone.')) {
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/bookings/${id}`;
        
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
    if (confirm(`Are you sure you want to mark this booking as ${status}?`)) {
        // Create and submit form to update status
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/bookings/${id}/update-status`;
        
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
