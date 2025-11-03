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
       Schema::create('cart_items', function (Blueprint $table) {
    $table->id();

    $table->foreignId('cart_id')
          ->constrained('carts')
          ->onDelete('cascade');

    $table->foreignId('product_id')
          ->constrained('products')
          ->onDelete('cascade');

    $table->unsignedInteger('quantity')->default(1);

    // Optional: cache price when added
    $table->decimal('price_at_time', 10, 2)->nullable();

    $table->timestamps();

    $table->unique(['cart_id', 'product_id']); // Prevent duplicates
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
