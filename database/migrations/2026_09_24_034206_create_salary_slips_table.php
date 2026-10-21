<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_slips', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnDelete();

            $table->string('periode', 100);

            $table->string('original_file');

            $table->string('watermarked_file')
                ->nullable();

            $table->timestamp('sent_at')
                ->nullable();

            $table->enum('status', [
                'pending',
                'processing',
                'sent',
                'failed',
            ])->default('pending');

            $table->timestamps();

            $table->index('employee_id');

            $table->index('periode');

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_slips');
    }
};