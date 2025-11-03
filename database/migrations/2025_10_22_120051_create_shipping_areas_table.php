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
        Schema::create('shipping_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['country', 'area', 'city', 'district']);
            $table->foreignId('parent_id')->nullable()->constrained('shipping_areas')->nullOnDelete();
            $table->decimal('cost', 10, 2)->nullable();
            $table->timestamps();

            $table->unique(['name', 'parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_areas');
    }
};
