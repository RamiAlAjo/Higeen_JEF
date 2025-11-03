<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('cover_image'); // Path to the cover image

            // New multilingual fields
            $table->string('album_name_en')->nullable();
            $table->string('album_name_ar')->nullable();
            $table->text('album_description_en')->nullable();
            $table->text('album_description_ar')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('albums');
    }
}
