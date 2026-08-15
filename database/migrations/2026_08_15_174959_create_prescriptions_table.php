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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->onDelete('cascade');
            $table->foreignId('drug_id')->nullable()->constrained('drugs')->nullOnDelete();
            $table->string('drug_name'); 
            $table->string('dosage');
            $table->string('frequency');
            $table->string('duration');
            $table->text('instructions')->nullable();
            $table->boolean('is_emergency')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('consultation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
