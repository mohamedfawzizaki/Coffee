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
        Schema::create('gift_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->foreignId('send_to')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->foreignId('manager_id')->nullable()->constrained('branch_managers')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->cascadeOnDelete();
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->cascadeOnDelete();
            $table->enum('created_by', ['customer', 'admin'])->default('customer');
            $table->double('points')->default(0);
            $table->double('total');
            $table->double('discount')->default(0);
            $table->double('tax')->default(0);
            $table->double('grand_total');
            $table->double('visa')->default(0);
            $table->double('wallet')->default(0);
            $table->string('status')->default('pending');
            $table->string('payment_method')->default('cash');
            $table->string('payment_status')->default('pending');
            $table->string('payment_id')->nullable();
            $table->longText('note')->nullable();
            $table->string('title')->nullable();
            $table->longText('message')->nullable();
            $table->string('expire_date')->nullable();
            $table->boolean('received')->default(false);
            $table->string('received_at')->nullable();
            $table->string('qr')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_orders');
    }
};
