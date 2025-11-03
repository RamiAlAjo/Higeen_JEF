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
     Schema::create('about_us', function (Blueprint $table) {
     $table->id(); // Primary key

        // About Us Titles and Descriptions
        $table->text('about_us_title_en')->nullable(); // English title
        $table->text('about_us_title_ar')->nullable(); // Arabic title
        $table->text('about_us_description_en')->nullable(); // English description
        $table->text('about_us_description_ar')->nullable(); // Arabic description

        // Features (optional section for key points or features of the company)
        $table->text('features_en')->nullable(); // Features in English
        $table->text('features_ar')->nullable(); // Features in Arabic

        // Image for the About Us section (main image)
        $table->string('about_main_image')->nullable(); // Path to main image

        // Slider Section (optional for carousel-style images with titles)
        $table->text('slider_title_en')->nullable(); // Slider title in English
        $table->text('slider_title_ar')->nullable(); // Slider title in Arabic
        $table->text('slider_description_en')->nullable(); // Slider description in English
        $table->text('slider_description_ar')->nullable(); // Slider description in Arabic
        $table->string('slider_icon')->nullable(); // Icon or image for slider

        $table->timestamps(); // Created and updated timestamps
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
