<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $review->title }} - CycleHub</title>
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
            color: #667eea;
        }
        
        .container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .review-header {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .product-info {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #667eea;
        }
        
        .product-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.25rem;
        }
        
        .product-category {
            color: #666;
            font-size: 0.9rem;
        }
        
        .review-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .author-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .author-details h3 {
            color: #333;
            margin-bottom: 0.25rem;
        }
        
        .author-details small {
            color: #666;
        }
        
        .review-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .stars {
            display: flex;
            gap: 0.2rem;
        }
        
        .star {
            color: #ffc107;
            font-size: 1.5rem;
        }
        
        .star.empty {
            color: #ddd;
        }
        
        .rating-text {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }
        
        .review-title {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .review-actions {
            display: flex;
            gap: 1rem;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5a6fd8;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .review-content {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .review-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
            white-space: pre-wrap;
        }
        
        .review-images {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .image-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
        }
        
        .image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        
        .image-item:hover img {
            transform: scale(1.05);
        }
        
        .like-section {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .like-btn {
            background: none;
            border: 2px solid #ddd;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .like-btn.liked {
            border-color: #e74c3c;
            background: #e74c3c;
            color: white;
        }
        
        .like-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .related-reviews {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #eee;
        }
        
        .related-item {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
            text-decoration: none;
            color: inherit;
            transition: background 0.3s;
        }
        
        .related-item:hover {
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .related-item:last-child {
            border-bottom: none;
        }
        
        .related-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            background: #f8f9fa;
        }
        
        .related-content {
            flex: 1;
        }
        
        .related-title {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.25rem;
        }
        
        .related-meta {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        
        .related-stats {
            display: flex;
            gap: 1rem;
            font-size: 0.8rem;
            color: #666;
        }
        
        .image-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            cursor: pointer;
        }
        
        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 90%;
            max-height: 90%;
        }
        
        .modal-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .modal-close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .amazon-product {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .amazon-product-card {
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
            padding: 1.5rem;
            border: 2px solid #ff9900;
            border-radius: 12px;
            background: linear-gradient(135deg, #fff 0%, #fef9f2 100%);
        }
        
        .amazon-product-image {
            width: 150px;
            height: 150px;
            object-fit: contain;
            border-radius: 8px;
            background: white;
            padding: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            flex-shrink: 0;
        }
        
        .amazon-product-info {
            flex: 1;
        }
        
        .amazon-product-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 1rem;
            line-height: 1.4;
        }
        
        .amazon-product-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #b12704;
            margin-bottom: 1rem;
        }
        
        .amazon-product-features {
            list-style: none;
            margin-bottom: 1.5rem;
        }
        
        .amazon-product-features li {
            color: #666;
            margin-bottom: 0.5rem;
            position: relative;
            padding-left: 1rem;
        }
        
        .amazon-product-features li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
        }
        
        .amazon-buy-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #ff9900 0%, #ff7700 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(255,153,0,0.3);
        }
        
        .amazon-buy-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,153,0,0.4);
            background: linear-gradient(135deg, #ff7700 0%, #ff5500 100%);
            color: white;
        }
        
        .amazon-buy-btn:before {
            content: "🛒";
            margin-right: 0.25rem;
        }
        
        @media (max-width: 768px) {
            .amazon-product-card {
                flex-direction: column;
                text-align: center;
            }
            
            .amazon-product-image {
                align-self: center;
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
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="review-header">
            <div class="product-info">
                <div class="product-name">{{ $review->product->name }}</div>
                <div class="product-category">
                    {{ $review->product->partCategory->bikeCategory->name }} > 
                    {{ $review->product->partCategory->name }}
                </div>
            </div>
            
            <div class="review-meta">
                <div class="author-info">
                    @if($review->user->avatar_url)
                        <img src="{{ $review->user->avatar_url }}" alt="アバター" class="author-avatar">
                    @else
                        <div class="author-avatar" style="background: #ddd; display: flex; align-items: center; justify-content: center; color: #666; font-size: 1.5rem;">
                            👤
                        </div>
                    @endif
                    <div class="author-details">
                        <h3>{{ $review->user->name }}</h3>
                        <small>{{ $review->created_at->format('Y年m月d日') }}</small>
                    </div>
                </div>
                
                <div class="review-rating">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $review->rating ? '' : 'empty' }}">★</span>
                        @endfor
                    </div>
                    <span class="rating-text">{{ $review->rating }}.0</span>
                </div>
            </div>
            
            <h1 class="review-title">{{ $review->title }}</h1>
            
            @auth
                @if($review->user_id === auth()->id())
                    <div class="review-actions">
                        <a href="{{ route('reviews.edit', $review) }}" class="btn btn-primary">
                            ✏️ 編集
                        </a>
                        <form method="POST" action="{{ route('reviews.destroy', $review) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('このレビューを削除しますか？')">
                                🗑️ 削除
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
        
        <div class="review-content">
            <div class="review-text">{{ $review->content }}</div>
        </div>
        
        @if($review->images->count() > 0)
            <div class="review-images">
                <h2 class="section-title">画像</h2>
                <div class="images-grid">
                    @foreach($review->images as $image)
                        <div class="image-item" onclick="openImageModal('{{ $image->image_url }}')">
                            <img src="{{ $image->image_url }}" alt="レビュー画像">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        @auth
            <div class="like-section">
                <button class="like-btn {{ $review->isLikedBy(auth()->user()) ? 'liked' : '' }}" 
                        onclick="toggleLike({{ $review->id }})"
                        id="like-btn">
                    <span id="like-icon">{{ $review->isLikedBy(auth()->user()) ? '❤️' : '🤍' }}</span>
                    <span id="like-text">{{ $review->isLikedBy(auth()->user()) ? 'いいね済み' : 'いいね' }}</span>
                    <span id="like-count">({{ $review->likes->count() }})</span>
                </button>
            </div>
        @endauth
        
        @if($amazonProduct)
            <div class="amazon-product">
                <h2 class="section-title">🛒 Amazonで商品を見る</h2>
                <div class="amazon-product-card">
                    @if($amazonProduct['image_url'])
                        <img src="{{ $amazonProduct['image_url'] }}" alt="{{ $amazonProduct['title'] }}" class="amazon-product-image">
                    @endif
                    <div class="amazon-product-info">
                        <h3 class="amazon-product-title">{{ $amazonProduct['title'] }}</h3>
                        @if($amazonProduct['price'])
                            <div class="amazon-product-price">{{ $amazonProduct['price'] }}</div>
                        @endif
                        @if(!empty($amazonProduct['features']))
                            <ul class="amazon-product-features">
                                @foreach(array_slice($amazonProduct['features'], 0, 3) as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <a href="{{ $amazonProduct['url'] }}" target="_blank" rel="noopener noreferrer" class="amazon-buy-btn">
                            Amazonで購入
                        </a>
                    </div>
                </div>
            </div>
        @endif
        
        @if($relatedReviews->count() > 0)
            <div class="related-reviews">
                <h2 class="section-title">同じ商品の他のレビュー</h2>
                @foreach($relatedReviews as $relatedReview)
                    <a href="{{ route('reviews.show', $relatedReview) }}" class="related-item">
                        @if($relatedReview->images->count() > 0)
                            <img src="{{ $relatedReview->images->first()->image_url }}" alt="レビュー画像" class="related-image">
                        @else
                            <div class="related-image" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; color: #666;">
                                📷
                            </div>
                        @endif
                        
                        <div class="related-content">
                            <div class="related-title">{{ $relatedReview->title }}</div>
                            <div class="related-meta">
                                {{ $relatedReview->user->name }} - 
                                @for($i = 1; $i <= 5; $i++)
                                    <span style="color: {{ $i <= $relatedReview->rating ? '#ffc107' : '#ddd' }}">★</span>
                                @endfor
                            </div>
                            <div class="related-stats">
                                <span>❤️ {{ $relatedReview->likes_count }}</span>
                                <span>📅 {{ $relatedReview->created_at->format('m/d') }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
    
    <!-- Image Modal -->
    <div id="imageModal" class="image-modal" onclick="closeImageModal()">
        <span class="modal-close">&times;</span>
        <div class="modal-content">
            <img id="modalImage" class="modal-image" src="" alt="拡大画像">
        </div>
    </div>
    
    <script>
        // いいね機能
        async function toggleLike(reviewId) {
            try {
                const response = await fetch(`/reviews/${reviewId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    const btn = document.getElementById('like-btn');
                    const icon = document.getElementById('like-icon');
                    const text = document.getElementById('like-text');
                    const count = document.getElementById('like-count');
                    
                    if (data.liked) {
                        btn.classList.add('liked');
                        icon.textContent = '❤️';
                        text.textContent = 'いいね済み';
                    } else {
                        btn.classList.remove('liked');
                        icon.textContent = '🤍';
                        text.textContent = 'いいね';
                    }
                    
                    count.textContent = `(${data.likes_count})`;
                }
            } catch (error) {
                console.error('いいねの処理に失敗しました:', error);
            }
        }
        
        // 画像モーダル
        function openImageModal(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('imageModal').style.display = 'block';
        }
        
        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
        }
        
        // ESCキーでモーダルを閉じる
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</body>
</html>