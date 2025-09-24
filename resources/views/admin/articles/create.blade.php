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
@section('content')

@if (isset($article))
<form method="POST" action="{{ route('admin.articles.apply', $article) }}" class="create-product-form" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="title">Enter Article Title:</label>
        <input type="text" name="title" id="title" value="{{ $article->title }}">
        @error('title')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Enter Article content:</label>
        <textarea name="content" id="description" rows="4">{{ $article->content }}</textarea>
        @error('content')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="description">Enter Article Category:</label>
        <textarea name="category" id="description" rows="4">{{ $article->category }}</textarea>
        @error('category')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit" class="submit-button">Apply Changes</button>
</form>
<div style="padding:20px; max-width:100%; display:flex; flex-direction:column; gap:20px">

    <form action="{{ route('admin.articles.images', $article->id) }}" method="GET" style="margin: 0;">
        <button type="submit" class="submit-button">
            Edit Images
        </button>
    </form>
</div>
@else
<form method="POST" action="{{ route('admin.articles.store') }}" class="create-product-form" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="title">Enter Article Title:</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}">
        @error('title')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Enter Article Content:</label>
        <textarea name="content" id="description" rows="4">{{ old('content') }}</textarea>
        @error('content')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="description">Enter Article Category:</label>
        <textarea name="category" id="description" rows="4">{{ old('category') }}</textarea>
        @error('category')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="image">Enter Article Image:</label>
        <input type="file" id="image" name="article_image">
        @error('article_image')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="submit-button">Post Article</button>
</form>
@endif

@endsection