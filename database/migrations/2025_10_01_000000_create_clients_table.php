<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('clients', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');

    // Additional fields
    $table->string('phone_number')->nullable();
    $table->string('shipping_address')->nullable();
    $table->string('billing_address')->nullable();
    $table->string('preferred_payment_method')->nullable();
    $table->string('area')->nullable();

    $table->enum('gender', ['male', 'female'])->nullable();
    $table->date('date_of_birth')->nullable();
    $table->string('avatar')->nullable();

    $table->rememberToken();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
