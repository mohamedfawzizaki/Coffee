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
        Schema::table('worktimes', function (Blueprint $table) {
            $table->boolean('status')->default(true)->after('all_day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('worktimes', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
