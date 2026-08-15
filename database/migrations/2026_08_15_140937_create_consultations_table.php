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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            //constrained is a PHP feature that uses the foreign id parameter to try and relate it to the table. In the doctor's section, we have used users as a parameter in 
            //constrained. This is because we do not have a table doctors, so we tell it to relate it to the users table.
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('consultation_date');
            $table->text('symptoms')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('clinical_notes')->nullable();
            $table->text('treatment_plan')->nullable();
            $table->text('advice')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index('patient_id', 'consultation_date');
            $table->index('doctor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
