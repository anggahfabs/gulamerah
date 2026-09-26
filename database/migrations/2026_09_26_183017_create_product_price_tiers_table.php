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
        Schema::create('product_price_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('min_quantity_kg', 10, 2); // e.g. 100.00
            $table->decimal('max_quantity_kg', 10, 2)->nullable(); // e.g. 500.00, or null for >2000kg
            $table->decimal('price_per_kg', 12, 2); // e.g. 24000
            $table->string('note')->nullable(); // e.g. "Termasuk karung inner PE & pallet"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_price_tiers');
    }
};
