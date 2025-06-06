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
            ['name' => 'ロードバイク', 'slug' => 'road-bike'],
            ['name' => 'クロスバイク', 'slug' => 'cross-bike'],
            ['name' => 'グラベルバイク', 'slug' => 'gravel-bike'],
            ['name' => 'マウンテンバイク', 'slug' => 'mountain-bike'],
            ['name' => 'シティサイクル', 'slug' => 'city-bike'],
        ];

        foreach ($categories as $category) {
            BikeCategory::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'is_active' => true,
            ]);
        }
    }
}