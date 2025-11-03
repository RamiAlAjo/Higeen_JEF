<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('page')->index(); // e.g., 'about', 'home' - to differentiate per page
            $table->text('title_en')->nullable();
            $table->text('title_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('button_text_en')->nullable(); // e.g., 'Shop Now'
            $table->string('button_text_ar')->nullable();
            $table->string('button_link')->nullable(); // URL for button
            $table->string('image')->nullable(); // Path to hero image
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hero_sections');
    }
};
