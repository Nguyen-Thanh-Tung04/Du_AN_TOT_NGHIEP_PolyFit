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
        Schema::create('message_private', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_send');
            $table->unsignedBigInteger('user_receiver'); // sửa chính tả
            $table->text('message'); // thay đổi kiểu dữ liệu nếu cần
            $table->tinyInteger('is_read')->default(0);
            $table->timestamps();

            // Thêm khóa ngoại nếu muốn đảm bảo tính toàn vẹn dữ liệu
            $table->foreign('user_send')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_receiver')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_private');
    }
};
