<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('sizes')->nullable()->after('price'); // Lưu mảng các size có sẵn
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->string('size')->nullable()->after('quantity'); // Lưu size cụ thể khách chọn
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) { $table->dropColumn('sizes'); });
        Schema::table('order_items', function (Blueprint $table) { $table->dropColumn('size'); });
    }
};