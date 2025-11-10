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
        Schema::create('website_settings', function (Blueprint $table) {
             $table->id();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('title')->nullable();
            $table->mediumText('website_description')->nullable();
            $table->string('key_words')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('logo')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('carrers_email')->nullable();
            $table->string('url')->nullable();
            $table->string('location', 500)->nullable();
            $table->json('locations')->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
