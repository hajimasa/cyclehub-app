<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PartCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['partCategory.bikeCategory'])
            ->withCount('visibleReviews');

        if ($request->has('category') && $request->get('category') !== '') {
            $query->where('part_category_id', $request->get('category'));
        }

        if ($request->has('search') && $request->get('search') !== '') {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $products = $query->orderBy('name')->paginate(20);
        
        $categories = PartCategory::with('bikeCategory')
            ->active()
            ->orderBy('name')
            ->get()
            ->groupBy('bikeCategory.name');

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product): View
    {
        $product->load([
            'partCategory.bikeCategory',
            'visibleReviews.user',
            'visibleReviews.images'
        ]);

        $reviews = $product->visibleReviews()
            ->with(['user', 'images'])
            ->withCount('likes')
            ->latest()
            ->paginate(10);

        $averageRating = $product->averageRating();
        $reviewsCount = $product->reviewsCount();

        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $product->visibleReviews()->where('rating', $i)->count();
            $percentage = $reviewsCount > 0 ? ($count / $reviewsCount) * 100 : 0;
            $ratingDistribution[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        return view('products.show', compact(
            'product', 
            'reviews', 
            'averageRating', 
            'reviewsCount', 
            'ratingDistribution'
        ));
    }

    public function search(Request $request)
    {
        $search = $request->get('q', '');
        
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $products = Product::where('name', 'like', "%{$search}%")
            ->with('partCategory.bikeCategory')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->partCategory->bikeCategory->name . ' > ' . $product->partCategory->name,
                    'reviews_count' => $product->reviewsCount(),
                ];
            });

        return response()->json($products);
    }
}