<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダッシュボード - CycleHub</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
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
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .logout-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .logout-btn:hover {
            background: #c82333;
        }
        
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .welcome-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .welcome-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .welcome-text {
            color: #666;
            font-size: 1.1rem;
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
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }
        
        .quick-actions {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1.5rem;
        }
        
        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }
        
        .action-card {
            border: 2px solid #e9ecef;
            padding: 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            display: block;
        }
        
        .action-card:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
        }
        
        .action-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .action-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .action-desc {
            color: #666;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">🚴 CycleHub</div>
        <div class="user-info">
            @if(auth()->user()->avatar_url)
                <img src="{{ auth()->user()->avatar_url }}" alt="アバター" class="avatar">
            @endif
            <span>{{ auth()->user()->name }}</span>
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" style="background: #e74c3c; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none; margin-right: 1rem;">管理画面</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">ログアウト</button>
            </form>
        </div>
    </header>
    
    <div class="container">
        <div class="welcome-card">
            <h1 class="welcome-title">ようこそ、{{ auth()->user()->name }}さん！</h1>
            <p class="welcome-text">CycleHubで自転車パーツのレビューを共有しましょう</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📝</div>
                <div class="stat-number">0</div>
                <div class="stat-label">投稿したレビュー</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-number">0</div>
                <div class="stat-label">フォロワー数</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">❤️</div>
                <div class="stat-number">0</div>
                <div class="stat-label">いいね数</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👤</div>
                <div class="stat-number">0</div>
                <div class="stat-label">フォロー中</div>
            </div>
        </div>
        
        <div class="quick-actions">
            <h2 class="section-title">クイックアクション</h2>
            <div class="action-grid">
                <a href="{{ route('reviews.create') }}" class="action-card">
                    <div class="action-icon">➕</div>
                    <div class="action-title">レビューを投稿</div>
                    <div class="action-desc">新しいパーツのレビューを投稿します</div>
                </a>
                <a href="{{ route('reviews.index') }}" class="action-card">
                    <div class="action-icon">🔍</div>
                    <div class="action-title">レビューを探す</div>
                    <div class="action-desc">他のユーザーのレビューを閲覧します</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">👤</div>
                    <div class="action-title">プロフィール設定</div>
                    <div class="action-desc">プロフィール情報を編集します</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">🚴</div>
                    <div class="action-title">カテゴリ一覧</div>
                    <div class="action-desc">パーツカテゴリを確認します</div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>