<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧 - CycleHub</title>
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
            background: #528B5F;
            color: white;
        }
        
        .btn-primary:hover {
            background: #4A6741;
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
            grid-template-columns: 1fr 1fr auto;
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
            border-color: #528B5F;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            color: inherit;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .product-placeholder {
            width: 100%;
            height: 150px;
            background: linear-gradient(135deg, #528B5F 0%, #6B8E23 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }
        
        .product-content {
            padding: 1.5rem;
        }
        
        .product-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .product-category {
            background: #f8f9fa;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            border-left: 4px solid #528B5F;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .product-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }
        
        .reviews-count {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #528B5F;
            font-weight: 500;
        }
        
        .view-reviews {
            font-size: 0.9rem;
            color: #666;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
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
        
        .pagination span[aria-disabled="true"] {
            background: #f8f9fa;
            color: #999;
            border-color: #eee;
            cursor: not-allowed;
        }
        
        .pagination .hidden {
            display: none;
        }
        
        /* Laravel pagination specific styles */
        .pagination nav span,
        .pagination nav a {
            margin: 0 2px;
        }
        
        .pagination nav .flex {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .pagination nav .flex-1 {
            flex: none;
        }
        
        .pagination svg {
            width: 16px;
            height: 16px;
        }
        
        .no-products {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        
        .no-products-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        @media (max-width: 768px) {
            .filter-form {
                grid-template-columns: 1fr;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .page-header {
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
        <div class="page-header">
            <h1 class="page-title">商品一覧</h1>
            @auth
                <a href="{{ route('reviews.create') }}" class="btn btn-primary">レビューを投稿</a>
            @endauth
        </div>
        
        <div class="filters">
            <form method="GET" class="filter-form">
                <div class="form-group">
                    <label class="form-label">カテゴリ</label>
                    <select name="category" class="form-control">
                        <option value="">すべてのカテゴリ</option>
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
                    <label class="form-label">商品名で検索</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="商品名を入力..." 
                           value="{{ request('search') }}">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">検索</button>
                </div>
            </form>
        </div>
        
        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="product-card">
                        <div class="product-placeholder">
                            🚴‍♂️
                        </div>
                        
                        <div class="product-content">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            
                            <div class="product-category">
                                {{ $product->partCategory->bikeCategory->name }} > 
                                {{ $product->partCategory->name }}
                            </div>
                            
                            <div class="product-stats">
                                <div class="reviews-count">
                                    <span>📝</span>
                                    <span>{{ $product->visible_reviews_count }}件のレビュー</span>
                                </div>
                                <div class="view-reviews">
                                    レビューを見る →
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="pagination">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @else
            <div class="no-products">
                <div class="no-products-icon">🔍</div>
                <h3>商品が見つかりませんでした</h3>
                <p>検索条件を変更してもう一度お試しください。</p>
                @auth
                    <a href="{{ route('reviews.create') }}" class="btn btn-primary" style="margin-top: 1rem;">
                        新しい商品のレビューを投稿する
                    </a>
                @endauth
            </div>
        @endif
    </div>
</body>
</html>