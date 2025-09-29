@extends('admin.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-tables.css') }}">
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

    .edit-link {
        text-decoration: none;
        background: #200fdb;
        color: white;
        border: none;
        padding: 6px 10px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 0.75rem;
        font-family: Arial, sans-serif;
        display: inline-block;
        margin-top: 5px;
    }

    .edit-link:hover {
        opacity: 60%;
        color: white;
        text-decoration: none;
    }

    .view-link {
        text-decoration: none;
        background: #28a745;
        color: white;
        border: none;
        padding: 6px 10px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 0.75rem;
        font-family: Arial, sans-serif;
        display: inline-block;
        margin-top: 5px;
        margin-left: 8px;
    }

    .view-link:hover {
        opacity: 60%;
        color: white;
        text-decoration: none;
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
    <form method="GET" action="{{ route('admin.articles') }}" class="filter-form" id="filterForm">
        <input type="hidden" name="filter_yes" value="1">
        <div class="filter-group">
            <input type="text" name="search" placeholder="Search articles, categories.." value="{{ request('search') }}" class="search-input">
        </div>

        <div class="filter-group">
            <select name="order" class="filter-select">
                <option value="">Sort by</option>
                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Date (Ascending)</option>
                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Date (Descending)</option>
            </select>
        </div>
        <button type="submit" class="filter-button">Filter</button>
    </form>
</div>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th class="id-cell">Id</th>
                <th class="name-cell">Title</th>
                <th class="description-cell">Content</th>
                <th class="category-cell">Category</th>
                <th class="date-cell">Creation Date</th>
                <th class="count-cell">Image</th>
                <th class="actions-cell">Operations</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($articles as $article)
            <tr>
                <td class="id-cell">{{ $article->id }}</td>
                <td class="name-cell">{{ $article->title }}</td>
                <td class="description-cell">
                    <div style="max-height: 100px; overflow-y: auto;">
                        {{ $article->content }}
                    </div>
                </td>
                <td class="category-cell">{{ $article->category }}</td>
                <td class="date-cell">{{ $article->formatted_date }}</td>
                <td class="count-cell">
                    @if($article->first_image)
                        <img
                            src="{{ asset('storage/' . $article->first_image) }}"
                            alt="{{ $article->title }}"
                            class="small-image"
                            data-large-image="{{ asset('storage/' . $article->first_image) }}"
                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                    @else
                        <div style="width: 50px; height: 50px; background-color: #f3f4f6; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 12px;">
                            No Image
                        </div>
                    @endif
                </td>
                <td class="actions-cell">
                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="edit-link">Edit</a>
                    <a href="{{ route('admin.articles.images', $article->id) }}" class="view-link">Images</a>
                    <a href="{{ route('admin.articles.comments', $article->id) }}" class="edit-link" style="margin-left: 8px;">Comments</a>
                    <form action="{{ route('admin.articles.delete', $article->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this article? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-button" style="font-size: 0.8rem; padding: 4px 8px;">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">No Articles Found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


<div class="operation-container">
    <form
        action="{{ route('admin.articles.delete.all') }}"
        method="POST"
        onsubmit="return confirm('Are you absolutely sure you want to delete all articles? This action cannot be undone.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-button">
            Delete All Articles
        </button>
    </form>
    <form action="{{ route('admin.articles.create') }}" method="GET">
        <button type="submit" class="create-product-button">
            Add Article
        </button>
    </form>
</div>

@endsection