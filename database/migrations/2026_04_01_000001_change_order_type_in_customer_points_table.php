<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Change order_type from default('order') to a plain string so it can
     * hold 'foodics' (and any future sources) without an enum modification.
     */
    public function up(): void
    {
        Schema::table('customer_points', function (Blueprint $table) {
            // Change from string with limited default to open-ended string
            $table->string('order_type')->default('order')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_points', function (Blueprint $table) {
            $table->string('order_type')->default('order')->change();
        });
    }
};
