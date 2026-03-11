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
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('wallet_order_id')->nullable()->constrained('wallet_orders')->cascadeOnDelete();
            $table->double('wallet_amount')->default(0);
            $table->double('visa_amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['wallet_order_id']);
            $table->dropColumn('wallet_order_id');
            $table->dropColumn('wallet_amount');
            $table->dropColumn('visa_amount');
        });
    }
};
