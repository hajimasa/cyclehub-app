<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BikeCategory;
use App\Models\PartCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function bikeCategories(): View
    {
        $categories = BikeCategory::withCount('partCategories')
            ->orderBy('name')
            ->get();

        return view('admin.categories.bike.index', compact('categories'));
    }

    public function createBikeCategory(): View
    {
        return view('admin.categories.bike.create');
    }

    public function storeBikeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:bike_categories,name',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        BikeCategory::create($validated);

        return redirect()->route('admin.bike-categories')
            ->with('success', '自転車カテゴリを追加しました。');
    }

    public function editBikeCategory(BikeCategory $bikeCategory): View
    {
        return view('admin.categories.bike.edit', compact('bikeCategory'));
    }

    public function updateBikeCategory(Request $request, BikeCategory $bikeCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:bike_categories,name,' . $bikeCategory->id,
            'is_active' => 'boolean',
        ]);

        if (isset($validated['name']) && $validated['name'] !== $bikeCategory->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $bikeCategory->update($validated);

        return redirect()->route('admin.bike-categories')
            ->with('success', '自転車カテゴリを更新しました。');
    }

    public function destroyBikeCategory(BikeCategory $bikeCategory)
    {
        if ($bikeCategory->partCategories()->count() > 0) {
            return redirect()->route('admin.bike-categories')
                ->with('error', 'パーツカテゴリが存在するため削除できません。');
        }

        $bikeCategory->delete();

        return redirect()->route('admin.bike-categories')
            ->with('success', '自転車カテゴリを削除しました。');
    }

    public function partCategories(): View
    {
        $categories = PartCategory::with('bikeCategory')
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return view('admin.categories.part.index', compact('categories'));
    }

    public function createPartCategory(): View
    {
        $bikeCategories = BikeCategory::active()->orderBy('name')->get();
        return view('admin.categories.part.create', compact('bikeCategories'));
    }

    public function storePartCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bike_category_id' => 'required|exists:bike_categories,id',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        PartCategory::create($validated);

        return redirect()->route('admin.part-categories')
            ->with('success', 'パーツカテゴリを追加しました。');
    }

    public function editPartCategory(PartCategory $partCategory): View
    {
        $bikeCategories = BikeCategory::active()->orderBy('name')->get();
        return view('admin.categories.part.edit', compact('partCategory', 'bikeCategories'));
    }

    public function updatePartCategory(Request $request, PartCategory $partCategory)
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

        return redirect()->route('admin.part-categories')
            ->with('success', 'パーツカテゴリを更新しました。');
    }

    public function destroyPartCategory(PartCategory $partCategory)
    {
        if ($partCategory->products()->count() > 0) {
            return redirect()->route('admin.part-categories')
                ->with('error', '商品が存在するため削除できません。');
        }

        $partCategory->delete();

        return redirect()->route('admin.part-categories')
            ->with('success', 'パーツカテゴリを削除しました。');
    }
}