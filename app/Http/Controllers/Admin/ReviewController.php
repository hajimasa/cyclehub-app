<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $query = Review::with(['user', 'product.partCategory.bikeCategory']);

        if ($request->has('status')) {
            $status = $request->get('status');
            if ($status === 'visible') {
                $query->visible();
            } elseif ($status === 'hidden') {
                $query->where('is_visible', false);
            }
        }

        if ($request->has('rating') && $request->get('rating') !== '') {
            $query->byRating($request->get('rating'));
        }

        if ($request->has('search') && $request->get('search') !== '') {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('product', function ($productQuery) use ($search) {
                      $productQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $reviews = $query->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Review $review): View
    {
        $review->load(['user', 'product.partCategory.bikeCategory', 'images', 'likes.user']);

        return view('admin.reviews.show', compact('review'));
    }

    public function toggleVisibility(Review $review)
    {
        $review->update(['is_visible' => !$review->is_visible]);

        $message = $review->is_visible 
            ? 'レビューを表示状態にしました。'
            : 'レビューを非表示状態にしました。';

        return back()->with('success', $message);
    }

    public function bulkToggleVisibility(Request $request)
    {
        $reviewIds = $request->input('review_ids', []);
        $action = $request->input('action');

        if (empty($reviewIds)) {
            return back()->with('error', 'レビューが選択されていません。');
        }

        $isVisible = $action === 'show';
        Review::whereIn('id', $reviewIds)->update(['is_visible' => $isVisible]);

        $message = $isVisible 
            ? count($reviewIds) . '件のレビューを表示状態にしました。'
            : count($reviewIds) . '件のレビューを非表示状態にしました。';

        return back()->with('success', $message);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'レビューを削除しました。');
    }
}