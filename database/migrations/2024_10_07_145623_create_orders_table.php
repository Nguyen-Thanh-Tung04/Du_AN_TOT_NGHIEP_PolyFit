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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null');
            $table->string('voucher_code')->nullable();
            $table->string('full_name');
            $table->string('province_id', 10);
            $table->string('district_id', 10);
            $table->string('ward_id', 10);
            $table->string('address');
            $table->string('phone');
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->double('shipping_cost', 8, 2)->default(0);
            $table->double('total_price', 8, 2);
            $table->double('discount_amount', 8, 2)->default(0);
            $table->tinyInteger('payment_method')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
