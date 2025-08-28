@extends('admin.dashboard')
<style>
    .create-product-form {
        max-width: 100%;
        height: 100%;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px 8px 0 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: scroll;
        gap: 10px;
    }


    .create-product-form label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    .create-product-form input,
    .create-product-form textarea,
    .create-product-form select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;

    }

    .create-product-form textarea {
        resize: vertical;
    }

    .create-product-form input:focus,
    .create-product-form textarea:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .error-message {
        color: #e3342f;
        font-size: 0.875em;
        margin-top: 0.25rem;
        display: block;
    }

    .button {
        padding: 0.5rem 1rem;
        font-weight: 600;
        color: #ffffff;
        border-radius: 0.375rem;
        transition-property: background-color;
        transition-duration: 200ms;
        border: none;
    }

    .add-button {
        background-color: #007bff;
    }

    .add-button:hover {
        background-color: #0056b3;
    }

    .delete-button {
        background-color: #ef4444;
    }

    .delete-button:hover {
        background-color: #dc2626;
    }

    .facilities-input-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .submit-button {
        display: block;
        width: 100%;
        padding: 0.75rem;
        font-size: 1rem;
        font-weight: bold;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    .submit-button:hover {
        background-color: #0056b3;
    }

    .facilities-display-container {
        border: 1px solid #d1d5db;
        padding: 1rem;
        border-radius: 0.375rem;
        background-color: #f9fafb;
        min-height: 3rem;
        margin-bottom: 0.5rem
    }

    .tag-badge {
        display: inline-flex;
        align-items: center;
        background-color: #e5e7eb;
        color: #374151;
        font-size: 0.875rem;
        font-weight: 500;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .delete-tag-icon {
        margin-left: 0.25rem;
        cursor: pointer;
        color: #6b7280;
    }

    .delete-tag-icon:hover {
        color: #111827;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const addFacilityButton = document.getElementById('add-facility');
        const newFacilityInput = document.getElementById('new-facility');
        const facilitiesDisplay = document.getElementById('facilities-display');
        const deleteAllButton = document.getElementById('delete-all-facilities');
        const facilitiesHiddenInput = document.getElementById('facilities-input');

        let facilities = [];
        const initialFacilitiesString = facilitiesHiddenInput.value;
        if (initialFacilitiesString) {
            facilities = initialFacilitiesString.split(',').map(item => item.trim()).filter(item => item !== "");
            renderFacilities();
        }

        function renderFacilities() {
            facilitiesDisplay.innerHTML = '';
            facilities.forEach(facility => {
                if (facility) {
                    const facilityBadge = document.createElement('span');
                    facilityBadge.className = 'tag-badge';
                    facilityBadge.textContent = facility;

                    const deleteIcon = document.createElement('span');
                    deleteIcon.className = 'delete-tag-icon';
                    deleteIcon.innerHTML = '&times;';
                    deleteIcon.onclick = () => {
                        facilities = facilities.filter(item => item !== facility);
                        renderFacilities();
                        updateHiddenInput();
                    };
                    facilityBadge.appendChild(deleteIcon);
                    facilitiesDisplay.appendChild(facilityBadge);
                }
            });
        }

        function updateHiddenInput() {
            facilitiesHiddenInput.value = facilities.join(',');
        }

        addFacilityButton.addEventListener('click', () => {
            const newFacility = newFacilityInput.value.trim();
            if (newFacility) {
                const newFacilities = newFacility.split(',').map(item => item.trim()).filter(item => item !== "");
                newFacilities.forEach(f => {
                    if (f && !facilities.includes(f)) {
                        facilities.push(f);
                    }
                });
                newFacilityInput.value = '';
                renderFacilities();
                updateHiddenInput();
            }
        });

        deleteAllButton.addEventListener('click', () => {
            facilities = [];
            renderFacilities();
            updateHiddenInput();
        });

        newFacilityInput.addEventListener('keypress', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                addFacilityButton.click();
            }
        });

        renderFacilities();
    });
</script>
@section('content')

@if (isset($accommodation))
<form method="POST" action="{{ route('admin.accommodations.apply', $accommodation) }}" class="create-product-form" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="name">Enter Accommodation Name:</label>
        <input type="text" name="name" id="name" value="{{ $accommodation->name }}">
        @error('name')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Enter Accommodation Description:</label>
        <textarea name="description" id="description" rows="4">{{ $accommodation->description }}</textarea>
        @error('description')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="type">Accommodation Type:</label>
        <select id="type" name="type">
            @foreach($typesfilter as $type)
            <option value="{{ $type }}" {{ old('type', $accommodation->type) == $type ? 'selected' : '' }}>
                {{ ucfirst($type) }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="location">Enter Accommodation Location:</label>
        <textarea name="location" id="location" rows="4">{{ $accommodation->location }}</textarea>
        @error('location')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="rating">Enter Accommodation Rating:</label>
        <input type="number" name="rating" id="rating" value="{{ $accommodation->rating }}" min="0" max="5" step="0.1">
        @error('rating')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="capacity">Enter Accommodation Capacity:</label>
        <input type="number" name="capacity" id="capacity" value="{{ $accommodation->capacity }}">
        @error('capacity')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="new-facility" class="label">Add Facilities:</label>
        <div class="facilities-input-group">
            <input type="text" id="new-facility" class="input-field" placeholder="e.g., Swimming Pool, WiFi">
            <button type="button" id="add-facility" class="button add-button">Add</button>
        </div>
    </div>

    <div class="form-group">
        <label for="facilities-display" class="label">Facilities:</label>
        <div id="facilities-display" class="facilities-display-container">
        </div>
        <button type="button" id="delete-all-facilities" class="button delete-button mt-2">Delete All</button>
    </div>

    <input type="hidden" name="facilities" id="facilities-input" value="{{ implode(', ', $accommodation->facilities ?? []) }}">
    <button type="submit" class="submit-button">Apply Change</button>
</form>
<div style="padding:20px; max-width:100%; display:flex; flex-direction:column; gap:20px">

    <form action="{{ route('admin.accommodations.images', $accommodation->id) }}" method="GET" style="margin: 0;">
        <button type="submit" class="submit-button">
            Edit Images
        </button>
    </form>
    <form action="{{ route('admin.accommodations.rooms', $accommodation->id) }}" method="GET" style="margin: 0;">
        <button type="submit" class="submit-button">
            Edit Rooms
        </button>
    </form>
</div>
@else
<form method="POST" action="{{ route('admin.products.store') }}" class="create-product-form" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="title">Enter Product Name:</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}">
        @error('title')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Enter Product Description:</label>
        <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>
        @error('description')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="price">Enter Product Price:</label>
        <input type="number" name="price" id="price" value="{{ old('price') }}">
        @error('price')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="stock">Enter Product Stock:</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock') }}">
        @error('stock')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="image">Enter Product Image:</label>
        <input type="file" id="image" name="product_image">
        @error('product_image')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="submit-button">Create Product</button>
</form>
@endif

@endsection