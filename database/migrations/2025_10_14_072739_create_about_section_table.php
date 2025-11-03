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
        Schema::create('about_section', function (Blueprint $table) {
            $table->id();
            $table->string('heading_en');
            $table->string('heading_ar');
            $table->string('subtitle_en')->nullable();
            $table->string('subtitle_ar')->nullable();
            $table->string('highlight_word_en')->nullable();
            $table->string('highlight_word_ar')->nullable();
            $table->text('paragraph_en')->nullable();
            $table->text('paragraph_ar')->nullable();
            $table->string('main_image')->nullable();
            $table->string('main_image_alt')->nullable();
            $table->string('small_image')->nullable();
            $table->string('small_image_alt')->nullable();
            $table->string('icon_image')->nullable(); // Replaced icon_class
            $table->string('label_en')->nullable(); // Made nullable
            $table->string('label_ar')->nullable();
            $table->string('description_en')->nullable(); // Made nullable
            $table->string('description_ar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_section');
    }
};
