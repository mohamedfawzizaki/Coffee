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
        Schema::table('foodics', function (Blueprint $table) {

            $table->longText('qr')->nullable();
            $table->boolean('received')->default(false);
            $table->string('received_at')->nullable();
            $table->string('received_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foodics', function (Blueprint $table) {
            $table->dropColumn('qr');
            $table->dropColumn('received');
            $table->dropColumn('received_at');
            $table->dropColumn('received_by');
        });
    }
};
