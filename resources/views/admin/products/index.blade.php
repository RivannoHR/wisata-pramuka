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

    .image-cell {
        /* Required to position the zoom image correctly */
        position: relative;
        text-align: center;
    }

    .small-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        /* Ensures images fill the space without distortion */
        cursor: pointer;
        border-radius: 8px;
        transition: transform 0.2s ease-in-out;
    }

    /* Style for the dynamically created large image */
    #large-image-container {
        display: none;
        /* Initially hidden */
        position: fixed;
        top: 50%;
        left: 45%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.8);
        padding: 10px;
        border-radius: 10px;
        z-index: 1000;
    }

    #large-image-container img {
        max-width: 50vw;
        max-height: 50vh;
        border-radius: 8px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const smallImages = document.querySelectorAll('.small-image');
        let largeImageContainer = document.getElementById('large-image-container');

        // Create the large image container if it doesn't exist
        if (!largeImageContainer) {
            largeImageContainer = document.createElement('div');
            largeImageContainer.id = 'large-image-container';
            document.body.appendChild(largeImageContainer);
        }

        smallImages.forEach(image => {
            image.addEventListener('mouseenter', function() {
                const largeImageUrl = this.dataset.largeImage;

                largeImageContainer.innerHTML = `<img src="${largeImageUrl}" alt="${this.alt}">`;
                largeImageContainer.style.display = 'block';
            });

            image.addEventListener('mouseleave', function() {
                largeImageContainer.style.display = 'none';
                largeImageContainer.innerHTML = ''; // Clear the image to free up memory
            });
        });
    });
</script>
<div class="filter-container">
    <form method="GET" action="{{ route('admin.products') }}" class="filter-form" id="filterForm">
        <input type="hidden" name="filter_yes" value="1">
        <div class="filter-group">
            <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" class="search-input">
        </div>

        <div class="filter-group">
            <select name="sort_by" class="filter-select">
                <option value="">Sort by</option>
                <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                <option value="stock_asc" {{ request('sort_by') == 'stock_asc' ? 'selected' : '' }}>Stock (Low to High)</option>
                <option value="stock_desc" {{ request('sort_by') == 'stock_desc' ? 'selected' : '' }}>Stock (High to Low)</option>
            </select>
        </div>

        <div class="filter-group">
            <input type="number" name="min_price" placeholder="Min Price" value="{{ request('min_price') }}" class="price-input">
        </div>
        <div class="filter-group">
            <input type="number" name="max_price" placeholder="Max Price" value="{{ request('max_price') }}" class="price-input">
        </div>

        <div class="filter-group">
            <select name="stock_filter" class="filter-select">
                <option value="">Stock Status</option>
                <option value="in_stock" {{ request('stock_filter') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                <option value="low_stock" {{ request('stock_filter') == 'low_stock' ? 'selected' : '' }}>Low Stock (≤5)</option>
                <option value="out_of_stock" {{ request('stock_filter') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
            </select>
        </div>

        <button type="submit" class="filter-button">Filter</button>
    </form>
</div>
<table>
    <thead>
        <tr>
            <th class="id-cell">Id</th>
            <th>Product</th>
            <th>Description</th>
            <th class="price-cell">Price</th>
            <th class="stock-cell">Stock</th>
            <th class="single-button-cell">Is Active</th>
            <th class="single-button-cell">Is Featured</th>
            <th style="text-align: center;">Image</th>
            <th>Operations</th>

        </tr>
    </thead>
</table>
<div class="table-container">

    <table>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td class="id-cell">{{ $product->id }}</td>
                <td>{{ $product->title }}</td>
                <td>
                    <div style="max-height: 100px; overflow-y: auto;">
                        {{ $product->description }}
                    </div>
                </td>
                <td class="price-cell">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="stock-cell">{{ $product->stock }}</td>
                <td class="single-button-cell">
                    <form action="{{ route('admin.products.toggle.isactive', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="status-btn {{ $product->is_active ? 'active-btn' : 'inactive-btn' }}"
                            type="submit" title="click to change">
                            {{ $product->is_active ? 'Yes' : 'No' }}
                        </button>

                    </form>

                </td>
                <td class="single-button-cell">
                    <form action="{{ route('admin.products.toggle.isfeatured', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="status-btn {{ $product->is_featured ? 'active-btn' : 'inactive-btn' }}"
                            type="submit" title="click to change">
                            {{ $product->is_featured ? 'Yes' : 'No' }}
                        </button>

                    </form>
                </td>
                <td class="image-cell">
                    <img
                        src="{{ asset('storage/' . $product->image_path) }}"
                        alt="{{  $product->title }}"
                        class="small-image"
                        data-large-image="{{ asset('storage/' . $product->image_path) }}">
                </td>
                <td>
                    <div class="operation-cell">
                        <form action="{{ route('admin.products.edit', $product->id) }}" method="GET">
                            <button type="submit" class="edit-product-button">
                                Edit
                            </button>
                        </form>
                        <form
                            action="{{ route('admin.products.delete', $product->id) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
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
                <td colspan="8" style="text-align: center;">No Products Found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


<div class="operation-container">
    <form
        action="{{ route('admin.products.delete.all') }}"
        method="POST"
        onsubmit="return confirm('Are you absolutely sure you want to delete all products? This action cannot be undone.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-button">
            Delete All Products
        </button>
    </form>
    <form action="{{ route('admin.products.create') }}" method="GET">
        <button type="submit" class="create-product-button">
            Add Product
        </button>
    </form>
</div>

@endsection