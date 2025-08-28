@extends('admin.dashboard')
<style>
    .create-product-form {
        max-width: 100%;
        height: 100%;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: scroll;
    }

    .form-group {}

    .create-product-form label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    .create-product-form input,
    .create-product-form textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        /* Ensures padding doesn't affect the width */
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

    .form-flex {
        display: flex;
        justify-content: space-around;
    }

    .image-container {
        position: relative;
    }

    .small-image {
        width: 100px;
        height: 100px;
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
@section('content')

@if (isset($product))
<form method="POST" action="{{ route('admin.products.apply', $product) }}" class="create-product-form" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="title">Enter Product Name:</label>
        <input type="text" name="title" id="title" value="{{ $product->title }}">
        @error('title')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Enter Product Description:</label>
        <textarea name="description" id="description" rows="4">{{ $product->description }}</textarea>
        @error('description')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="price">Enter Product Price:</label>
        <input type="number" name="price" id="price" value="{{ $product->price }}">
        @error('price')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="stock">Enter Product Stock:</label>
        <input type="number" name="stock" id="stock" value="{{ $product->stock }}">
        @error('stock')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-flex">
        <div class="form-group">
            <label for="image">Enter Product Image:</label>
            <input type="file" id="image" name="product_image">
            @error('product_image')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="image-container">
            <img
                src="{{ asset('storage/' . $product->image_path) }}"
                alt="{{  $product->title }}"
                class="small-image"
                data-large-image="{{ asset('storage/' . $product->image_path) }}">
        </div>
    </div>


    <button type="submit" class="submit-button">Apply Change</button>
</form>
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