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
            $table->string('name');  // Product name
            $table->decimal('price', 8, 2);  // Product price (e.g., 99999.99)
            $table->decimal('discount', 8, 2);  // Product price (e.g., 99999.99)
            $table->text('description')->nullable();  // Optional product description
            $table->integer('quantity')->default(0);  // Product quantity in stock
            $table->text('image');
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
