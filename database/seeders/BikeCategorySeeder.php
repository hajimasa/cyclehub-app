<?php

namespace Database\Seeders;

use App\Models\BikeCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BikeCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'ロードバイク',
            'クロスバイク',
            'グラベルバイク',
            'マウンテンバイク',
            'シティサイクル',
        ];

        foreach ($categories as $category) {
            BikeCategory::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'is_active' => true,
            ]);
        }
    }
}