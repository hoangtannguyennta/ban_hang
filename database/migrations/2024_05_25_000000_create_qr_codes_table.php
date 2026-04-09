<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name'); // Tên ngân hàng hoặc mã ngân hàng (VD: VCB, MB)
            $table->string('account_number'); // Số tài khoản
            $table->string('account_owner'); // Chủ tài khoản
            $table->longText('images')->nullable(); // Thêm cột lưu ảnh mã QR (Base64)
            $table->boolean('is_active')->default(false); // Trạng thái kích hoạt
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};