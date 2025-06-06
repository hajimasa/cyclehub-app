<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>設定 - CycleHub Admin</title>
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
        
        .admin-nav {
            display: flex;
            gap: 1rem;
            margin-left: 2rem;
        }
        
        .admin-nav a {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .admin-nav a.active {
            color: #667eea;
            font-weight: bold;
        }
        
        .container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: #666;
        }
        
        .settings-section {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .section-title {
            font-size: 1.4rem;
            color: #333;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #eee;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .form-help {
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.5rem;
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 2rem;
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
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
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
        
        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .configuration-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding: 1rem;
            border-radius: 8px;
            background: #f8f9fa;
        }
        
        .status-icon {
            font-size: 1.2rem;
        }
        
        .status-configured {
            background: #d4edda;
            border-left: 4px solid #28a745;
        }
        
        .status-not-configured {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
        }
        
        .region-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 0.5rem;
        }
        
        .region-option {
            position: relative;
        }
        
        .region-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }
        
        .region-option label {
            display: block;
            padding: 1rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }
        
        .region-option input[type="radio"]:checked + label {
            border-color: #667eea;
            background: #f8f9ff;
        }
        
        .region-option label:hover {
            border-color: #667eea;
        }
    </style>
</head>
<body>
    <header class="header">
        <div style="display: flex; align-items: center;">
            <a href="{{ route('admin.dashboard') }}" class="logo">🚴 CycleHub Admin</a>
            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}">ダッシュボード</a>
                <a href="{{ route('admin.users') }}">ユーザー管理</a>
                <a href="{{ route('admin.reviews.index') }}">レビュー管理</a>
                <a href="{{ route('admin.bike-categories') }}">カテゴリ管理</a>
                <a href="{{ route('admin.settings') }}" class="active">設定</a>
            </nav>
        </div>
        <nav class="nav">
            <a href="{{ route('dashboard') }}">サイトに戻る</a>
        </nav>
    </header>
    
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">システム設定</h1>
            <p class="page-subtitle">アフィリエイトやその他のシステム設定を管理します</p>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="settings-section">
            <h2 class="section-title">🛒 Amazon アフィリエイト設定</h2>
            
            @php
                $isConfigured = !empty($affiliateSettings['amazon_access_key']) && 
                               !empty($affiliateSettings['amazon_secret_key']) && 
                               !empty($affiliateSettings['amazon_associate_tag']);
            @endphp
            
            <div class="configuration-status {{ $isConfigured ? 'status-configured' : 'status-not-configured' }}">
                <span class="status-icon">{{ $isConfigured ? '✅' : '❌' }}</span>
                <strong>設定状況:</strong>
                {{ $isConfigured ? 'Amazon PA APIが設定済みです' : 'Amazon PA APIが未設定です' }}
            </div>
            
            @if(!$isConfigured)
                <div class="alert alert-warning">
                    Amazon PA APIを設定することで、レビューページに自動的にAmazonの商品リンクを表示できます。
                    <a href="https://affiliate.amazon.co.jp/" target="_blank" rel="noopener">Amazon アソシエイト</a>に登録してAPIキーを取得してください。
                </div>
            @endif
            
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Amazon Access Key</label>
                    <input type="text" name="amazon_access_key" class="form-control" 
                           value="{{ $affiliateSettings['amazon_access_key'] }}" 
                           placeholder="AKIA...">
                    <div class="form-help">Amazon PA APIのアクセスキーを入力してください</div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Amazon Secret Key</label>
                    <input type="password" name="amazon_secret_key" class="form-control" 
                           value="{{ $affiliateSettings['amazon_secret_key'] }}" 
                           placeholder="シークレットキーを入力">
                    <div class="form-help">Amazon PA APIのシークレットキーを入力してください</div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Amazon Associate Tag</label>
                    <input type="text" name="amazon_associate_tag" class="form-control" 
                           value="{{ $affiliateSettings['amazon_associate_tag'] }}" 
                           placeholder="your-associate-tag">
                    <div class="form-help">Amazonアソシエイトのタグを入力してください</div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Amazon Region</label>
                    <div class="region-grid">
                        <div class="region-option">
                            <input type="radio" name="amazon_region" id="region_us" value="us-east-1" 
                                   {{ $affiliateSettings['amazon_region'] === 'us-east-1' ? 'checked' : '' }}>
                            <label for="region_us">
                                <strong>🇺🇸 US</strong><br>
                                <small>amazon.com</small>
                            </label>
                        </div>
                        <div class="region-option">
                            <input type="radio" name="amazon_region" id="region_uk" value="eu-west-1" 
                                   {{ $affiliateSettings['amazon_region'] === 'eu-west-1' ? 'checked' : '' }}>
                            <label for="region_uk">
                                <strong>🇬🇧 UK</strong><br>
                                <small>amazon.co.uk</small>
                            </label>
                        </div>
                        <div class="region-option">
                            <input type="radio" name="amazon_region" id="region_jp" value="ap-northeast-1" 
                                   {{ $affiliateSettings['amazon_region'] === 'ap-northeast-1' ? 'checked' : '' }}>
                            <label for="region_jp">
                                <strong>🇯🇵 Japan</strong><br>
                                <small>amazon.co.jp</small>
                            </label>
                        </div>
                    </div>
                    <div class="form-help">対象とするAmazonのリージョンを選択してください</div>
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">設定を保存</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">キャンセル</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>