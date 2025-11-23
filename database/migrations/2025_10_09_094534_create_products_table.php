<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            // Names & Descriptions
            $table->string('product_name_en');
            $table->string('product_name_ar');
            $table->string('slug')->unique()->index();

            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();

            // Price & Stock
            $table->decimal('price', 12, 4)->default(0);
            $table->unsignedInteger('quantity')->default(0);

            // FIXED: Only ONE generated column (MariaDB compatible)
            $table->boolean('in_stock')->storedAs('quantity > 0')->index();

            // Status & Featured
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->boolean('featured')->default(false)->index();

            // Category Relations
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('products_categories')
                ->nullOnDelete();

            $table->foreignId('subcategory_id')
                ->nullable()
                ->constrained('products_subcategories')
                ->nullOnDelete();

            // Images
            $table->json('images')->nullable();

            // Hesabate fields (for import)
            $table->string('hesabate_id')->nullable()->unique();
            $table->string('hesabate_class_id')->nullable();

            $table->json('variants')->nullable();
            $table->json('sizes')->nullable();
            $table->json('colors')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Performance Indexes
            $table->index(['category_id', 'in_stock', 'status']);
            $table->index('price');
            $table->index('hesabate_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};