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
            $table->foreignId('cart_id')->nullable()->constrained('carts')->onDelete('set null');
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null');

            // Customer & Shipping
            $table->string('full_name');
            $table->string('email');
            $table->string('phone_number');

            // THIS LINE IS NOW SAFE – no ->after()!
            $table->foreignId('shipping_area_id')->nullable()->constrained('shipping_areas')->onDelete('set null');

            $table->text('shipping_address');

            // Legacy fallback (can be removed later)
            $table->string('shipping_area')->nullable();

            // Pricing
            $table->decimal('subtotal', 12, 4);
            $table->decimal('shipping_cost', 10, 4)->default(0);
            $table->decimal('discount', 10, 4)->default(0);
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('total', 12, 4);

            // Statuses
            $table->enum('status', ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'])
                  ->default('pending')
                  ->index();

            $table->enum('payment_method', [
                'cod', 'card', 'paypal', 'stripe', 'bank_transfer',
                'apple_pay', 'google_pay', 'wallet', 'klarna', 'cash'
            ])->default('cod');

            $table->enum('payment_status', ['unpaid', 'paid', 'failed', 'refunded'])
                  ->default('unpaid')
                  ->index();

            $table->enum('delivery_status', [
                'not_started', 'in_progress', 'delivered', 'cancelled', 'failed'
            ])->default('not_started')
              ->index();

            // Hesabate Sync
            $table->timestamp('hesabate_sent_at')->nullable()->index();
            $table->boolean('hesabate_synced')->default(false)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
