@extends('app') {{-- This tells Laravel to use app.blade.php as the layout --}}

@section('title', 'Welcome Home') {{-- Sets the title for this specific page --}}

@section('content') {{-- Defines the content for the 'content' section in app.blade.php --}}
    <div style="text-align: center; padding: 50px;">
        <h2>Explore the Beauty of Pulau Pramuka!</h2>
        <p>Your gateway to unforgettable island experiences.</p>
        <p>Discover stunning attractions, comfortable accommodations, and easy reservations.</p>
    </div>
@endsection