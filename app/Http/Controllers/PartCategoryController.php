<?php

namespace App\Http\Controllers;

use App\Models\BikeCategory;
use App\Models\PartCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PartCategoryController extends Controller
{
    public function index(): View
    {
        $categories = PartCategory::active()
            ->with('bikeCategory')
            ->withCount('products')
            ->orderBy('name')
            ->get();
            
        return view('part-categories.index', compact('categories'));
    }

    public function show(PartCategory $partCategory): View
    {
        $partCategory->load(['bikeCategory', 'products' => function ($query) {
            $query->withCount('visibleReviews')->orderBy('name');
        }]);
        
        return view('part-categories.show', compact('partCategory'));
    }

    public function create(): View
    {
        $bikeCategories = BikeCategory::active()->orderBy('name')->get();
        return view('part-categories.create', compact('bikeCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bike_category_id' => 'required|exists:bike_categories,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        PartCategory::create($validated);

        return redirect()->route('part-categories.index')->with('success', 'パーツカテゴリを追加しました。');
    }

    public function edit(PartCategory $partCategory): View
    {
        $bikeCategories = BikeCategory::active()->orderBy('name')->get();
        return view('part-categories.edit', compact('partCategory', 'bikeCategories'));
    }

    public function update(Request $request, PartCategory $partCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bike_category_id' => 'required|exists:bike_categories,id',
            'is_active' => 'boolean',
        ]);

        if (isset($validated['name']) && $validated['name'] !== $partCategory->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $partCategory->update($validated);

        return redirect()->route('part-categories.index')->with('success', 'パーツカテゴリを更新しました。');
    }

    public function destroy(PartCategory $partCategory)
    {
        if ($partCategory->products()->count() > 0) {
            return redirect()->route('part-categories.index')
                ->with('error', '商品が存在するため削除できません。');
        }

        $partCategory->delete();

        return redirect()->route('part-categories.index')->with('success', 'パーツカテゴリを削除しました。');
    }
}