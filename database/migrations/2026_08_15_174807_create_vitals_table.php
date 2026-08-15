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
        Schema::create('vitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->onDelete('cascade');
            $table->decimal('weight', 5, 3)->nullable();
            $table->decimal('height', 5, 2)->nullable(); 
            $table->decimal('bmi', 5, 2)->nullable(); 
            $table->integer('systolic_bp')->nullable(); 
            $table->integer('diastolic_bp')->nullable(); 
            $table->decimal('temperature', 4, 1)->nullable(); 
            $table->integer('pulse_rate')->nullable(); 
            $table->integer('respiratory_rate')->nullable(); 
            $table->decimal('blood_sugar', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('consultation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vitals');
    }
};
