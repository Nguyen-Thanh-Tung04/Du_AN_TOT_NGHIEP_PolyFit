<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id')->nullable(); // Liên kết với review
            $table->unsignedBigInteger('reply_id')->nullable();  // Liên kết với reply
            $table->unsignedBigInteger('user_id');
            $table->text('content');
            $table->integer('score')->nullable(); // Điểm đánh giá
            $table->string('action');  // Hành động: create, update, delete
            $table->string('type');  // Kiểu lịch sử: review hoặc reply
            $table->timestamps();
            $table->softDeletes();                    // Thêm soft deletes


            // Foreign keys
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
            $table->foreign('reply_id')->references('id')->on('review_replies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_histories');
    }
};
