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
        Schema::create('divine_angel_jobs', function (Blueprint $table) {
            $table->id();
            $table->date('job_date');
            $table->text('description');
            $table->string('status', 20)->default('pendiente');
            $table->json('photos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divine_angel_jobs');
    }
};
