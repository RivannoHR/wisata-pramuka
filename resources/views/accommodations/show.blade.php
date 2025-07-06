@extends('app')

@section('title', $accommodation->name . ' - Pulau Pramuka')

@section('content')

@section('content')
<style>
    .accommodation-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        background: white;
    }

    .accommodation-header {
        margin-bottom: 40px;
    }

    .accommodation-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 20px;
    }

    .content-layout {
        display: block;
        margin-bottom: 60px;
        width: 100%;
    }

    .main-content {
        display: flex;
        flex-direction: column;
        gap: 40px;
        width: 100%;
        margin-bottom: 40px;
    }

    .image-gallery {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 15px;
        height: 400px;
    }

    .main-image {
        background: #e5e7eb;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        font-size: 1.2rem;
        font-weight: 600;
        background-size: cover;
        background-position: center;
    }

    .thumbnail-gallery {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .thumbnail {
        background: #e5e7eb;
        border-radius: 8px;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        background-size: cover;
        background-position: center;
    }

    .thumbnail:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .facilities-section {
        margin-bottom: 60px;
        width: 100%;
    }

    .facilities-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 20px;
    }

    .facility-item {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #374151;
        font-size: 1rem;
    }

    .facility-item::before {
        content: "•";
        color: #1a1a1a;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .reservation-form {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 30px;
        margin: 60px auto 40px auto;
        max-width: 1152px;
        width: fit-content;
        clear: both;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-weight: 600;
        color: #374151;
        font-size: 0.9rem;
    }

    .form-control {
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        background: white;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
    }

    .select-wrapper {
        position: relative;
    }

    .select-wrapper select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px;
        padding-right: 40px;
    }

    .reservation-button {
        width: 100%;
        background: #1a1a1a;
        color: white;
        border: none;
        padding: 16px 24px;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
    }

    .reservation-button:hover {
        background: #374151;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
        .content-layout {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        .image-gallery {
            grid-template-columns: 1fr;
            height: auto;
            gap: 10px;
        }
        
        .main-image {
            height: 250px;
        }
        
        .thumbnail-gallery {
            flex-direction: row;
            overflow-x: auto;
        }
        
        .thumbnail {
            min-width: 80px;
            height: 60px;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        
        .accommodation-title {
            font-size: 2rem;
        }
    }
</style>

<div class="accommodation-container">
    <div class="accommodation-header">
        <h1 class="accommodation-title">{{ $accommodation->name }}</h1>
    </div>

    <div class="content-layout">
        <div class="main-content">
            <!-- Image Gallery -->
            <div class="image-gallery">
                <div class="main-image" id="mainImage" style="background-image: url('{{ $accommodation->main_image }}')">
                    Room 1
                </div>
                <div class="thumbnail-gallery">
                    <div class="thumbnail active" data-room="1" style="background-image: url('{{ $accommodation->main_image }}')">Room 1</div>
                    <div class="thumbnail" data-room="2" style="background-image: url('{{ $accommodation->main_image }}')">Room 2</div>
                    <div class="thumbnail" data-room="3" style="background-image: url('{{ $accommodation->main_image }}')">Room 3</div>
                    <div class="thumbnail" data-room="4" style="background-image: url('{{ $accommodation->main_image }}')">Room 4</div>
                </div>
            </div>

            <!-- Facilities List -->
            <div class="facilities-section">
                <div class="facilities-list">
                    @if($accommodation->facilities && count($accommodation->facilities) > 0)
                        @foreach($accommodation->facilities as $facility)
                            <div class="facility-item">{{ ucfirst($facility) }}</div>
                        @endforeach
                    @else
                        <div class="facility-item">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
                        <div class="facility-item">Ut quis lobortis dui, ac mollis eros.</div>
                        <div class="facility-item">Nunc consectetur vulputate rutrum.</div>
                        <div class="facility-item">Proin urna arcu, dictum non diam ut, porttitor rutrum sapien.</div>
                        <div class="facility-item">Donec ac commodo metus.</div>
                        <div class="facility-item">Nulla sed justo at ante semper rutrum.</div>
                        <div class="facility-item">Aliquam a pellentesque diam.</div>
                        <div class="facility-item">Nulla non ante gravida ligula dignissim rhoncus et eu metus.</div>
                        <div class="facility-item">Quisque volutpat vitae nunc eleifend aliquam</div>
                        <div class="facility-item">Donec sed eros vestibulum, dignissim libero nec, rhoncus sapien</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Reservation Form -->
    <div class="reservation-form">
        <form id="reservationForm" method="POST" action="{{ route('bookings.store') }}">
            @csrf
            <input type="hidden" name="accommodation_id" value="{{ $accommodation->id }}">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="roomType">Room Type</label>
                    <div class="select-wrapper">
                        <select id="roomType" name="room_type" class="form-control" required>
                            <option value="jasmin-extra">Jasmin Extra</option>
                            <option value="deluxe">Deluxe Room</option>
                            <option value="standard">Standard Room</option>
                            <option value="suite">Suite Room</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dateOption">Booking Date</label>
                    <input type="date" id="dateOption" name="booking_date" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="reservation-button">Make Reservation</button>
        </form>
    </div>
</div>

<script>
    // Room thumbnail functionality
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.addEventListener('click', function() {
            const roomNumber = this.dataset.room;
            
            // Remove active class from all thumbnails
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked thumbnail
            this.classList.add('active');
            
            // Update main image
            const mainImage = document.getElementById('mainImage');
            mainImage.textContent = `Room ${roomNumber}`;
            
            // Keep the same accommodation image for all rooms
            mainImage.style.backgroundImage = `url('{{ $accommodation->main_image }}')`;
        });
    });

    // Form submission
    document.getElementById('reservationForm').addEventListener('submit', function(e) {
        const bookingDate = document.getElementById('dateOption').value;
        const roomType = document.getElementById('roomType').value;
        
        if (!bookingDate) {
            e.preventDefault();
            alert('Please select a booking date');
            return;
        }
        
        if (!roomType) {
            e.preventDefault();
            alert('Please select a room type');
            return;
        }
        
        // Form will submit naturally to the backend
    });

    // Set default date to today
    document.getElementById('dateOption').valueAsDate = new Date();
</script>
@endsection
