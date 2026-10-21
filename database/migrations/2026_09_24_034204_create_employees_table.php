<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('nopeg', 50)
                ->unique();

            $table->string('nama');

            $table->string('foto')
                ->nullable();

            $table->string('jabatan');

            $table->string('sub_bagian');

            $table->text('alamat')
                ->nullable();

            $table->string('no_hp', 20)
                ->nullable();

            $table->string('email')
                ->nullable();

            $table->string('people_once_url', 500)
                ->nullable();

            $table->timestamps();

            $table->index('nama');
            $table->index('jabatan');
            $table->index('sub_bagian');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};