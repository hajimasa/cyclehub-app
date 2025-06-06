<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function profile(User $user): View
    {
        $user->load(['reviews.product.partCategory.bikeCategory', 'reviews.images']);
        
        $stats = [
            'reviews_count' => $user->reviews()->visible()->count(),
            'followers_count' => $user->followers()->count(),
            'following_count' => $user->following()->count(),
            'likes_count' => $user->reviews()->withCount('likes')->get()->sum('likes_count'),
        ];
        
        $recentReviews = $user->reviews()
            ->visible()
            ->with(['product.partCategory.bikeCategory', 'images'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('user.profile', compact('user', 'stats', 'recentReviews'));
    }

    public function edit(): View
    {
        $user = auth()->user();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('user.profile', $user)->with('success', 'プロフィールを更新しました。');
    }

    public function follow(User $user)
    {
        $currentUser = auth()->user();
        
        if ($currentUser->id === $user->id) {
            return back()->with('error', '自分自身をフォローすることはできません。');
        }
        
        $currentUser->follow($user);
        
        return back()->with('success', $user->name . 'さんをフォローしました。');
    }

    public function unfollow(User $user)
    {
        auth()->user()->unfollow($user);
        
        return back()->with('success', $user->name . 'さんのフォローを解除しました。');
    }

    public function followers(User $user): View
    {
        $followers = $user->followers()->latest('user_follows.created_at')->paginate(20);
        
        return view('user.followers', compact('user', 'followers'));
    }

    public function following(User $user): View
    {
        $following = $user->following()->latest('user_follows.created_at')->paginate(20);
        
        return view('user.following', compact('user', 'following'));
    }
}