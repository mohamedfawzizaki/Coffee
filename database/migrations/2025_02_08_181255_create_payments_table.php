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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->string('type')->default('product');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->longText('payment_data')->nullable();
            $table->string('payment_order_id')->nullable();
            $table->string('payment_transaction_id')->nullable();
            $table->string('payment_method')->nullable();

            $table->string('place')->nullable();
            $table->string('note')->nullable();
            $table->string('message')->nullable();
            $table->string('car_details')->nullable();
            $table->unsignedBigInteger('receiver_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
