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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('category_id')->constrained('product_categories')->cascadeOnDelete();
            $table->foreignId("store_id")->constrained("stores")->cascadeOnDelete();
            $table->foreignId("brand_id")->constrained("brands")->cascadeOnDelete();
            $table->foreignId("currency_id")->constrained("currencies");
            $table->string('name');
            $table->string('slug');
            $table->decimal('amount', 8, 2);
            $table->string('identification_no');
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->decimal('discount_percent')->nullable();
            $table->string('discount_period')->nullable();
            $table->string('basic_unit'); // e.g, fibre, kg, litre, etc //
            $table->text('description'); // product spec and details
            $table->string('warranty lenght')->nullable();
            $table->string('warranty policy')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('stock_status');
            $table->string('status')->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
