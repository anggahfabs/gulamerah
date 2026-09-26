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
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('raw_material')->default('Aren'); // Aren, Kelapa, Tebu
            $table->string('product_form')->default('Semut'); // Semut, Cetak, Cair
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->string('moisture_content')->nullable(); // e.g. "≤ 1.5%"
            $table->string('mesh_size')->nullable(); // e.g. "Mesh 16 - 18"
            $table->string('brix_content')->nullable(); // e.g. "75° Brix"
            $table->string('shelf_life')->nullable(); // e.g. "24 Bulan"
            $table->text('storage_instruction')->nullable();
            $table->text('recommendations')->nullable(); // Industri biskuit, coffee shop, etc.
            $table->string('thumbnail')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
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
