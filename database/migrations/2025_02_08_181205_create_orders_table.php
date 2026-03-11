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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->foreignId('send_to')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->cascadeOnDelete();
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->cascadeOnDelete();
            $table->foreignId('manager_id')->nullable()->constrained('branch_managers')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->cascadeOnDelete();
            $table->double('points')->default(0);
            $table->double('total');
            $table->double('discount')->default(0);
            $table->double('tax')->default(0);
            $table->double('grand_total');
            $table->double('visa')->default(0);
            $table->double('wallet')->default(0);
            $table->string('status')->default('pending');
            $table->enum('type', ['order', 'gift', 'point'])->default('order');
            $table->string('payment_method')->default('cash');
            $table->string('payment_status')->default('pending');
            $table->string('payment_id')->nullable();
            $table->longText('note')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->enum('place', ['car', 'branch'])->default('branch');
            $table->enum('created_by', ['customer', 'admin'])->default('customer');
            $table->string('title')->nullable();
            $table->longText('message')->nullable();
            $table->string('expire_date')->nullable();
            $table->longText('car_details')->nullable();
            $table->text('qr')->nullable();
            $table->boolean('received')->default(false);
            $table->string('received_at')->nullable();
            $table->softDeletes();
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
};