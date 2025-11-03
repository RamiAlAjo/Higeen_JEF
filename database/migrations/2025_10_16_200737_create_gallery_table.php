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
        Schema::create('gallery', function (Blueprint $table) {
            $table->id();

            // Foreign key to albums table
            $table->foreignId('album_id')
                ->constrained('albums')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Image fields
            $table->string('image'); // Image path or filename
            $table->string('alt')->nullable(); // Alt text for accessibility
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();

            // Image metadata
            $table->unsignedBigInteger('filesize')->nullable(); // In bytes
            $table->string('mime_type')->nullable(); // e.g., image/jpeg

            // Visibility
            $table->boolean('status')->default(false)->index();

            // Sorting / display order
            $table->unsignedInteger('sort_order')->default(0)->index();

            // Timestamps & soft deletes
            $table->timestamps();
            $table->softDeletes();

            // ✅ Correct composite index (status instead of is_visible)
            $table->index(['album_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery');
    }
};
