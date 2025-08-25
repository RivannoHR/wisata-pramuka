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

    .table-container {
        /* This is the key for overflow scrolling */
        overflow: auto;
        /* Allows both X and Y overflow */
        margin-top: 20px;
        background: white;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        /* Ensure the table fills its container */
        border-collapse: collapse;
        table-layout: fixed;
        /* This is crucial for handling overflow */
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
        word-wrap: break-word;
        /* Allows long words to break and wrap to the next line */
    }

    .description-cell {
        min-height: 50px;
        /* Optional: Sets a minimum height for all description cells */
    }

    .status-btn {
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        color: white;
        cursor: pointer;
        font-weight: bold;
        position: relative;
        overflow: hidden;
        transition: background-color 0.3s ease;
        min-width: 60px;
    }

    .active-btn {
        background-color: #4CAF50;
        /* Green */
    }

    .inactive-btn {
        background-color: #f44336;
        /* Red */
    }

    .status-btn::before {
        content: "change?";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.4);
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .status-btn:hover::before {
        opacity: 1;
    }
</style>
<script>
    document.querySelectorAll('.status-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const field = this.dataset.field;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/admin/products/toggle-status/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        field: field
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the button's text and color based on the new status
                        this.textContent = data.newStatus;
                        this.classList.toggle('active-btn', data.is_shown);
                        this.classList.toggle('inactive-btn', !data.is_shown);
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    });
</script>
<div class="filter-container">
    <form method="GET" action="{{ route('products.index') }}" class="filter-form" id="filterForm">
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
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Is Shown</th>
                <th>Is Featured</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->title }}</td>
                <td>
                    <div style="max-height: 100px; overflow-y: auto;">
                        {{ $product->description }}
                    </div>
                </td>
                <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <button class="status-btn {{ $product->is_shown ? 'active-btn' : 'inactive-btn' }}"
                        data-product-id="{{ $product->id }}"
                        data-field="is_shown">
                        {{ $product->is_shown ? 'Yes' : 'No' }}
                    </button>
                </td>
                <td>
                    <button class="status-btn {{ $product->is_featured ? 'active-btn' : 'inactive-btn' }}"
                        data-product-id="{{ $product->id }}"
                        data-field="is_featured">
                        {{ $product->is_featured ? 'Yes' : 'No' }}
                    </button>
                </td>
                <td>
                    <a href="edit/{{ $product->id }}">Edit</a>
                    <a href="delete/{{ $product-> id }}" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="operation-container">
    <form
        action="{{ route('admin.products.delete_all') }}"
        method="POST"
        onsubmit="return confirm('Are you absolutely sure you want to delete all products? This action cannot be undone.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Delete All Products
        </button>
    </form>
    <a href="{{ route('admin.product.create') }}" class="add-product button">Add product</a>
</div>

@endsection