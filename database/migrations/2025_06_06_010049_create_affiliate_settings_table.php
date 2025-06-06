<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('affiliate_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // 設定キー（amazon_access_key等）
            $table->text('value')->nullable(); // 設定値
            $table->boolean('is_encrypted')->default(false); // 暗号化フラグ
            $table->string('description')->nullable(); // 設定説明
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_settings');
    }
};
