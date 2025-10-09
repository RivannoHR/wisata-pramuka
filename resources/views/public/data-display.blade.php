<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Pramuka - Public Data Display</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #2A5934, #4a7c59);
            color: white;
            padding: 40px 0;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 10px;
        }

        .section {
            background: white;
            margin: 30px 0;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .section-header {
            background: #2A5934;
            color: white;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .section-content {
            padding: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background: #fafafa;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            color: #2A5934;
            margin-bottom: 10px;
        }

        .card-description {
            color: #666;
            margin-bottom: 15px;
        }

        .card-price {
            font-size: 20px;
            font-weight: bold;
            color: #e67e22;
        }

        .card-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 12px;
            color: #888;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .active {
            background: #d4edda;
            color: #155724;
        }

        .featured {
            background: #fff3cd;
            color: #856404;
        }

        .export-buttons {
            text-align: center;
            margin: 30px 0;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #2A5934;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 0 10px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #1e3f26;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #2A5934;
        }

        .stat-label {
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🏝️ Wisata Pulau Pramuka</h1>
            <p>Public Data Display - Tourism Information Database</p>
        </div>

        <!-- Statistics Overview -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number">{{ count($data['products']) }}</div>
                <div class="stat-label">Products</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ count($data['accommodations']) }}</div>
                <div class="stat-label">Accommodations</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ count($data['attractions']) }}</div>
                <div class="stat-label">Tourist Attractions</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ count($data['articles']) }}</div>
                <div class="stat-label">Articles</div>
            </div>
        </div>

        <!-- Export Buttons -->
        <div class="export-buttons">
            <a href="{{ route('public.products') }}" class="btn">View Products Only</a>
            <a href="{{ route('public.accommodations') }}" class="btn">View Accommodations Only</a>
            <a href="{{ route('public.attractions') }}" class="btn">View Attractions Only</a>
            <a href="{{ route('public.articles') }}" class="btn">View Articles Only</a>
            <a href="{{ route('public.export.json') }}" class="btn">Export as JSON</a>
        </div>

        <!-- Products Section -->
        @if(count($data['products']) > 0)
        <div class="section">
            <div class="section-header">🛍️ Products</div>
            <div class="section-content">
                <div class="grid">
                    @foreach($data['products'] as $product)
                    <div class="card">
                        <div class="card-title">{{ $product->title }}</div>
                        <div class="card-description">{{ Str::limit($product->description, 100) }}</div>
                        <div class="card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="card-meta">
                            <span>Stock: {{ $product->stock }}</span>
                            <span>
                                @if($product->is_active)
                                    <span class="status-badge active">Active</span>
                                @endif
                                @if($product->is_featured)
                                    <span class="status-badge featured">Featured</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Accommodations Section -->
        @if(count($data['accommodations']) > 0)
        <div class="section">
            <div class="section-header">🏨 Accommodations</div>
            <div class="section-content">
                <div class="grid">
                    @foreach($data['accommodations'] as $accommodation)
                    <div class="card">
                        <div class="card-title">{{ $accommodation->name }}</div>
                        <div class="card-description">{{ Str::limit($accommodation->description, 100) }}</div>
                        <div class="card-price">Rp {{ number_format($accommodation->price ?? 0, 0, ',', '.') }}/night</div>
                        <div class="card-meta">
                            <span>Location: {{ $accommodation->location }}</span>
                            <span>{{ count($accommodation->images) }} images</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Tourist Attractions Section -->
        @if(count($data['attractions']) > 0)
        <div class="section">
            <div class="section-header">🏞️ Tourist Attractions</div>
            <div class="section-content">
                <div class="grid">
                    @foreach($data['attractions'] as $attraction)
                    <div class="card">
                        <div class="card-title">{{ $attraction->name }}</div>
                        <div class="card-description">{{ Str::limit($attraction->description, 100) }}</div>
                        <div class="card-meta">
                            <span>Type: {{ ucfirst(str_replace('_', ' ', $attraction->type)) }}</span>
                            <span>{{ count($attraction->images) }} images</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Articles Section -->
        @if(count($data['articles']) > 0)
        <div class="section">
            <div class="section-header">📝 Articles</div>
            <div class="section-content">
                <div class="grid">
                    @foreach($data['articles'] as $article)
                    <div class="card">
                        <div class="card-title">{{ $article->title }}</div>
                        <div class="card-description">{{ Str::limit($article->content, 150) }}</div>
                        <div class="card-meta">
                            <span>Published: {{ $article->created_at->format('M d, Y') }}</span>
                            <span>{{ count($article->images) }} images</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div style="text-align: center; margin-top: 50px; color: #666;">
            <p>© {{ date('Y') }} Wisata Pulau Pramuka - Public Data Display</p>
            <p>Generated on {{ date('F j, Y \a\t g:i A') }}</p>
        </div>
    </div>
</body>
</html>
