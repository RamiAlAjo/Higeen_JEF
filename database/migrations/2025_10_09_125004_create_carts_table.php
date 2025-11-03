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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            // For authenticated clients (change from user_id to client_id)
            $table->foreignId('client_id')->nullable()
                ->constrained('clients')  // references clients table now
                ->onDelete('cascade');

            // For guests (session or cookie-based)
            $table->string('guest_token')->nullable()->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
