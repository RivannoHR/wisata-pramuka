@extends('admin.dashboard')

@section('content')
<style>
    .filters-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .filters-row {
        display: flex;
        gap: 20px;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
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

    .filter-input {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.9rem;
        min-width: 150px;
    }

    .filter-input:focus {
        outline: none;
        border-color: black;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .search-input {
        min-width: 250px;
    }

    .filter-button {
        background: black;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        margin-top: 20px;
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
        width: 50px;
        text-align: center;
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
        border-left: 1px solid #e0e0e0;
        border-right: 1px solid #e0e0e0;
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

    .stock-cell-header {
        font-size: small;
    }

    .description-cell {
        min-height: 50px;

    }

    .operation-cell {
        display: flex;
        gap: 10px;
        flex-direction: column;
        align-items: center;
    }

    .operation-cell button {
        width: 70px;
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
</style>

<div class="filter-section">
    <form method="GET" action="{{ route('accommodations.index') }}">
        <div class="filters-row">
            <div class="filter-group">
                <label for="search">Search</label>
                <input type="text" id="search" name="search" class="filter-input search-input"
                    placeholder="Search hotels, locations..." value="{{ request('search') }}">
            </div>

            <div class="filter-group">
                <label for="type">Type</label>
                <select id="type" name="type" class="filter-input">
                    @foreach($typesfilter as $value => $label)
                    <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="sort">Sort By</label>
                <select id="sort" name="sort" class="filter-input">
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="order">Order</label>
                <select id="order" name="order" class="filter-input">
                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>

            <div class="filter-group">
                <button type="submit" class="filter-button">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </div>
    </form>
</div>
<table>
    <thead>
        <tr>
            <th class="id-cell">ID</th>
            <th>Name</th>
            <th>Description</th>
            <th style="font-size:small">Accommodation type</th>
            <th>Location</th>
            <th class="stock-cell-header stock-cell">Rating</th>
            <th class="stock-cell-header stock-cell">Capacity</th>
            <th>Facilities</th>
            <th>Room Types</th>
            <th class="single-button-cell">Image Count</th>
            <th class="price-cell">Starting Price</th>
            <th class="single-button-cell">Is Active </th>
            <th>Operations</th>
        </tr>
    </thead>
</table>
<div class="table-container">

    <table>
        <tbody>
            @forelse ($accommodations as $accommodation)
            <tr>
                <td class="id-cell">{{ $accommodation->id }}</td>
                <td>{{ $accommodation->name }}</td>
                <td>
                    <div style="max-height: 100px; overflow-y: auto;">
                        {{ $accommodation->description }}
                    </div>
                </td>
                <td>{{ $accommodation->type }}</td>
                <td>
                    <div style="max-height: 100px; overflow-y: auto;">
                        {{ $accommodation->location }}
                    </div>
                </td>
                <td class="stock-cell">{{ $accommodation->rating }}</td>
                <td class="stock-cell">{{ $accommodation->capacity }}</td>
                <td>
                    <div style="max-height: 100px; overflow-y: auto;">
                        {{ implode(', ', $accommodation->facilities) }}
                    </div>
                </td>
                <td style="max-height: 100px; overflow-y: auto;">
                    @foreach ($accommodation->roomTypes as $roomType )
                    <div> {{ $roomType->name }} </div>
                    <br>
                    @endforeach
                </td>
                <td class="single-button-cell" style="text-align: center;">
                    <div>{{ $accommodation->img_count }}</div>
                    <br>
                    <form action="{{ route('admin.accommodations.images', $accommodation->id) }}" method="GET">
                        <button type="submit" class="edit-product-button">
                            Edit Images
                        </button>
                    </form>
                </td>
                <td class="price-cell">Rp{{ $accommodation->lowest_price }}</td>
                <td class="single-button-cell">
                    <form action="{{ route('admin.accommodations.toggle.isactive',$accommodation->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="status-btn {{ $accommodation->is_active ? 'active-btn' : 'inactive-btn' }}"
                            type="submit" title="click to change">
                            {{ $accommodation->is_active ? 'Yes' : 'No' }}
                        </button>

                    </form>

                </td>
                <td>
                    <div class="operation-cell">
                        <form action="{{ route('admin.accommodations.edit', $accommodation->id) }}" method="GET">
                            <button type="submit" class="edit-product-button">
                                Edit
                            </button>
                        </form>
                        <form
                            action="{{ route('admin.accommodations.delete', $accommodation->id) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this accommodation? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">No Accommodations Found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


<div class="operation-container">
    <form
        action="{{ route('admin.accommodations.delete.all') }}"
        method="POST"
        onsubmit="return confirm('Are you absolutely sure you want to delete all products? This action cannot be undone.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-button">
            Delete All Products
        </button>
    </form>
    <form action="{{ route('admin.accommodations.create') }}" method="GET">
        <button type="submit" class="create-product-button">
            Add Product
        </button>
    </form>
</div>

@endsection