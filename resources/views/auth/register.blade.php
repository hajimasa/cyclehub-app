<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録 - CycleHub</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #528B5F 0%, #6B8E23 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .auth-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 600px;
        }
        
        .auth-side {
            background: linear-gradient(135deg, #528B5F 0%, #6B8E23 100%);
            color: white;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }
        
        .logo {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .auth-side h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .auth-side p {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        .auth-link {
            color: white;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border: 2px solid white;
            border-radius: 25px;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .auth-link:hover {
            background: white;
            color: #528B5F;
        }
        
        .form-side {
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .form-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .form-subtitle {
            color: #666;
            font-size: 1rem;
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
            padding: 0.875rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #528B5F;
            box-shadow: 0 0 0 3px rgba(82, 139, 95, 0.1);
        }
        
        .form-control.error {
            border-color: #dc3545;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .btn {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 1rem;
        }
        
        .btn-primary {
            background: #528B5F;
            color: white;
        }
        
        .btn-primary:hover {
            background: #4A6741;
            transform: translateY(-2px);
        }
        
        .btn-google {
            background: #db4437;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-google:hover {
            background: #c23321;
            transform: translateY(-2px);
        }
        
        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
            color: #666;
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
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
        }
        
        .checkbox-group label {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }
        
        @media (max-width: 768px) {
            .auth-container {
                grid-template-columns: 1fr;
                max-width: 400px;
            }
            
            .auth-side {
                padding: 2rem 1.5rem;
            }
            
            .form-side {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-side">
            <div class="logo">🚴</div>
            <h2>CycleHubへようこそ</h2>
            <p>自転車パーツの詳細なレビューと情報を共有するコミュニティプラットフォーム</p>
            <a href="{{ route('login') }}" class="auth-link">既にアカウントをお持ちですか？</a>
        </div>
        
        <div class="form-side">
            <div class="form-header">
                <h1 class="form-title">アカウント作成</h1>
                <p class="form-subtitle">新しいアカウントを作成してください</p>
            </div>
            
            <form method="POST" action="{{ route('register.submit') }}">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">お名前</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="form-control {{ $errors->has('name') ? 'error' : '' }}" 
                           value="{{ old('name') }}" 
                           required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">メールアドレス</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-control {{ $errors->has('email') ? 'error' : '' }}" 
                           value="{{ old('email') }}" 
                           required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">パスワード</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control {{ $errors->has('password') ? 'error' : '' }}" 
                           required>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">パスワード確認</label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="form-control" 
                           required>
                </div>
                
                <button type="submit" class="btn btn-primary">アカウントを作成</button>
            </form>
            
            <div class="divider">
                <span>または</span>
            </div>
            
            <a href="{{ route('google.redirect') }}" class="btn btn-google">
                <span>🔗</span>
                Googleアカウントで登録
            </a>
        </div>
    </div>
</body>
</html>