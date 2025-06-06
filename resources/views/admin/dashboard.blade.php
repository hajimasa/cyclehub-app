<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面 - CycleHub</title>
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
        
        .admin-header {
            background: #2c3e50;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .admin-logo {
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .admin-nav {
            display: flex;
            gap: 2rem;
        }
        
        .admin-nav a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .admin-nav a:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .admin-nav a.active {
            background: #3498db;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .admin-badge {
            background: #e74c3c;
            padding: 0.2rem 0.5rem;
            border-radius: 3px;
            font-size: 0.8rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .welcome-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }
        
        .recent-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .recent-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-size: 1.2rem;
            color: #2c3e50;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #ecf0f1;
        }
        
        .recent-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #ecf0f1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .recent-item:last-child {
            border-bottom: none;
        }
        
        .item-info {
            flex: 1;
        }
        
        .item-title {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 0.25rem;
        }
        
        .item-meta {
            font-size: 0.8rem;
            color: #666;
        }
        
        .status-badge {
            padding: 0.2rem 0.5rem;
            border-radius: 3px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-visible {
            background: #d4edda;
            color: #155724;
        }
        
        .status-hidden {
            background: #f8d7da;
            color: #721c24;
        }
        
        .back-to-site {
            background: #3498db;
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .back-to-site:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="admin-logo">🛠️ CycleHub 管理画面</div>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}" class="active">ダッシュボード</a>
            <a href="{{ route('admin.reviews.index') }}">レビュー管理</a>
            <a href="{{ route('admin.users') }}">ユーザー管理</a>
            <a href="{{ route('admin.bike-categories') }}">カテゴリ管理</a>
            <a href="{{ route('admin.settings') }}">設定</a>
        </nav>
        <div class="user-info">
            <span class="admin-badge">ADMIN</span>
            <span>{{ auth()->user()->name }}</span>
            <a href="{{ route('dashboard') }}" class="back-to-site">サイトに戻る</a>
        </div>
    </header>
    
    <div class="container">
        <div class="welcome-card">
            <h1>管理画面ダッシュボード</h1>
            <p>CycleHubの管理機能にアクセスできます</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-number">{{ $stats['users_count'] }}</div>
                <div class="stat-label">総ユーザー数</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📝</div>
                <div class="stat-number">{{ $stats['reviews_count'] }}</div>
                <div class="stat-label">総レビュー数</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-number">{{ $stats['visible_reviews_count'] }}</div>
                <div class="stat-label">公開レビュー</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">❌</div>
                <div class="stat-number">{{ $stats['hidden_reviews_count'] }}</div>
                <div class="stat-label">非公開レビュー</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🚴</div>
                <div class="stat-number">{{ $stats['bike_categories_count'] }}</div>
                <div class="stat-label">自転車カテゴリ</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🔧</div>
                <div class="stat-number">{{ $stats['part_categories_count'] }}</div>
                <div class="stat-label">パーツカテゴリ</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📦</div>
                <div class="stat-number">{{ $stats['products_count'] }}</div>
                <div class="stat-label">登録商品数</div>
            </div>
        </div>
        
        <div class="recent-section">
            <div class="recent-card">
                <h2 class="section-title">最新のレビュー</h2>
                @forelse($recentReviews as $review)
                    <div class="recent-item">
                        <div class="item-info">
                            <div class="item-title">{{ $review->title }}</div>
                            <div class="item-meta">
                                {{ $review->user->name }} - {{ $review->product->name }}
                                ({{ $review->created_at->format('Y/m/d H:i') }})
                            </div>
                        </div>
                        <span class="status-badge {{ $review->is_visible ? 'status-visible' : 'status-hidden' }}">
                            {{ $review->is_visible ? '公開' : '非公開' }}
                        </span>
                    </div>
                @empty
                    <p class="item-meta">レビューがありません</p>
                @endforelse
            </div>
            
            <div class="recent-card">
                <h2 class="section-title">新規ユーザー</h2>
                @forelse($recentUsers as $user)
                    <div class="recent-item">
                        <div class="item-info">
                            <div class="item-title">{{ $user->name }}</div>
                            <div class="item-meta">
                                {{ $user->email }} ({{ $user->created_at->format('Y/m/d H:i') }})
                            </div>
                        </div>
                        @if($user->is_admin)
                            <span class="status-badge" style="background: #ffeaa7; color: #2d3436;">管理者</span>
                        @endif
                    </div>
                @empty
                    <p class="item-meta">新規ユーザーがありません</p>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>