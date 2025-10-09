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

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-size: 1rem;
        font-weight: bold;
        display: inline-block;
        text-align: center;
        transition: background-color 0.2s ease-in-out;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0056b3;
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
    }
</style>

@section('content')
<div class="create-product-form">
    <h2><i class="fas fa-edit"></i> Edit Accommodation</h2>

    <form action="{{ route('admin.accommodations.apply', $accommodation->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="name">Accommodation Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $accommodation->name) }}" required>
            @error('name')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="type">Type</label>
            <select id="type" name="type" required>
                <option value="hotel" {{ old('type', $accommodation->type) == 'hotel' ? 'selected' : '' }}>Hotel</option>
                <option value="lodge" {{ old('type', $accommodation->type) == 'lodge' ? 'selected' : '' }}>Lodge</option>
                <option value="guesthouse" {{ old('type', $accommodation->type) == 'guesthouse' ? 'selected' : '' }}>Guesthouse</option>
                <option value="camping" {{ old('type', $accommodation->type) == 'camping' ? 'selected' : '' }}>Camping</option>
            </select>
            @error('type')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" required>{{ old('description', $accommodation->description) }}</textarea>
            @error('description')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="{{ old('location', $accommodation->location) }}" required>
            @error('location')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="price">Price per Night (IDR)</label>
            <input type="number" id="price" name="price" value="{{ old('price', $accommodation->price) }}" min="0" required>
            @error('price')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="capacity">Guest Capacity</label>
            <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $accommodation->capacity) }}" min="1" required>
            @error('capacity')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="contact_phone">Contact Phone</label>
            <input type="tel" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $accommodation->contact_phone) }}">
            @error('contact_phone')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="contact_email">Contact Email</label>
            <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $accommodation->contact_email) }}">
            @error('contact_email')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="facilities">Facilities</label>
            <div class="facilities-input-group">
                <input type="text" id="new-facility" name="new-facility" placeholder="Enter facility name">
                <button type="button" id="add-facility" class="button add-button">Add</button>
                <button type="button" id="delete-all-facilities" class="button delete-button">Delete All</button>
            </div>
            <div class="facilities-display-container" id="facilities-display"></div>
            <input type="hidden" id="facilities-input" name="facilities" value="{{ old('facilities', $accommodation->facilities) }}">
            @error('facilities')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="is_available">Availability Status</label>
            <select id="is_available" name="is_available" required>
                <option value="1" {{ old('is_available', $accommodation->is_available) == '1' ? 'selected' : '' }}>Available</option>
                <option value="0" {{ old('is_available', $accommodation->is_available) == '0' ? 'selected' : '' }}>Not Available</option>
            </select>
            @error('is_available')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.accommodations') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Accommodation</button>
        </div>
    </form>
</div>

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
                    facilityBadge.innerHTML = `${facility} <span class="delete-tag-icon" onclick="removeFacility('${facility}')">&times;</span>`;
                    facilitiesDisplay.appendChild(facilityBadge);
                }
            });
            facilitiesHiddenInput.value = facilities.join(', ');
        }

        addFacilityButton.addEventListener('click', () => {
            const facilityName = newFacilityInput.value.trim();
            if (facilityName && !facilities.includes(facilityName)) {
                facilities.push(facilityName);
                newFacilityInput.value = '';
                renderFacilities();
            }
        });

        deleteAllButton.addEventListener('click', () => {
            facilities = [];
            renderFacilities();
        });

        newFacilityInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                addFacilityButton.click();
            }
        });

        window.removeFacility = (facilityName) => {
            facilities = facilities.filter(f => f !== facilityName);
            renderFacilities();
        };
    });
</script>

@endsection
