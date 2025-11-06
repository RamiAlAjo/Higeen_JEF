<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('cart_id')
                  ->nullable()
                  ->constrained('carts')
                  ->onDelete('set null');

            $table->foreignId('client_id')
                  ->nullable()
                  ->constrained('clients')
                  ->onDelete('set null');

            // Shipping info
            $table->string('full_name');
            $table->string('email');
            $table->string('phone_number');
            $table->text('shipping_address');

            // **Temporary string column – will be dropped later**
            $table->string('shipping_area')->nullable();

            // Pricing
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('total', 10, 2);

            // Statuses
            $table->enum('status', ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'])
                  ->default('pending');

            $table->enum('payment_method', [
                'cod', 'card', 'paypal', 'stripe', 'bank_transfer',
                'apple_pay', 'google_pay', 'wallet', 'klarna', 'cash'
            ])->default('cod');

            $table->enum('payment_status', ['unpaid', 'paid', 'failed', 'refunded'])
                  ->default('unpaid');

            $table->enum('delivery_status', [
                'not_started', 'in_progress', 'delivered', 'cancelled', 'failed'
            ])->default('not_started');

            $table->timestamps();
        });

        // -----------------------------------------------------------------
        // Add the foreign-key column **after** the table exists
        // -----------------------------------------------------------------
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('shipping_area_id')
                  ->after('phone_number')
                  ->nullable()
                  ->constrained('shipping_areas')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};