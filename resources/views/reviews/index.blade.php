<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レビュー一覧 - CycleHub</title>
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
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title {
            font-size: 2rem;
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
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5a6fd8;
            transform: translateY(-1px);
        }
        
        .filters {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .filter-form {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }
        
        .form-group {
            margin: 0;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
            font-size: 0.9rem;
        }
        
        .form-control {
            width: 100%;
            padding: 0.5rem;
            border: 2px solid #e9ecef;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }
        
        .review-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            color: inherit;
        }
        
        .review-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .review-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 3rem;
        }
        
        .review-content {
            padding: 1.5rem;
        }
        
        .review-rating {
            display: flex;
            gap: 0.2rem;
            margin-bottom: 0.5rem;
        }
        
        .star {
            color: #ffc107;
            font-size: 1.2rem;
        }
        
        .star.empty {
            color: #ddd;
        }
        
        .review-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .review-excerpt {
            color: #666;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }
        
        .review-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 1rem;
        }
        
        .review-author {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .author-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .review-stats {
            display: flex;
            gap: 1rem;
        }
        
        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .product-info {
            background: #f8f9fa;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        
        .product-name {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.25rem;
        }
        
        .product-category {
            font-size: 0.8rem;
            color: #666;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
            gap: 0.5rem;
        }
        
        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
        }
        
        .pagination a:hover {
            background: #f8f9fa;
        }
        
        .pagination .current {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        
        .no-reviews {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        
        .no-reviews-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
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
        <div class="page-header">
            <h1 class="page-title">レビュー一覧</h1>
            @auth
                <a href="{{ route('reviews.create') }}" class="btn btn-primary">レビューを投稿</a>
            @endauth
        </div>
        
        <div class="filters">
            <form method="GET" class="filter-form">
                <div class="form-group">
                    <label class="form-label">カテゴリ</label>
                    <select name="category" class="form-control">
                        <option value="">すべて</option>
                        @foreach($categories as $bikeName => $partCategories)
                            <optgroup label="{{ $bikeName }}">
                                @foreach($partCategories as $partCategory)
                                    <option value="{{ $partCategory->id }}" 
                                        {{ request('category') == $partCategory->id ? 'selected' : '' }}>
                                        {{ $partCategory->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">評価</label>
                    <select name="rating" class="form-control">
                        <option value="">すべて</option>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                {{ $i }}★以上
                            </option>
                        @endfor
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">並び順</label>
                    <select name="sort" class="form-control">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>新着順</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>古い順</option>
                        <option value="rating_high" {{ request('sort') == 'rating_high' ? 'selected' : '' }}>評価が高い順</option>
                        <option value="rating_low" {{ request('sort') == 'rating_low' ? 'selected' : '' }}>評価が低い順</option>
                        <option value="likes" {{ request('sort') == 'likes' ? 'selected' : '' }}>いいね順</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">キーワード</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="商品名、タイトル、内容..." 
                           value="{{ request('search') }}">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">検索</button>
                </div>
            </form>
        </div>
        
        @if($reviews->count() > 0)
            <div class="reviews-grid">
                @foreach($reviews as $review)
                    <a href="{{ route('reviews.show', $review) }}" class="review-card">
                        @if($review->images->count() > 0)
                            <img src="{{ $review->images->first()->image_url }}" alt="レビュー画像" class="review-image">
                        @else
                            <div class="review-image">📷</div>
                        @endif
                        
                        <div class="review-content">
                            <div class="product-info">
                                <div class="product-name">{{ $review->product->name }}</div>
                                <div class="product-category">
                                    {{ $review->product->partCategory->bikeCategory->name }} > 
                                    {{ $review->product->partCategory->name }}
                                </div>
                            </div>
                            
                            <div class="review-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $review->rating ? '' : 'empty' }}">★</span>
                                @endfor
                            </div>
                            
                            <h3 class="review-title">{{ $review->title }}</h3>
                            <p class="review-excerpt">{{ Str::limit($review->content, 100) }}</p>
                            
                            <div class="review-meta">
                                <div class="review-author">
                                    @if($review->user->avatar_url)
                                        <img src="{{ $review->user->avatar_url }}" alt="アバター" class="author-avatar">
                                    @endif
                                    <span>{{ $review->user->name }}</span>
                                </div>
                                
                                <div class="review-stats">
                                    <div class="stat-item">
                                        <span>❤️</span>
                                        <span>{{ $review->likes_count }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <span>📅</span>
                                        <span>{{ $review->created_at->format('m/d') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="pagination">
                {{ $reviews->appends(request()->query())->links() }}
            </div>
        @else
            <div class="no-reviews">
                <div class="no-reviews-icon">📝</div>
                <h3>レビューが見つかりませんでした</h3>
                <p>条件を変更して再度検索してください。</p>
                @auth
                    <a href="{{ route('reviews.create') }}" class="btn btn-primary" style="margin-top: 1rem;">
                        最初のレビューを投稿する
                    </a>
                @endauth
            </div>
        @endif
    </div>
</body>
</html>