<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Thêm cột order_id để liên kết với bảng orders
            $table->unsignedBigInteger('order_id')->nullable()->after('product_id');

            // Đảm bảo order_id là một khóa ngoại liên kết với bảng orders
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Xóa khóa ngoại và cột order_id khi rollback migration
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');
        });
    }
};
