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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->decimal('value', 8, 2);
            $table->decimal('max_discount_value', 8, 2);
            $table->decimal('min_order_value', 8, 2);
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->integer('quantity')->default(1);
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
