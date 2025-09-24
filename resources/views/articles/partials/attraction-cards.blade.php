@foreach($articles as $article)
<div class="attraction-card" onclick="window.location.href='{{ route('articles.show', $article->id) }}'">
    <div class="attraction-image" style="background-image: url('{{ $article->first_image ? asset('storage/' . $article->first_image) : asset('images/default-article.jpg') }}')">
        <div class="attraction-type-badge">
            {{ $article->capital_category }}
        </div>
    </div>
    <div class="attraction-content">
        <h3 class="attraction-name">{{ $article->title }}</h3>
        <div class="attraction-location">
            <i class="fas fa-calendar fa-xl""></i>
            {{ $article->formatted_date }}
        </div>
        <p class=" attraction-description">{{ $article->content }}</p>
        </div>
    </div>
    @endforeach