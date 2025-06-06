<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レビュー投稿 - CycleHub</title>
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
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .form-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .form-title {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 2rem;
            text-align: center;
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
            border-color: #528B5F;
        }
        
        .form-control textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .rating-group {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        
        .rating-star {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .rating-star.active,
        .rating-star:hover {
            color: #ffc107;
        }
        
        .product-search {
            position: relative;
        }
        
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        
        .search-result-item {
            padding: 0.75rem;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        
        .search-result-item:hover {
            background: #f8f9fa;
        }
        
        .search-result-item:last-child {
            border-bottom: none;
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
            background: #528B5F;
            color: white;
        }
        
        .btn-primary:hover {
            background: #4A6741;
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .new-product-form {
            display: none;
            margin-top: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .toggle-btn {
            background: #17a2b8;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 0.5rem;
        }
        
        .toggle-btn:hover {
            background: #138496;
        }
        
        .image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .image-preview-item {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #ddd;
        }
        
        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .image-remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(220, 53, 69, 0.8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .image-remove-btn:hover {
            background: rgba(220, 53, 69, 1);
        }
        
        .image-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.25rem;
            font-size: 0.7rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ route('dashboard') }}" class="logo">🚴 CycleHub</a>
        <nav class="nav">
            <a href="{{ route('reviews.index') }}">レビュー一覧</a>
            <a href="{{ route('products.index') }}">商品一覧</a>
            <a href="{{ route('dashboard') }}">ダッシュボード</a>
        </nav>
    </header>
    
    <div class="container">
        <div class="form-card">
            <h1 class="form-title">レビューを投稿</h1>
            
            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">商品選択</label>
                    @if($product)
                        <div style="padding: 1rem; background: #e8f5e8; border-radius: 8px; margin-bottom: 1rem;">
                            <strong>{{ $product->name }}</strong><br>
                            <small>{{ $product->partCategory->bikeCategory->name }} > {{ $product->partCategory->name }}</small>
                        </div>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                    @else
                        <div class="product-search">
                            <input type="text" class="form-control" id="product-search" placeholder="商品名を入力して検索...">
                            <div class="search-results" id="search-results"></div>
                        </div>
                        <input type="hidden" name="product_id" id="selected-product-id">
                        
                        <button type="button" class="toggle-btn" onclick="toggleNewProductForm()">
                            新しい商品を追加
                        </button>
                        
                        <div class="new-product-form" id="new-product-form">
                            <div class="form-group">
                                <label class="form-label">商品名</label>
                                <input type="text" name="product_name" class="form-control" placeholder="商品名を入力">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">カテゴリ</label>
                                <select name="part_category_id" class="form-control">
                                    <option value="">カテゴリを選択</option>
                                    @foreach($categories as $bikeName => $partCategories)
                                        <optgroup label="{{ $bikeName }}">
                                            @foreach($partCategories as $partCategory)
                                                <option value="{{ $partCategory->id }}">{{ $partCategory->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="form-group">
                    <label class="form-label">評価 <span style="color: red;">*</span></label>
                    <div class="rating-group">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="rating-star" data-rating="{{ $i }}">★</span>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">タイトル <span style="color: red;">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="レビューのタイトル" required value="{{ old('title') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">レビュー内容 <span style="color: red;">*</span></label>
                    <textarea name="content" class="form-control" placeholder="詳細なレビューを書いてください..." required>{{ old('content') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">画像（最大5枚、10MBまで）</label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*" id="image-input">
                    <small style="color: #666; margin-top: 0.5rem; display: block;">
                        JPG, PNG, WebP形式をサポート。アップロード時に自動的にWebP形式に変換されます。
                    </small>
                    <div class="image-preview" id="image-preview"></div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">レビューを投稿</button>
                    <a href="{{ route('reviews.index') }}" class="btn btn-secondary">キャンセル</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // 評価機能
        const stars = document.querySelectorAll('.rating-star');
        const ratingInput = document.getElementById('rating-input');
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.dataset.rating;
                ratingInput.value = rating;
                updateStars(rating);
            });
            
            star.addEventListener('mouseover', function() {
                const rating = this.dataset.rating;
                updateStars(rating);
            });
        });
        
        document.querySelector('.rating-group').addEventListener('mouseleave', function() {
            const currentRating = ratingInput.value;
            updateStars(currentRating);
        });
        
        function updateStars(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }
        
        // 商品検索機能
        const productSearch = document.getElementById('product-search');
        const searchResults = document.getElementById('search-results');
        const selectedProductId = document.getElementById('selected-product-id');
        
        if (productSearch) {
            let searchTimeout;
            
            productSearch.addEventListener('input', function() {
                const query = this.value.trim();
                
                clearTimeout(searchTimeout);
                
                if (query.length < 2) {
                    searchResults.style.display = 'none';
                    return;
                }
                
                searchTimeout = setTimeout(() => {
                    fetch(`{{ route('api.products.search') }}?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            displaySearchResults(data);
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                        });
                }, 300);
            });
        }
        
        function displaySearchResults(products) {
            searchResults.innerHTML = '';
            
            if (products.length === 0) {
                searchResults.style.display = 'none';
                return;
            }
            
            products.forEach(product => {
                const item = document.createElement('div');
                item.className = 'search-result-item';
                item.innerHTML = `
                    <strong>${product.name}</strong><br>
                    <small>${product.category} (${product.reviews_count}件のレビュー)</small>
                `;
                
                item.addEventListener('click', function() {
                    selectProduct(product);
                });
                
                searchResults.appendChild(item);
            });
            
            searchResults.style.display = 'block';
        }
        
        function selectProduct(product) {
            productSearch.value = product.name;
            selectedProductId.value = product.id;
            searchResults.style.display = 'none';
            
            // 新商品フォームを隠す
            document.getElementById('new-product-form').style.display = 'none';
        }
        
        function toggleNewProductForm() {
            const form = document.getElementById('new-product-form');
            const isVisible = form.style.display === 'block';
            
            form.style.display = isVisible ? 'none' : 'block';
            
            if (!isVisible) {
                // 商品検索をクリア
                productSearch.value = '';
                selectedProductId.value = '';
                searchResults.style.display = 'none';
            }
        }
        
        // 検索結果以外をクリックした時に結果を隠す
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.product-search')) {
                searchResults.style.display = 'none';
            }
        });
        
        // 画像プレビュー機能
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        let selectedFiles = [];
        
        imageInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            
            // 5枚制限チェック
            if (selectedFiles.length + files.length > 5) {
                alert('画像は最大5枚まで選択できます。');
                return;
            }
            
            files.forEach(file => {
                if (selectedFiles.length >= 5) return;
                
                // ファイルサイズチェック（10MB）
                if (file.size > 10 * 1024 * 1024) {
                    alert(`${file.name} は10MBを超えています。`);
                    return;
                }
                
                // ファイル形式チェック
                if (!file.type.match(/^image\/(jpeg|jpg|png|webp)$/)) {
                    alert(`${file.name} はサポートされていない形式です。`);
                    return;
                }
                
                selectedFiles.push(file);
                addImagePreview(file, selectedFiles.length - 1);
            });
            
            updateFileInput();
        });
        
        function addImagePreview(file, index) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'image-preview-item';
                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="プレビュー">
                    <button type="button" class="image-remove-btn" onclick="removeImage(${index})">×</button>
                    <div class="image-info">${formatFileSize(file.size)}</div>
                `;
                imagePreview.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        }
        
        function removeImage(index) {
            selectedFiles.splice(index, 1);
            updateImagePreview();
            updateFileInput();
        }
        
        function updateImagePreview() {
            imagePreview.innerHTML = '';
            selectedFiles.forEach((file, index) => {
                addImagePreview(file, index);
            });
        }
        
        function updateFileInput() {
            // Create new FileList
            const dt = new DataTransfer();
            selectedFiles.forEach(file => {
                dt.items.add(file);
            });
            imageInput.files = dt.files;
        }
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
</body>
</html>