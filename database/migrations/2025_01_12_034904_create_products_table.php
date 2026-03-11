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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('p_categories')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);
            $table->double('price')->default(0);
            $table->double('points')->default(0);
            $table->enum('price_type', ['static', 'sizes'])->default('static');
            $table->boolean('can_replace')->default(false);
            $table->integer('sort')->default(5000);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
