<?php

namespace Database\Seeders;

use App\Models\PartCategory;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // ロードバイク ホイール
            ['name' => 'Shimano Dura-Ace C60', 'category' => 'ホイール', 'bike' => 'ロードバイク'],
            ['name' => 'Mavic Cosmic Pro Carbon', 'category' => 'ホイール', 'bike' => 'ロードバイク'],
            ['name' => 'Campagnolo Bora Ultra 35', 'category' => 'ホイール', 'bike' => 'ロードバイク'],
            
            // ロードバイク フレーム
            ['name' => 'Trek Émonda SLR', 'category' => 'フレーム', 'bike' => 'ロードバイク'],
            ['name' => 'Specialized Tarmac SL7', 'category' => 'フレーム', 'bike' => 'ロードバイク'],
            ['name' => 'Giant TCR Advanced Pro', 'category' => 'フレーム', 'bike' => 'ロードバイク'],
            
            // ロードバイク コンポーネント
            ['name' => 'Shimano Dura-Ace Di2', 'category' => 'コンポーネント', 'bike' => 'ロードバイク'],
            ['name' => 'SRAM Red eTap AXS', 'category' => 'コンポーネント', 'bike' => 'ロードバイク'],
            ['name' => 'Campagnolo Super Record EPS', 'category' => 'コンポーネント', 'bike' => 'ロードバイク'],
            
            // ロードバイク タイヤ
            ['name' => 'Continental GP5000', 'category' => 'タイヤ', 'bike' => 'ロードバイク'],
            ['name' => 'Michelin Power Road', 'category' => 'タイヤ', 'bike' => 'ロードバイク'],
            ['name' => 'Pirelli P Zero Velo', 'category' => 'タイヤ', 'bike' => 'ロードバイク'],
            
            // マウンテンバイク ホイール
            ['name' => 'DT Swiss XM 1700 Spline', 'category' => 'ホイール', 'bike' => 'マウンテンバイク'],
            ['name' => 'Mavic Crossmax Pro', 'category' => 'ホイール', 'bike' => 'マウンテンバイク'],
            ['name' => 'Industry Nine Enduro S', 'category' => 'ホイール', 'bike' => 'マウンテンバイク'],
            
            // マウンテンバイク サスペンション
            ['name' => 'Fox 36 Factory', 'category' => 'サスペンション', 'bike' => 'マウンテンバイク'],
            ['name' => 'RockShox Pike Ultimate', 'category' => 'サスペンション', 'bike' => 'マウンテンバイク'],
            ['name' => 'Ohlins RXF36', 'category' => 'サスペンション', 'bike' => 'マウンテンバイク'],
            
            // クロスバイク
            ['name' => 'Schwalbe Marathon Plus', 'category' => 'タイヤ', 'bike' => 'クロスバイク'],
            ['name' => 'Brooks B17 Standard', 'category' => 'サドル', 'bike' => 'クロスバイク'],
            ['name' => 'Ergon GP1', 'category' => 'ハンドル', 'bike' => 'クロスバイク'],
        ];

        foreach ($products as $productData) {
            $partCategory = PartCategory::whereHas('bikeCategory', function ($query) use ($productData) {
                $query->where('name', $productData['bike']);
            })->where('name', $productData['category'])->first();

            if ($partCategory) {
                Product::create([
                    'name' => $productData['name'],
                    'part_category_id' => $partCategory->id,
                ]);
            }
        }
    }
}