@foreach($attractions as $attraction)
    <div class="attraction-card" onclick="window.location.href='{{ route('tourist-attractions.show', $attraction->id) }}'">
        <div class="attraction-image" style="background-image: url('{{ $attraction->main_image }}')">
            <div class="attraction-type-badge {{ $attraction->type }}">
                {{ $attraction->formatted_type }}
            </div>
            @if($attraction->rating)
                <div class="attraction-rating">
                    <i class="fas fa-star"></i>
                    {{ number_format($attraction->rating, 1) }}
                </div>
            @endif
        </div>
        <div class="attraction-content">
            <h3 class="attraction-name">{{ $attraction->name }}</h3>
            @if($attraction->location)
                <div class="attraction-location">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $attraction->location }}
                </div>
            @endif
            <p class="attraction-description">{{ $attraction->description }}</p>
        </div>
    </div>
@endforeach
