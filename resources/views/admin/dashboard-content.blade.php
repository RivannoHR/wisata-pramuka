@extends('admin.dashboard')

@section('content')
<style>
    .dashboard-container {
        padding: 20px;
        max-width: 100%;
    }

    .dashboard-header {
        margin-bottom: 30px;
    }

    .dashboard-title {
        font-size: 28px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .dashboard-subtitle {
        color: #666;
        font-size: 16px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-left: 4px solid #2A5934;
    }

    .notification-card {
        border-left-color: #dc3545;
    }

    .views-card {
        border-left-color: #28a745;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .card-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .notification-badge {
        background: #dc3545;
        color: white;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .booking-info {
        flex-grow: 1;
    }

    .booking-id {
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .booking-details {
        font-size: 12px;
        color: #666;
        margin-top: 4px;
    }

    .quick-action-btn {
        background: #28a745;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: background-color 0.2s;
        text-decoration: none;
        display: inline-block;
    }

    .quick-action-btn:hover {
        background: #218838;
        color: white;
        text-decoration: none;
    }

    .booking-actions {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .approve-btn {
        background: #28a745;
        padding: 4px 8px;
        font-size: 10px;
    }

    .approve-btn:hover {
        background: #218838;
    }

    .reject-btn {
        background: #dc3545;
        padding: 4px 8px;
        font-size: 10px;
    }

    .reject-btn:hover {
        background: #c82333;
    }

    .pending-booking {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border-radius: 6px;
        background: #f8f9fa;
        margin-bottom: 8px;
        border-left: 3px solid #ffc107;
    }

    .view-all-btn {
        background: #6c757d;
        margin-top: 15px;
        display: block;
        text-align: center;
        padding: 10px;
    }

    .view-all-btn:hover {
        background: #5a6268;
    }

    .top-items-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .top-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .top-item:last-child {
        border-bottom: none;
    }

    .item-info {
        flex-grow: 1;
    }

    .item-name {
        font-weight: 600;
        color: #333;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .item-category {
        font-size: 12px;
        color: #666;
    }

    .view-count {
        background: #e9ecef;
        color: #495057;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .no-data {
        text-align: center;
        color: #666;
        font-style: italic;
        padding: 20px;
    }

    .category-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .category-tab {
        background: #e9ecef;
        color: #495057;
        border: none;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .category-tab.active {
        background: #2A5934;
        color: white;
    }

    .category-content {
        display: none;
    }

    .category-content.active {
        display: block;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .pending-booking {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .booking-actions {
            align-self: flex-end;
        }
    }
</style>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Admin Dashboard</h1>
        <p class="dashboard-subtitle">Welcome back! Here's what's happening with your tourism site.</p>
    </div>

    <div class="stats-grid">
        <!-- Pending Bookings Notification Card -->
        <div class="stat-card notification-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-circle"></i> Pending Bookings
                </h3>
                @if($pendingBookingsCount > 0)
                <span class="notification-badge">{{ $pendingBookingsCount }}</span>
                @endif
            </div>

            @if($pendingBookingsCount > 0)
                @foreach($pendingBookings as $booking)
                <div class="pending-booking">
                    <div class="booking-info">
                        <div class="booking-id">{{ $booking->booking_id }}</div>
                        <div class="booking-details">
                            {{ $booking->user->name ?? 'Guest' }} • {{ $booking->accommodation->name ?? 'N/A' }}
                            <br>
                            <small>{{ $booking->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="booking-actions">
                        <form class="booking-update-form" method="POST" action="{{ route('bookings.updateStatus', $booking->id) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="active">
                            <button type="submit" class="quick-action-btn approve-btn" title="Approve Booking">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <form class="booking-update-form" method="POST" action="{{ route('bookings.updateStatus', $booking->id) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="quick-action-btn reject-btn" title="Cancel Booking">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
                
                <a href="{{ route('admin.bookings') }}" class="quick-action-btn view-all-btn">
                    View All Bookings
                </a>
            @else
                <div class="no-data">
                    <i class="fas fa-check-circle" style="color: #28a745; font-size: 24px; margin-bottom: 10px;"></i>
                    <p>No pending bookings! 🎉</p>
                </div>
            @endif
        </div>

        <!-- Top Visited Items Card -->
        <div class="stat-card views-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-eye"></i> Most Visited Items
                </h3>
            </div>

            <div class="category-tabs">
                <button class="category-tab active" onclick="showCategory('products')">Products</button>
                <button class="category-tab" onclick="showCategory('accommodations')">Hotels</button>
                <button class="category-tab" onclick="showCategory('attractions')">Attractions</button>
            </div>

            <!-- Products Tab -->
            <div id="products" class="category-content active">
                @if($topProducts->count() > 0)
                <ul class="top-items-list">
                    @foreach($topProducts as $index => $product)
                    <li class="top-item">
                        <div class="item-info">
                            <div class="item-name">{{ Str::limit($product->title, 30) }}</div>
                            <div class="item-category">Product • Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>
                        <span class="view-count">{{ $product->view_count }} views</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="no-data">No products data available</div>
                @endif
            </div>

            <!-- Accommodations Tab -->
            <div id="accommodations" class="category-content">
                @if($topAccommodations->count() > 0)
                <ul class="top-items-list">
                    @foreach($topAccommodations as $accommodation)
                    <li class="top-item">
                        <div class="item-info">
                            <div class="item-name">{{ Str::limit($accommodation->name, 30) }}</div>
                            <div class="item-category">Hotel • {{ $accommodation->bookings_count }} bookings</div>
                        </div>
                        <span class="view-count">{{ $accommodation->view_count }} views</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="no-data">No accommodations data available</div>
                @endif
            </div>

            <!-- Tourist Attractions Tab -->
            <div id="attractions" class="category-content">
                @if($topAttractions->count() > 0)
                <ul class="top-items-list">
                    @foreach($topAttractions as $attraction)
                    <li class="top-item">
                        <div class="item-info">
                            <div class="item-name">{{ Str::limit($attraction->name, 30) }}</div>
                            <div class="item-category">Tourist Attraction • {{ $attraction->location }}</div>
                        </div>
                        <span class="view-count">{{ $attraction->view_count }} views</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="no-data">No attractions data available</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="stat-card" style="margin-top: 20px;">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-bolt"></i> Quick Actions
            </h3>
        </div>
        
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('admin.bookings') }}" class="quick-action-btn">
                <i class="fas fa-calendar-check"></i> Manage Bookings
            </a>
            <a href="{{ route('admin.products.create') }}" class="quick-action-btn" style="background: #007bff;">
                <i class="fas fa-plus"></i> Add Product
            </a>
            <a href="{{ route('admin.accommodations.create') }}" class="quick-action-btn" style="background: #6f42c1;">
                <i class="fas fa-bed"></i> Add Hotel
            </a>
            <a href="{{ route('admin.tourist-attractions.create') }}" class="quick-action-btn" style="background: #fd7e14;">
                <i class="fas fa-map-marked-alt"></i> Add Attraction
            </a>
        </div>
    </div>
</div>

<script>
// Booking status update confirmation
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.booking-update-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const status = this.querySelector('input[name="status"]').value;
            const actionText = status === 'active' ? 'approve' : 'cancel';
            
            if (!confirm(`Are you sure you want to ${actionText} this booking?`)) {
                e.preventDefault();
            }
        });
    });
});

function showCategory(category) {
    // Hide all categories
    document.querySelectorAll('.category-content').forEach(content => {
        content.classList.remove('active');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.category-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Show selected category content
    document.getElementById(category).classList.add('active');
    
    // Add active class to clicked tab
    event.target.classList.add('active');
}

// Auto-refresh pending bookings every 30 seconds
setInterval(() => {
    // You can implement AJAX refresh here if needed
    // For now, we'll just reload the page every 5 minutes to keep it simple
}, 30000);
</script>

@endsection
