@extends('admin.dashboard')

@section('content')
<style>
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
        width: 70px;
    }

    .single-button-cell {
        width: 60px;
    }

    .image-cell {
        width: 500px;
    }


    th,
    td {
        padding: 12px 15px;
        text-align: center;
        border-bottom: 1px solid #e0e0e0;
        vertical-align: middle;
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

    td form {
        margin: 0;
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

    .operation-cell {
        display: flex;
        align-items: center;
        justify-content: space-around;
    }

    .small-image {
        object-fit: contain;
        width: 100%;
        height: auto;
        image-rendering: -webkit-optimize-contrast;
    }

    .edit-popup-overlay {
        display: none;
        /* Hidden by default */
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
        border-radius: 4px
    }
</style>
<script>
    function showEditPopup(popupId) {
        document.getElementById(popupId).style.display = 'block';
    }

    function hideEditPopup(popupId) {
        document.getElementById(popupId).style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('edit-popup-overlay')) {
            event.target.style.display = "none";
        }
    }
</script>

<table>
    <thead>
        <tr>
            <th class="id-cell">Id</th>
            <th>Room Name</th>
            <th class="image-cell">Image</th>
            <th>Price</th>
            <th style="width: 120px;">Operation</th>
        </tr>
    </thead>
</table>
<div class="table-container">
    <table>
        <tbody>
            @forelse ($roomTypes as $roomType)
            <tr>
                <td class="id-cell"> {{ $roomType->id }} </td>
                <td>{{ $roomType->name }}</td>
                <td class="image-cell">
                    <img src="{{ asset('storage/' . $roomType->image_path) }}" class="small-image" alt="{{ $roomType->name }}">
                </td>
                <td>Rp. {{ number_format($roomType->price, 0, ',', '.') }}</td>
                <td style="width: 120px;">
                    <div class="operation-cell">
                        <button type="button" class="edit-product-button" onclick="showEditPopup('edit-popup-{{ $roomType->id }}')">Edit</button>
                        <form action="{{ route('admin.accommodations.roomtypes.delete', [$accommodation->id, $roomType->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">
                                Delete
                            </button>
                        </form>
                    </div>
                    <div class="edit-popup-overlay" id="edit-popup-{{ $roomType->id }}">
                        <div class="edit-popup-content">
                            <span class="close-popup" onclick="hideEditPopup('edit-popup-{{ $roomType->id }}')">&times;</span>
                            <h4>Edit Room Type</h4>
                            <form action="{{ route('admin.accommodations.roomtypes.edit', [$accommodation->id, $roomType->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <p>Please enter the new room type details:</p>
                                <label for="name">Room Name:</label>
                                <br>
                                <input type="text" name="name" value="{{ old('name', $roomType->name) }}" required>
                                @error('name')
                                <div style="padding-top: 10px; padding-bottom: 10px;">
                                    <span class="error-message">
                                        <h4>{{ $message }}</h4>
                                    </span>
                                </div>
                                @enderror
                                <br>
                                <label for="price">Room Price:</label>
                                <br>
                                <input type="number" name="price" value="{{ old('price', $roomType->price) }}" required>
                                @error('price')
                                <div style="padding-top: 10px; padding-bottom: 10px;">
                                    <span class="error-message">
                                        <h4>{{ $message }}</h4>
                                    </span>
                                </div>
                                @enderror
                                <br>
                                <label for="image">Choose a new image (optional):</label>
                                <br>
                                <input type="file" name="image">
                                @error('image')
                                <div style="padding-top: 10px; padding-bottom: 10px;">
                                    <span class="error-message">
                                        <h4>{{ $message }}</h4>
                                    </span>
                                </div>
                                @enderror
                                <br>
                                <button type="submit" class="create-product-button">Submit</button>
                            </form>
                        </div>
                    </div>
                    @if ($errors->any())
                    <script>
                        document.addEventListener('DOMContentLoaded', (event) => {
                            const popupId = 'edit-popup-{{ $roomType->id }}';
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
                <td colspan="5">No Room Types Found For {{ $accommodation->name }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


<div class="operation-container">
    <button type="button" class="create-product-button" onclick="showEditPopup('create-popup')">
        Add Room Type
    </button>
    <div class="edit-popup-overlay" id="create-popup">
        <div class="edit-popup-content">
            <span class="close-popup" onclick="hideEditPopup('create-popup')">&times;</span>
            <h4>Add a New Room Type</h4>
            <form action="{{ route('admin.accommodations.roomtypes.create', $accommodation->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <p>Enter the details for the new room type:</p>
                <label for="name">Room Name:</label>
                <br>
                <input type="text" name="name" required>
                @error('name')
                <div style="padding-top: 10px; padding-bottom: 10px;">
                    <span class="error-message">
                        <h4>{{ $message }}</h4>
                    </span>
                </div>
                @enderror
                <br>
                <label for="price">Room Price:</label>
                <br>
                <input type="number" name="price" required>
                @error('price')
                <div style="padding-top: 10px; padding-bottom: 10px;">
                    <span class="error-message">
                        <h4>{{ $message }}</h4>
                    </span>
                </div>
                @enderror
                <br>
                <label for="image">Choose an image:</label>
                <br>
                <input type="file" name="image" required>
                @error('image')
                <div style="padding-top: 10px; padding-bottom: 10px;">
                    <span class="error-message">
                        <h4>{{ $message }}</h4>
                    </span>
                </div>
                @enderror
                <br>
                <button type="submit" class="create-product-button">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection