<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('subtitle')->nullable(); // Ví dụ: NEW COLLECTION 2024
            $table->string('title');               // Ví dụ: Sải bước tự tin
            $table->text('desc')->nullable();      // Đoạn mô tả ngắn
            $table->longText('images')->nullable(); // Chuyển sang lưu Base64
            $table->string('link')->nullable();    // Link khi click nút
            $table->integer('order')->default(0);  // Thứ tự hiển thị
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};