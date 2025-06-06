<?php

namespace Database\Seeders;

use App\Models\BikeCategory;
use App\Models\PartCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PartCategorySeeder extends Seeder
{
    public function run(): void
    {
        $partsByBike = [
            'ロードバイク' => [
                'ホイール',
                'フレーム', 
                'コンポーネント',
                'タイヤ',
                'サドル',
                'ハンドル',
                'ペダル',
                'ブレーキ',
                'チェーン',
                'カセットスプロケット',
            ],
            'クロスバイク' => [
                'ホイール',
                'フレーム',
                'コンポーネント', 
                'タイヤ',
                'サドル',
                'ハンドル',
                'ペダル',
                'ブレーキ',
                'チェーン',
                'フェンダー',
            ],
            'グラベルバイク' => [
                'ホイール',
                'フレーム',
                'コンポーネント',
                'タイヤ', 
                'サドル',
                'ハンドル',
                'ペダル',
                'ブレーキ',
                'チェーン',
                'バッグ・アクセサリー',
            ],
            'マウンテンバイク' => [
                'ホイール',
                'フレーム',
                'サスペンション',
                'タイヤ',
                'サドル',
                'ハンドル',
                'ペダル',
                'ブレーキ',
                'チェーン',
                'プロテクター',
            ],
            'シティサイクル' => [
                'ホイール',
                'フレーム',
                'タイヤ',
                'サドル',
                'ハンドル',
                'ペダル',
                'ブレーキ',
                'チェーン',
                'カゴ',
                'ライト',
            ],
        ];

        foreach ($partsByBike as $bikeName => $parts) {
            $bikeCategory = BikeCategory::where('name', $bikeName)->first();
            
            if ($bikeCategory) {
                foreach ($parts as $partName) {
                    PartCategory::create([
                        'name' => $partName,
                        'bike_category_id' => $bikeCategory->id,
                        'slug' => Str::slug($partName),
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}