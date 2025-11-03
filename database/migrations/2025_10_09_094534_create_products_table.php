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
            $table->string('product_name_en');
            $table->string('product_name_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->json('image')->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('quantity')->default(0);
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');

$table->foreignId('category_id')->nullable()->index();
$table->foreignId('subcategory_id')->nullable()->index();

$table->foreign('category_id', 'products_category_id_foreign')
    ->references('id')
    ->on('products_categories')
    ->onDelete('cascade');

$table->foreign('subcategory_id', 'products_subcategory_id_foreign')
    ->references('id')
    ->on('products_subcategories')
    ->onDelete('set null');


            $table->string('slug')->unique()->index();
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
