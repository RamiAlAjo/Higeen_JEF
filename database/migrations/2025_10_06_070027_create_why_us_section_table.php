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
        Schema::create('why_us_section', function (Blueprint $table) {
            $table->id();

            // Why Us Section (this will be the general section heading, not individual pages)
        $table->text('why_us_title_en')->nullable(); // General "Why Us" title in English
        $table->text('why_us_title_ar')->nullable(); // General "Why Us" title in Arabic
        $table->text('why_us_description_en')->nullable(); // General description in English
        $table->text('why_us_description_ar')->nullable(); // General description in Arabic

        // Page Titles and Descriptions
        $table->text('why_us_page_title_en')->nullable(); // Title for the page in English
        $table->text('why_us_page_title_ar')->nullable(); // Title for the page in Arabic
        $table->text('why_us_page_description_en')->nullable(); // Description for the page in English
        $table->text('why_us_page_description_ar')->nullable(); // Description for the page in Arabic

        // Images for this "Why Us" page (can be an array of images)
        $table->json('why_us_page_images')->nullable(); // JSON field to store image paths (e.g., array of paths)
$table->foreignId('about_us_id')->nullable()->constrained('about_us')->onDelete('cascade');
        $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('why_us');
    }
};
