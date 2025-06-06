<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン - CycleHub</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        
        .login-container {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        
        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }
        
        .google-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #4285f4;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            width: 100%;
            box-sizing: border-box;
        }
        
        .google-btn:hover {
            background: #357ae8;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(66, 133, 244, 0.3);
        }
        
        .google-icon {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 4px solid #c33;
        }
        
        .features {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #eee;
            text-align: left;
        }
        
        .feature {
            margin-bottom: 0.5rem;
            color: #666;
            font-size: 0.9rem;
        }
        
        .feature::before {
            content: "✓";
            color: #4285f4;
            font-weight: bold;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">🚴 CycleHub</div>
        <div class="subtitle">自転車パーツレビューサイト</div>
        
        @if(session('error'))
            <div class="error">
                {{ session('error') }}
            </div>
        @endif
        
        <a href="{{ route('google.redirect') }}" class="google-btn">
            <span class="google-icon">🔑</span>
            Googleでログイン
        </a>
        
        <div class="features">
            <div class="feature">パーツレビューの投稿・閲覧</div>
            <div class="feature">ユーザーフォロー機能</div>
            <div class="feature">お気に入りレビュー</div>
            <div class="feature">アフィリエイトリンク表示</div>
        </div>
    </div>
</body>
</html>