<?php

namespace App\Http\Controllers;

use App\Models\BikeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BikeCategoryController extends Controller
{
    public function index(): View
    {
        $categories = BikeCategory::active()
            ->withCount('partCategories')
            ->orderBy('name')
            ->get();
            
        return view('bike-categories.index', compact('categories'));
    }

    public function show(BikeCategory $bikeCategory): View
    {
        $bikeCategory->load(['partCategories' => function ($query) {
            $query->active()->withCount('products');
        }]);
        
        return view('bike-categories.show', compact('bikeCategory'));
    }

    public function create(): View
    {
        return view('bike-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:bike_categories,name',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        BikeCategory::create($validated);

        return redirect()->route('bike-categories.index')->with('success', 'カテゴリを追加しました。');
    }

    public function edit(BikeCategory $bikeCategory): View
    {
        return view('bike-categories.edit', compact('bikeCategory'));
    }

    public function update(Request $request, BikeCategory $bikeCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:bike_categories,name,' . $bikeCategory->id,
            'is_active' => 'boolean',
        ]);

        if (isset($validated['name']) && $validated['name'] !== $bikeCategory->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $bikeCategory->update($validated);

        return redirect()->route('bike-categories.index')->with('success', 'カテゴリを更新しました。');
    }

    public function destroy(BikeCategory $bikeCategory)
    {
        if ($bikeCategory->partCategories()->count() > 0) {
            return redirect()->route('bike-categories.index')
                ->with('error', 'パーツカテゴリが存在するため削除できません。');
        }

        $bikeCategory->delete();

        return redirect()->route('bike-categories.index')->with('success', 'カテゴリを削除しました。');
    }
}