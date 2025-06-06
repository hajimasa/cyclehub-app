<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン - CycleHub</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #528B5F 0%, #6B8E23 100%);
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
        
        .login-options {
            margin-bottom: 2rem;
        }
        
        .login-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 1rem 2rem;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 1rem;
        }
        
        .email-btn {
            background: #528B5F;
            color: white;
        }
        
        .email-btn:hover {
            background: #4A6741;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(82, 139, 95, 0.3);
        }
        
        .google-btn {
            background: #4285f4;
            color: white;
        }
        
        .google-btn:hover {
            background: #357ae8;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(66, 133, 244, 0.3);
        }
        
        .login-icon,
        .google-icon {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }
        
        .divider {
            text-align: center;
            margin: 1rem 0;
            position: relative;
            color: #666;
            font-size: 0.9rem;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e9ecef;
        }
        
        .divider span {
            background: white;
            padding: 0 1rem;
        }
        
        .register-link {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #eee;
        }
        
        .register-link p {
            color: #666;
            font-size: 0.95rem;
            margin: 0;
        }
        
        .register-link a {
            color: #528B5F;
            text-decoration: none;
        }
        
        .register-link a:hover {
            text-decoration: underline;
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
        
        <div class="login-options">
            <a href="{{ route('login') }}" class="login-btn email-btn">
                <span class="login-icon">📧</span>
                メールアドレスでログイン
            </a>
            
            <div class="divider">
                <span>または</span>
            </div>
            
            <a href="{{ route('google.redirect') }}" class="login-btn google-btn">
                <span class="google-icon">🔑</span>
                Googleでログイン
            </a>
        </div>
        
        <div class="register-link">
            <p>アカウントをお持ちでない方は <a href="{{ route('register') }}">こちらから登録</a></p>
        </div>
        
        <div class="features">
            <div class="feature">パーツレビューの投稿・閲覧</div>
            <div class="feature">ユーザーフォロー機能</div>
            <div class="feature">お気に入りレビュー</div>
            <div class="feature">アフィリエイトリンク表示</div>
        </div>
    </div>
</body>
</html>