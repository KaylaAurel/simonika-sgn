<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnDelete();

            $table->string('nama_pelatihan');

            $table->string('penyelenggara')
                ->nullable();

            $table->date('tanggal')
                ->nullable();

            $table->text('keterangan')
                ->nullable();

            $table->timestamps();

            $table->index('employee_id');

            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};