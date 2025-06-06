<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Review;
use App\Models\BikeCategory;
use App\Models\PartCategory;
use App\Models\Product;
use App\Models\AffiliateSetting;
use App\Services\AmazonAffiliateService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'users_count' => User::count(),
            'reviews_count' => Review::count(),
            'visible_reviews_count' => Review::visible()->count(),
            'hidden_reviews_count' => Review::where('is_visible', false)->count(),
            'bike_categories_count' => BikeCategory::count(),
            'part_categories_count' => PartCategory::count(),
            'products_count' => Product::count(),
        ];

        $recentReviews = Review::with(['user', 'product.partCategory.bikeCategory'])
            ->latest()
            ->take(10)
            ->get();

        $recentUsers = User::latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentReviews', 'recentUsers'));
    }

    public function users(): View
    {
        $users = User::withCount(['reviews', 'followers', 'following'])
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function toggleUserAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', '自分の管理者権限は変更できません。');
        }

        $user->update(['is_admin' => !$user->is_admin]);

        $message = $user->is_admin 
            ? $user->name . 'に管理者権限を付与しました。'
            : $user->name . 'の管理者権限を削除しました。';

        return back()->with('success', $message);
    }

    public function settings(): View
    {
        $affiliateSettings = [
            'amazon_access_key' => AffiliateSetting::get('amazon_access_key', ''),
            'amazon_secret_key' => AffiliateSetting::get('amazon_secret_key', ''),
            'amazon_associate_tag' => AffiliateSetting::get('amazon_associate_tag', ''),
            'amazon_region' => AffiliateSetting::get('amazon_region', 'us-east-1'),
        ];

        return view('admin.settings', compact('affiliateSettings'));
    }

    public function updateSettings(Request $request, AmazonAffiliateService $affiliateService)
    {
        $validated = $request->validate([
            'amazon_access_key' => 'nullable|string',
            'amazon_secret_key' => 'nullable|string',
            'amazon_associate_tag' => 'nullable|string',
            'amazon_region' => 'nullable|string|in:us-east-1,us-west-2,eu-west-1,ap-northeast-1',
        ]);

        // アフィリエイト設定を更新
        $affiliateService->updateConfiguration($validated);

        return back()->with('success', 'アフィリエイト設定を更新しました。');
    }
}