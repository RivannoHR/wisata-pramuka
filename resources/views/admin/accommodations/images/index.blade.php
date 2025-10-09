@extends('admin.dashboard')

@section('content')
<style>
    .table-container {
        overflow-x: auto;
        margin-bottom: 30px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .id-cell {
        width: 70px;
    }

    .single-button-cell {
        width: 100px;
    }

    .status-btn {
        padding: 5px 10px;
        border: none;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
    }

    .active-btn {
        background: #28a745;
        color: white;
    }

    .inactive-btn {
        background: #6c757d;
        color: white;
    }

    .status-btn:hover {
        opacity: 0.8;
    }

    th,
    td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #e0e0e0;
        vertical-align: middle;
    }

    th {
        background-color: #f8f8f8;
        font-weight: 600;
        color: #555;
    }

    tr:hover {
        background-color: #f2f2f2;
    }

    .page-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
        padding: 20px 0;
        gap: 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    .back-button {
        background: #6c757d;
        color: white;
        text-decoration: none;
        padding: 8px 15px;
        border-radius: 4px;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    .back-button:hover {
        background: #545b62;
        color: white;
        text-decoration: none;
    }

    .page-title {
        margin: 0;
        color: #333;
        font-size: 24px;
    }

    .operation-cell-container {
        width: 150px;
        padding: 10px;
    }

    .operation-cell {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .edit-product-button {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        padding: 5px 8px;
        min-width: 50px;
    }

    .delete-button {
        background: #dc3545;
        color: white;
        border: none;
        padding: 5px 8px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        min-width: 50px;
        transition: background-color 0.3s;
    }

    .delete-button:hover {
        opacity: 60%;
    }

    .operation-container {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px;
        margin-top: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .create-product-button {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
        text-decoration: none;
    }

    .create-product-button:hover {
        background-color: #218838;
        color: white;
        text-decoration: none;
    }

    .small-image {
        aspect-ratio: auto;
        width: 120px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        cursor: pointer;
        image-rendering: -webkit-optimize-contrast;
    }

    .small-image:hover {
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }

    .edit-popup-overlay {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        /* Semi-transparent black background */
    }

    .edit-popup-content {
        background-color: #fefefe;
        margin: 15% auto;
        /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Could be adjusted */
        max-width: 500px;
        border-radius: 8px;
        position: relative;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .close-popup {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-popup:hover,
    .close-popup:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .edit-popup-content h4 {
        margin-top: 0;
    }

    .edit-popup-content input {
        padding: 4px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form-buttons {
        display: flex;
        gap: 10px;
        justify-content: center;
        align-items: center;
        margin-top: 15px;
    }

    .cancel-button {
        background: #6c757d;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
    }

    .cancel-button:hover {
        opacity: 0.8;
    }
</style>

<div class="page-header">
    <a href="{{ route('admin.accommodations') }}" class="back-button">← Back to Accommodations</a>
    <h2 class="page-title">Images for: {{ $accommodation->name }}</h2>
</div>

<script>
    function showEditPopup(popupId) {
        document.getElementById(popupId).style.display = 'block';
    }

    function hideEditPopup(popupId) {
        document.getElementById(popupId).style.display = 'none';
    }

    // Close the popup when the user clicks outside of it
    window.onclick = function(event) {
        if (event.target.classList.contains('edit-popup-overlay')) {
            event.target.style.display = "none";
        }
    }
</script>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th class="id-cell">Sort Order</th>
                <th class="image-cell">Image</th>
                <th class="single-button-cell">Is Featured</th>
                <th style="width: 150px;">Operations</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($images as $image)
            <tr>
                <td class="id-cell"> {{ $image->sort_order }} </td>
                <td class="image-cell">
                    <img
                        src="{{ asset('storage/' . $image->image_path) }}"
                        class="small-image"
                        data-large-image="{{ asset('storage/' . $image->image_path) }}">
                </td>
                <td class="single-button-cell">
                    <form action="{{ route('admin.accommodations.images.toggle.isfeatured', [$accommodation->id, $image->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="status-btn {{ $image->is_featured ? 'active-btn' : 'inactive-btn' }}"
                            type="submit" title="click to change">
                            {{ $image->is_featured ? 'Yes' : 'No' }}
                        </button>
                    </form>
                </td>
                <td class="operation-cell-container">
                    <div class="operation-cell">
                        <button type="button" class="edit-product-button" onclick="showEditPopup('edit-popup-{{ $image->id }}')">
                            Edit
                        </button>
                        @if ($images->count() > 1)
                        <form action="{{ route('admin.accommodations.images.delete', [$accommodation->id ,$image->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">
                                Delete
                            </button>
                        </form>
                        @endif
                    </div>

                    <div class="edit-popup-overlay" id="edit-popup-{{ $image->id }}">
                        <div class="edit-popup-content">
                            <span class="close-popup" onclick="hideEditPopup('edit-popup-{{ $image->id }}')">&times;</span>
                            <h4>Edit Image</h4>
                            <form action="{{ route('admin.accommodations.images.edit', [$accommodation->id, $image->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <p>Please select a new image:</p>
                                <input type="file" name="product_image" required>
                                <br>
                                @error('product_image')
                                <div style="padding-top: 10px; padding: bottom 10px;">
                                    <span class="error-message">
                                        <h4>{{ $message }}</h4>
                                    </span>
                                </div>
                                @enderror
                                <br>
                                <label for="alt_text">Enter placeholder text:</label>
                                <br>
                                <input type="text" name="alt_text" id="alt_text" required>
                                <br>
                                @error('alt_text')
                                <div style="padding-top: 10px; padding: bottom 10px;">
                                    <span class="error-message">
                                        <h4>{{ $message }}</h4>
                                    </span>
                                </div>
                                @enderror
                                <br>
                                <div class="form-buttons">
                                    <button type="submit" class="create-product-button">Submit</button>
                                    <button type="button" class="cancel-button" onclick="hideEditPopup('edit-popup-{{ $image->id }}')">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if ($errors->any() && $errors->has('product_image'))
                    <script>
                        document.addEventListener('DOMContentLoaded', (event) => {
                            // Check if this specific popup ID matches the one for which the error occurred
                            // This is a simple check, more complex forms might need more specific logic
                            const popupId = 'edit-popup-{{ $image->id }}';
                            if (document.getElementById(popupId)) {
                                showEditPopup(popupId);
                            }
                        });
                    </script>
                    @endif

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">No Images Found For {{ $accommodation->name }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


<div class="operation-container">
    <button type="button" class="create-product-button" onclick="showEditPopup('edit-popup-create')">
        Add Image
    </button>
    <div class="edit-popup-overlay" id="edit-popup-create">
        <div class="edit-popup-content">
            <span class="close-popup" onclick="hideEditPopup('edit-popup-create')">&times;</span>
            <h4>Add New Image</h4>
            <form action="{{ route('admin.accommodations.images.create', $accommodation->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <p>Please select select new image:</p>
                <input type="file" name="product_image" required>
                @error('product_image')
                <div style="padding-top: 10px; padding: bottom 10px;">
                    <span class="error-message">
                        <h4>{{ $message }}</h4>
                    </span>
                </div>
                @enderror
                <br>
                <br>
                <label for="alt_text">Enter placeholder text:</label>
                <br>
                <input type="text" name="alt_text" required>
                @error('alt_text')
                <div style="padding-top: 10px; padding: bottom 10px;">
                    <span class="error-message">
                        <h4>{{ $message }}</h4>
                    </span>
                </div>
                @enderror
                <br>
                <br>
                <button type="submit" class="create-product-button">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection