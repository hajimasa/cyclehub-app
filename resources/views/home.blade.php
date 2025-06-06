<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CycleHub - 自転車パーツレビューサイト</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        .header {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
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
        
        .header-actions {
            display: flex;
            gap: 1rem;
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
            font-weight: 500;
        }
        
        .btn-primary {
            background: #528B5F;
            color: white;
        }
        
        .btn-primary:hover {
            background: #4A6741;
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background: transparent;
            color: #528B5F;
            border: 2px solid #528B5F;
        }
        
        .btn-outline:hover {
            background: #528B5F;
            color: white;
        }
        
        .hero {
            background: linear-gradient(135deg, #528B5F 0%, #6B8E23 100%);
            color: white;
            padding: 8rem 2rem 4rem;
            text-align: center;
            margin-top: 60px;
        }
        
        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .hero-title {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: bold;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .hero-description {
            font-size: 1.1rem;
            margin-bottom: 3rem;
            opacity: 0.8;
            line-height: 1.8;
        }
        
        .hero-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .features {
            padding: 4rem 2rem;
            background: #f8f9fa;
        }
        
        .features-content {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #333;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .feature-title {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: #333;
        }
        
        .feature-description {
            color: #666;
            line-height: 1.6;
        }
        
        .stats {
            padding: 4rem 2rem;
            background: white;
        }
        
        .stats-content {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .stat-item {
            padding: 1.5rem;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: #528B5F;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #666;
            font-size: 1.1rem;
        }
        
        .categories {
            padding: 4rem 2rem;
            background: #f8f9fa;
        }
        
        .categories-content {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .category-item {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        
        .category-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .category-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .category-name {
            font-weight: 500;
            color: #333;
        }
        
        .cta {
            padding: 4rem 2rem;
            background: linear-gradient(135deg, #528B5F 0%, #6B8E23 100%);
            color: white;
            text-align: center;
        }
        
        .cta-content {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .cta-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .cta-description {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .footer {
            background: #333;
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 300px;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <a href="/" class="logo">🚴 CycleHub</a>
            <div class="header-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">ダッシュボード</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">ログイン</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">無料登録</a>
                @endauth
            </div>
        </div>
    </header>
    
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">🚴 CycleHub</h1>
            <p class="hero-subtitle">自転車パーツレビューコミュニティ</p>
            <p class="hero-description">
                自転車パーツの詳細なレビューと情報を共有するプラットフォーム。<br>
                初心者からプロまで、みんなでより良いサイクリングライフを。
            </p>
            <div class="hero-actions">
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary">無料で始める</a>
                    <a href="{{ route('reviews.index') }}" class="btn btn-outline">レビューを見る</a>
                @else
                    <a href="{{ route('reviews.create') }}" class="btn btn-primary">レビューを投稿</a>
                    <a href="{{ route('reviews.index') }}" class="btn btn-outline">レビュー一覧</a>
                @endguest
            </div>
        </div>
    </section>
    
    <section class="features">
        <div class="features-content">
            <h2 class="section-title">主な機能</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📝</div>
                    <h3 class="feature-title">詳細レビュー</h3>
                    <p class="feature-description">
                        5段階評価と詳細なテキストレビュー、最大5枚の画像でパーツの魅力を伝えましょう。
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🔍</div>
                    <h3 class="feature-title">簡単検索</h3>
                    <p class="feature-description">
                        カテゴリ別、評価別、キーワード検索で、お探しのパーツレビューを素早く見つけられます。
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3 class="feature-title">コミュニティ</h3>
                    <p class="feature-description">
                        ユーザーフォロー機能で気になる人の最新レビューをチェック。いいね機能で共感を表現。
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🛒</div>
                    <h3 class="feature-title">購入サポート</h3>
                    <p class="feature-description">
                        Amazon アフィリエイトリンクで、気になったパーツをすぐに購入できます。
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3 class="feature-title">レスポンシブ</h3>
                    <p class="feature-description">
                        スマートフォン、タブレット、PCどの端末からでも快適にご利用いただけます。
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🚀</div>
                    <h3 class="feature-title">高速・安全</h3>
                    <p class="feature-description">
                        最新技術で構築された高速で安全なプラットフォーム。データは確実に保護されます。
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <section class="stats">
        <div class="stats-content">
            <h2 class="section-title">CycleHub の実績</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">レビュー数</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">登録商品</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">200+</div>
                    <div class="stat-label">アクティブユーザー</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.8★</div>
                    <div class="stat-label">平均評価</div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="categories">
        <div class="categories-content">
            <h2 class="section-title">対応カテゴリ</h2>
            <div class="category-grid">
                <div class="category-item">
                    <div class="category-icon">🚴‍♂️</div>
                    <div class="category-name">ロードバイク</div>
                </div>
                <div class="category-item">
                    <div class="category-icon">🚲</div>
                    <div class="category-name">クロスバイク</div>
                </div>
                <div class="category-item">
                    <div class="category-icon">🏔️</div>
                    <div class="category-name">マウンテンバイク</div>
                </div>
                <div class="category-item">
                    <div class="category-icon">🛤️</div>
                    <div class="category-name">グラベルバイク</div>
                </div>
                <div class="category-item">
                    <div class="category-icon">🏙️</div>
                    <div class="category-name">シティサイクル</div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="cta">
        <div class="cta-content">
            <h2 class="cta-title">今すぐ始めよう</h2>
            <p class="cta-description">
                あなたの自転車パーツ体験を共有して、サイクリングコミュニティに貢献しませんか？
            </p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-primary">無料でアカウント作成</a>
            @else
                <a href="{{ route('reviews.create') }}" class="btn btn-primary">初回レビューを投稿</a>
            @endguest
        </div>
    </section>
    
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 CycleHub. All rights reserved.</p>
            <p>自転車パーツレビューコミュニティプラットフォーム</p>
        </div>
    </footer>
</body>
</html>