@extends('admin.dashboard')

@section('content')
<style>
    .filter-container {
        background: white;
        border-radius: 12px 12px 0 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .filter-form {
        display: flex;
        gap: 20px;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-group label {
        font-weight: 500;
        color: #333;
        font-size: 0.9rem;
    }

    .filter-select,
    .search-input,
    .price-input {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.9rem;
        min-width: 150px;
    }

    .price-input {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.5rem;
        min-width: 100px;
    }

    .search-input {
        min-width: 100px;
    }

    .filter-button {
        background: black;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.3s;
    }

    .filter-button:hover {
        background: #555;
    }

    .scroll-x {
        overflow-x: scroll;
    }

    .table-container {
        /* This is the key for overflow scrolling */
        overflow: auto;
        /* Allows both X and Y overflow */
        flex-grow: 1;

        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        /* Ensure the table fills its container */
        border-collapse: collapse;
        table-layout: fixed;
        /* This is crucial for handling overflow */
    }

    .id-cell {
        width: 10px;
    }

    .price-cell {
        width: 100px;
    }

    .stock-cell {
        width: 60px;
    }

    .single-button-cell {
        width: 60px;
    }


    th,
    td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
        vertical-align: top;
        /* Ensures content aligns to the top of the cell */
    }

    th {
        background-color: #f8f8f8;
        font-weight: 600;
        color: #555;
    }

    tr:hover {
        background-color: #f2f2f2;
    }

    td {
        word-wrap: normal;
        /* Allows long words to break and wrap to the next line */
    }

    .description-cell {
        min-height: 50px;

    }

    .operation-cell {
        display: flex;
        gap: 10px;
    }

    .status-btn {
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        color: white;
        cursor: pointer;
        font-weight: 500;
        position: relative;
        overflow: hidden;
        transition: background-color 0.3s ease;
        min-width: 60px;
    }

    .status-btn:hover {
        opacity: 60%;
    }

    .active-btn {
        background-color: #4CAF50;
    }

    .inactive-btn {
        background-color: #f44336;

    }

    .operation-container {
        background-color: white;
        width: 100%;
        font-weight: 600;
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        padding-top: 10px;
        padding-bottom: 10px;
        border-top: 1px solid #e0e0e0;
        border-radius: 0px 0px 12px 12px;
    }

    .delete-button {
        background: red;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .delete-button:hover {
        opacity: 60%;
    }

    .operation-container form {
        margin: 0;
    }

    .create-product-button {
        text-decoration: none;
        background: #4CAF50;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .create-product-button:hover {
        opacity: 60%;
    }

    .edit-product-button {
        text-decoration: none;
        background: #200fdb;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .edit-product-button:hover {
        opacity: 60%;
    }

    .status-select {
        padding: 5px 5px;
        border-radius: 8px;
        border: 1px solid #ccc;
        cursor: pointer;
        font-weight: 600;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-cancelled {
        background: #fecaca;
        color: #b91c1c;
    }
</style>
<script>
    // Function to automatically submit the form when a new status is selected
    function updateStatus(selectElement) {
        const form = selectElement.closest('form');
        form.submit();
    }

    // Function to set the initial class based on the current value
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.status-select').forEach(select => {
            const status = select.value;
            select.className = `status-select status-${status}`;
        });
    });
</script>
<div class="filter-container">
    <form method="GET" action="{{ route('admin.bookings') }}" class="filter-form" id="filterForm">
        <input type="hidden" name="filter_yes" value="1">
        <div class="filter-group">
            <input type="text" name="search" placeholder="Search by user or accommodation..." value="{{ request('search') }}" class="search-input">
        </div>

        <div class="filter-group">
            <select name="status" class="filter-select">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="filter-group">
            <select name="sort_by" class="filter-select">
                <option value="">Sort by</option>
                <option value="latest" {{ request('sort_by') == 'latest' ? 'selected' : '' }}>Latest Bookings</option>
                <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>Oldest Bookings</option>
            </select>
        </div>

        <button type="submit" class="filter-button">Filter</button>
    </form>
</div>
<table>
    <thead>
        <tr>
            <th class="id-cell">Id</th>
            <th>User</th>
            <th>Accommodation</th>
            <th>Room type</th>
            <th class="stock-cell">Room Count</th>
            <th>Check in date</th>
            <th>Check out date</th>
            <th>Duration (days)</th>
            <th>Total Price</th>
            <th class="single-button-cell">Status</th>
            <th>Notes</th>
            <th>Special Request</th>
        </tr>
    </thead>
</table>
<div class="table-container">

    <table>
        <tbody>
            @forelse ($bookings as $booking)
            <tr>
                <td class="id-cell">{{ $booking->id }}</td>
                <td>{{ $booking->user->name }}</td>
                <td>{{ $booking->accommodation->name }}</td>
                <td>{{ $booking->accommodationroomtype->name }}</td>
                <td class="stock-cell">{{ $booking->rooms_count }}</td>
                <td>{{ $booking->check_in_date }}</td>
                <td>{{ $booking->check_out_date }}</td>
                <td class="stock-cell">{{ $booking->duration_days }}</td>
                <td>{{ $booking->total_price }}</td>
                <td class="single-button-cell">
                    <form action="{{ route('admin.bookings.togglestatus', $booking->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="updateStatus(this)" class="status-select">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="active" {{ $booking->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </td>
                <td>
                    <div style="max-height: 100px; overflow-y: auto;">
                        {{ $booking->notes }}
                    </div>
                </td>
                <td>
                    <div style="max-height: 100px; overflow-y: auto;">
                        {{ $booking->special_requests }}
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">No bookings found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection