@foreach($accommodations as $accommodation)
<div class="accommodation-card" onclick="window.location.href='{{ route('accommodations.show', $accommodation->id) }}'">
    <div class="accommodation-image" style="background-image: url('{{ $accommodation->main_image }}')">
        @if($accommodation->average_rating_from_reviews)
        <div class="rating-overlay">
            <i class="fas fa-star star"></i>
            {{ number_format($accommodation->average_rating_from_reviews, 1) }}
        </div>
        @else
        <div class="rating-overlay">
            <i class="fas fa-star star"></i>
            N/A
        </div>
        @endif
    </div>

    <div class="accommodation-content">
        <div class="accommodation-header">
            <h3 class="accommodation-name">{{ $accommodation->name }}</h3>
            @if($accommodation->location)
            <div class="accommodation-location">
                <i class="fas fa-map-marker-alt"></i>
                {{ $accommodation->location }}
            </div>
            @endif
            <div class="accommodation-type">{{ $accommodation->formatted_type }}</div>
        </div>

        <p class="accommodation-description">{{ $accommodation->description }}</p>

        @if($accommodation->facilities && count($accommodation->facilities) > 0)
        <div class="accommodation-facilities">
            <div class="facilities-list">
                @foreach(array_slice($accommodation->facilities, 0, 4) as $facility)
                <span class="facility-item">
                    <i class="fas fa-check"></i>
                    {{ ucfirst($facility) }}
                </span>
                @endforeach
                @if(count($accommodation->facilities) > 4)
                <span class="facility-item">
                    +{{ count($accommodation->facilities) - 4 }} more
                </span>
                @endif
            </div>
        </div>
        @endif

        <div class="accommodation-footer">
            <div class="price-section">
                <div class="price-label">Starting from</div>
                <div class="price-value">
                    Rp {{ number_format($accommodation->price, 0, ',', '.') }}
                    <span class="price-unit">/night</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach