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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('order_id');

            $table->text('content');
            $table->string('image')->nullable();
            $table->integer('score');
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
            $table->softDeletes(); // Thêm soft deletes

            // Khóa ngoại cho product_id tham chiếu đến bảng products
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Khóa ngoại cho account_id tham chiếu đến bảng users
            $table->foreign('account_id')->references('id')->on('users')->onDelete('cascade');

            // Đảm bảo order_id là một khóa ngoại liên kết với bảng orders
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};