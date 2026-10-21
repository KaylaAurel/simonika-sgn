<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('salary_slips', function (Blueprint $table) {

            if (!Schema::hasColumn('salary_slips', 'original_name')) {
                $table->string('original_name')->nullable()->after('periode');
            }

            if (!Schema::hasColumn('salary_slips', 'file_path')) {
                $table->string('file_path')->nullable()->after('original_name');
            }

            if (!Schema::hasColumn('salary_slips', 'watermarked_path')) {
                $table->string('watermarked_path')->nullable()->after('file_path');
            }

            if (!Schema::hasColumn('salary_slips', 'status')) {
                $table->string('status')->default('pending')->after('watermarked_path');
            }

            if (!Schema::hasColumn('salary_slips', 'sent_at')) {
                $table->timestamp('sent_at')->nullable()->after('status');
            }

        });
    }

    public function down(): void
    {
        Schema::table('salary_slips', function (Blueprint $table) {

            $columns = [];

            foreach ([
                'original_name',
                'file_path',
                'watermarked_path',
                'status',
                'sent_at'
            ] as $column) {

                if (Schema::hasColumn('salary_slips', $column)) {
                    $columns[] = $column;
                }

            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }

        });
    }
};