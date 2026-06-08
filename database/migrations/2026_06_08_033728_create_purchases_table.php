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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_type', 50);
            $table->string('voucher_number', 50);
            $table->string('referral_guide_number', 50)->nullable();
            $table->decimal('total', 10, 2);
            $table->foreignId('supplier_id')->constrained('suppliers')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
