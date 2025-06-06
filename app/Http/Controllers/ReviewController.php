<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\PartCategory;
use App\Models\ReviewLike;
use App\Models\ReviewImage;
use App\Services\ImageUploadService;
use App\Services\AmazonAffiliateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $query = Review::visible()
            ->with(['user', 'product.partCategory.bikeCategory', 'images'])
            ->withCount('likes');

        if ($request->has('category') && $request->get('category') !== '') {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('part_category_id', $request->get('category'));
            });
        }

        if ($request->has('rating') && $request->get('rating') !== '') {
            $query->byRating($request->get('rating'));
        }

        if ($request->has('search') && $request->get('search') !== '') {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($productQuery) use ($search) {
                      $productQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'rating_high':
                $query->orderBy('rating', 'desc');
                break;
            case 'rating_low':
                $query->orderBy('rating', 'asc');
                break;
            case 'likes':
                $query->orderBy('likes_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $reviews = $query->paginate(12);
        
        $categories = PartCategory::with('bikeCategory')
            ->active()
            ->orderBy('name')
            ->get()
            ->groupBy('bikeCategory.name');

        return view('reviews.index', compact('reviews', 'categories'));
    }

    public function show(Review $review, AmazonAffiliateService $affiliateService): View
    {
        if (!$review->is_visible) {
            abort(404);
        }

        $review->load([
            'user',
            'product.partCategory.bikeCategory',
            'images',
            'likes.user'
        ]);

        $relatedReviews = Review::visible()
            ->where('id', '!=', $review->id)
            ->where('product_id', $review->product_id)
            ->with(['user', 'images'])
            ->withCount('likes')
            ->latest()
            ->take(5)
            ->get();

        // Amazon商品を検索
        $amazonProduct = null;
        if ($affiliateService->isConfigured()) {
            $amazonProduct = $affiliateService->getBestMatchProduct($review->product->name);
        }

        return view('reviews.show', compact('review', 'relatedReviews', 'amazonProduct'));
    }

    public function create(Request $request): View
    {
        $productId = $request->get('product_id');
        $product = null;
        
        if ($productId) {
            $product = Product::with('partCategory.bikeCategory')->find($productId);
        }

        $categories = PartCategory::with('bikeCategory')
            ->active()
            ->orderBy('name')
            ->get()
            ->groupBy('bikeCategory.name');

        return view('reviews.create', compact('product', 'categories'));
    }

    public function store(Request $request, ImageUploadService $imageUploadService)
    {
        $validated = $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'product_name' => 'required_if:product_id,null|string|max:255',
            'part_category_id' => 'required_if:product_id,null|exists:part_categories,id',
            'rating' => 'required|integer|between:1,5',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|max:10240|mimes:jpg,jpeg,png,webp'
        ]);

        // 画像のバリデーション
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $errors = $imageUploadService->validateImage($file);
                if (!empty($errors)) {
                    return back()->withErrors(['images' => implode(' ', $errors)])->withInput();
                }
            }
        }

        DB::beginTransaction();
        try {
            // 商品が指定されていない場合は新規作成
            if (!$validated['product_id']) {
                $product = Product::firstOrCreate([
                    'name' => $validated['product_name'],
                    'part_category_id' => $validated['part_category_id']
                ]);
                $validated['product_id'] = $product->id;
            }

            // レビュー作成
            $review = Review::create([
                'user_id' => auth()->id(),
                'product_id' => $validated['product_id'],
                'rating' => $validated['rating'],
                'title' => $validated['title'],
                'content' => $validated['content'],
            ]);

            // 画像アップロード処理
            if ($request->hasFile('images')) {
                $this->handleImageUploads($review, $request->file('images'), $imageUploadService);
            }

            DB::commit();

            return redirect()->route('reviews.show', $review)
                ->with('success', 'レビューを投稿しました。');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'レビューの投稿に失敗しました：' . $e->getMessage())->withInput();
        }
    }

    public function edit(Review $review): View
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = PartCategory::with('bikeCategory')
            ->active()
            ->orderBy('name')
            ->get()
            ->groupBy('bikeCategory.name');

        return view('reviews.edit', compact('review', 'categories'));
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $review->update($validated);

        return redirect()->route('reviews.show', $review)
            ->with('success', 'レビューを更新しました。');
    }

    public function destroy(Review $review, ImageUploadService $imageUploadService)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            // 関連画像を削除
            $imagePaths = $review->images->pluck('image_path')->toArray();
            if (!empty($imagePaths)) {
                $imageUploadService->deleteMultiple($imagePaths);
            }

            $review->delete();

            DB::commit();

            return redirect()->route('reviews.index')
                ->with('success', 'レビューを削除しました。');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'レビューの削除に失敗しました。');
        }
    }

    public function like(Review $review)
    {
        if (!$review->is_visible) {
            abort(404);
        }

        $existingLike = ReviewLike::where([
            'user_id' => auth()->id(),
            'review_id' => $review->id
        ])->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            ReviewLike::create([
                'user_id' => auth()->id(),
                'review_id' => $review->id
            ]);
            $liked = true;
        }

        $likesCount = $review->likes()->count();

        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount
        ]);
    }

    /**
     * 画像アップロード処理
     */
    protected function handleImageUploads(Review $review, array $files, ImageUploadService $imageUploadService): void
    {
        $order = 0;
        foreach ($files as $file) {
            if ($file->isValid()) {
                try {
                    // 画像をアップロードしてWebPに変換
                    $result = $imageUploadService->uploadAndConvert($file, "review-{$review->id}");

                    // データベースに保存
                    ReviewImage::create([
                        'review_id' => $review->id,
                        'image_path' => $result['path'],
                        'image_url' => $result['url'],
                        'order' => $order++,
                    ]);

                } catch (\Exception $e) {
                    // ログに記録（画像アップロードエラーは処理を停止しない）
                    \Log::error('Failed to upload review image: ' . $e->getMessage());
                }
            }
        }
    }

    /**
     * 画像削除
     */
    public function deleteImage(Review $review, ReviewImage $image, ImageUploadService $imageUploadService)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        if ($image->review_id !== $review->id) {
            abort(404);
        }

        try {
            // ストレージから画像を削除
            $imageUploadService->delete($image->image_path);

            // データベースから削除
            $image->delete();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Image deletion failed'], 500);
        }
    }
}