<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 管理者用のテストユーザーを作成
        User::create([
            'id' => Str::uuid(),
            'name' => 'CycleHub Admin',
            'email' => 'admin@cyclehub.test',
            'google_id' => 'admin_test_' . Str::random(10),
            'avatar_url' => null,
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // 一般ユーザーのテストデータも作成
        User::create([
            'id' => Str::uuid(),
            'name' => 'テストユーザー',
            'email' => 'user@cyclehub.test',
            'google_id' => 'user_test_' . Str::random(10),
            'avatar_url' => null,
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);
    }
}