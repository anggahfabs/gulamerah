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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('company_name')->nullable();
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->string('inquiry_type')->default('B2B Pasokan Rutin'); // B2B Pasokan Rutin, Maklon / Private Label, Permintaan Sample, Pertanyaan Umum
            $table->string('product_interest')->nullable();
            $table->string('estimated_volume')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('baru'); // baru, diproses, selesai, arsip
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
