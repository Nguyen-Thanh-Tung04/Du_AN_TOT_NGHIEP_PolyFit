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
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['variant_id']);
            $table->dropForeign(['order_id']);

            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['variant_id']);
            $table->dropForeign(['order_id']);

            $table->foreign('variant_id')
                  ->references('id')
                  ->on('variants')
                  ->onDelete('set null');
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('set null');
        });
    }
};
