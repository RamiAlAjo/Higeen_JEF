<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Optional link to cart
            $table->foreignId('cart_id')
                ->nullable()
                ->constrained('carts')
                ->onDelete('set null');

            // Optional link to client
            $table->foreignId('client_id')
                ->nullable()
                ->constrained('clients')
                ->onDelete('set null');

            // Guest or user shipping info
            $table->string('full_name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('shipping_area')->nullable(); // e.g. Amman, Salt, Irbid
            $table->text('shipping_address');

            // Pricing
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->string('discount_type')->nullable(); // e.g. promo, seasonal
            $table->decimal('total', 10, 2);

            // Order status
            $table->enum('status', [
                'pending',
                'confirmed',
                'shipped',
                'delivered',
                'cancelled'
            ])->default('pending');

            // Payment method
            $table->enum('payment_method', [
                'cod',          // cash on delivery
                'card',         // generic card
                'paypal',
                'stripe',
                'bank_transfer',
                'apple_pay',
                'google_pay',
                'wallet',
                'klarna',
                'cash'          // in-store
            ])->default('cod');

            // Payment status
            $table->enum('payment_status', [
                'unpaid',
                'paid',
                'failed',
                'refunded'
                // intentionally excluding 'pending'
            ])->default('unpaid');

            // Delivery tracking
            $table->enum('delivery_status', [
                'not_started',
                'in_progress',
                'delivered',
                'cancelled',
                'failed'
            ])->default('not_started');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
