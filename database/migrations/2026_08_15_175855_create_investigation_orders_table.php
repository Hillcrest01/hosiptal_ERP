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
        Schema::create('investigation_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->onDelete('cascade');
            $table->string('investigation_name');
            $table->enum('type', ['pathology', 'radiology', 'other'])->default('pathology');
            $table->text('instructions')->nullable();
            $table->enum('status', ['ordered', 'in_progress', 'completed', 'cancelled'])->default('ordered');
            $table->text('results')->nullable();
            $table->datetime('result_entered_at')->nullable();
            $table->foreignId('result_entered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['consultation_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investigation_orders');
    }
};
