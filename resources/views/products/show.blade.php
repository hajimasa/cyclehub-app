<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - CycleHub</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            line-height: 1.6;
        }
        
        .header {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
            text-decoration: none;
        }
        
        .nav {
            display: flex;
            gap: 2rem;
        }
        
        .nav a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }
        
        .nav a:hover {
            color: #528B5F;
        }
        
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .breadcrumb {
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .breadcrumb a {
            color: #528B5F;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .product-header {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .product-info {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
            align-items: start;
        }
        
        .product-image {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, #528B5F 0%, #6B8E23 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4rem;
        }
        
        .product-details {
            flex: 1;
        }
        
        .product-category {
            background: #f8f9fa;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            border-left: 4px solid #528B5F;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: #666;
            display: inline-block;
        }
        
        .product-name {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 1.5rem;
        }
        
        .product-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #528B5F;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #666;
        }
        
        .rating-overview {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .rating-summary {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .average-rating {
            text-align: center;
        }
        
        .rating-number {
            font-size: 3rem;
            font-weight: bold;
            color: #333;
        }
        
        .rating-stars {
            display: flex;
            gap: 0.2rem;
            justify-content: center;
            margin: 0.5rem 0;
        }
        
        .star {
            color: #ffc107;
            font-size: 1.5rem;
        }
        
        .star.empty {
            color: #ddd;
        }
        
        .rating-count {
            color: #666;
            font-size: 0.9rem;
        }
        
        .rating-distribution {
            flex: 1;
        }
        
        .rating-bar {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .rating-label {
            font-size: 0.9rem;
            color: #666;
            width: 30px;
        }
        
        .rating-progress {
            flex: 1;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .rating-fill {
            height: 100%;
            background: #ffc107;
            transition: width 0.3s;
        }
        
        .rating-value {
            font-size: 0.9rem;
            color: #666;
            width: 30px;
            text-align: right;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #528B5F;
            color: white;
        }
        
        .btn-primary:hover {
            background: #4A6741;
            transform: translateY(-1px);
        }
        
        .reviews-grid {
            display: grid;
            gap: 1.5rem;
        }
        
        .review-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }
        
        .review-author {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .author-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .author-info h4 {
            color: #333;
            margin-bottom: 0.25rem;
        }
        
        .review-date {
            font-size: 0.8rem;
            color: #666;
        }
        
        .review-rating {
            display: flex;
            gap: 0.2rem;
        }
        
        .review-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.75rem;
        }
        
        .review-content {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .review-images {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        
        .review-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .review-image:hover {
            transform: scale(1.05);
        }
        
        .review-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
            padding-top: 1rem;
        }
        
        .like-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .like-button:hover {
            background: #f8f9fa;
            color: #528B5F;
        }
        
        .like-button.liked {
            color: #e74c3c;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
            gap: 0.5rem;
        }
        
        .pagination nav {
            display: flex;
            justify-content: center;
            width: 100%;
        }
        
        .pagination nav div {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .pagination a,
        .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            min-width: 40px;
            height: 40px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        
        .pagination a:hover {
            background: #f8f9fa;
            border-color: #528B5F;
            color: #528B5F;
        }
        
        .pagination span[aria-current="page"] {
            background: #528B5F;
            color: white;
            border-color: #528B5F;
        }
        
        .no-reviews {
            text-align: center;
            padding: 3rem;
            color: #666;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .no-reviews-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        @media (max-width: 768px) {
            .product-info {
                grid-template-columns: 1fr;
            }
            
            .product-stats {
                grid-template-columns: 1fr;
            }
            
            .rating-summary {
                flex-direction: column;
                text-align: center;
            }
            
            .section-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ route('dashboard') }}" class="logo">🚴 CycleHub</a>
        <nav class="nav">
            <a href="{{ route('reviews.index') }}">レビュー一覧</a>
            <a href="{{ route('products.index') }}">商品一覧</a>
            @auth
                <a href="{{ route('reviews.create') }}">レビュー投稿</a>
                <a href="{{ route('dashboard') }}">ダッシュボード</a>
            @else
                <a href="{{ route('google.redirect') }}">ログイン</a>
            @endauth
        </nav>
    </header>
    
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('products.index') }}">商品一覧</a> > 
            <a href="{{ route('products.index', ['category' => $product->partCategory->id]) }}">
                {{ $product->partCategory->bikeCategory->name }} > {{ $product->partCategory->name }}
            </a> > 
            {{ $product->name }}
        </div>
        
        <div class="product-header">
            <div class="product-info">
                <div class="product-image">
                    🚴‍♂️
                </div>
                
                <div class="product-details">
                    <div class="product-category">
                        {{ $product->partCategory->bikeCategory->name }} > {{ $product->partCategory->name }}
                    </div>
                    
                    <h1 class="product-name">{{ $product->name }}</h1>
                    
                    <div class="product-stats">
                        <div class="stat-card">
                            <div class="stat-value">{{ number_format($averageRating, 1) }}</div>
                            <div class="stat-label">平均評価</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">{{ $reviewsCount }}</div>
                            <div class="stat-label">レビュー数</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">{{ $product->created_at->format('Y年m月') }}</div>
                            <div class="stat-label">登録日</div>
                        </div>
                    </div>
                    
                    @auth
                        <a href="{{ route('reviews.create', ['product' => $product->id]) }}" class="btn btn-primary">
                            このパーツのレビューを書く
                        </a>
                    @else
                        <a href="{{ route('google.redirect') }}" class="btn btn-primary">
                            ログインしてレビューを投稿
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        
        @if($reviewsCount > 0)
            <div class="rating-overview">
                <div class="rating-summary">
                    <div class="average-rating">
                        <div class="rating-number">{{ number_format($averageRating, 1) }}</div>
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= round($averageRating) ? '' : 'empty' }}">★</span>
                            @endfor
                        </div>
                        <div class="rating-count">{{ $reviewsCount }}件のレビュー</div>
                    </div>
                    
                    <div class="rating-distribution">
                        @foreach($ratingDistribution as $rating => $data)
                            <div class="rating-bar">
                                <div class="rating-label">{{ $rating }}★</div>
                                <div class="rating-progress">
                                    <div class="rating-fill" style="width: {{ $data['percentage'] }}%"></div>
                                </div>
                                <div class="rating-value">{{ $data['count'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        
        <div class="section-header">
            <h2 class="section-title">レビュー一覧</h2>
            @auth
                <a href="{{ route('reviews.create', ['product' => $product->id]) }}" class="btn btn-primary">
                    レビューを投稿
                </a>
            @endauth
        </div>
        
        @if($reviews->count() > 0)
            <div class="reviews-grid">
                @foreach($reviews as $review)
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-author">
                                @if($review->user->avatar_url)
                                    <img src="{{ $review->user->avatar_url }}" alt="アバター" class="author-avatar">
                                @endif
                                <div class="author-info">
                                    <h4>{{ $review->user->name }}</h4>
                                    <div class="review-date">{{ $review->created_at->format('Y年m月d日') }}</div>
                                </div>
                            </div>
                            
                            <div class="review-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $review->rating ? '' : 'empty' }}">★</span>
                                @endfor
                            </div>
                        </div>
                        
                        <h3 class="review-title">{{ $review->title }}</h3>
                        
                        <div class="review-content">
                            {{ $review->content }}
                        </div>
                        
                        @if($review->images->count() > 0)
                            <div class="review-images">
                                @foreach($review->images as $image)
                                    <img src="{{ $image->image_url }}" alt="レビュー画像" class="review-image">
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="review-actions">
                            <button class="like-button" onclick="toggleLike({{ $review->id }})">
                                <span>❤️</span>
                                <span id="like-count-{{ $review->id }}">{{ $review->likes_count }}</span>
                            </button>
                            
                            <a href="{{ route('reviews.show', $review) }}" style="color: #528B5F; text-decoration: none;">
                                詳細を見る →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="pagination">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="no-reviews">
                <div class="no-reviews-icon">📝</div>
                <h3>まだレビューがありません</h3>
                <p>このパーツの最初のレビューを投稿してみませんか？</p>
                @auth
                    <a href="{{ route('reviews.create', ['product' => $product->id]) }}" class="btn btn-primary" style="margin-top: 1rem;">
                        レビューを投稿する
                    </a>
                @endauth
            </div>
        @endif
    </div>
    
    <script>
        function toggleLike(reviewId) {
            // いいね機能のJavaScript実装
            fetch(`/reviews/${reviewId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                const countElement = document.getElementById(`like-count-${reviewId}`);
                countElement.textContent = data.likes_count;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>