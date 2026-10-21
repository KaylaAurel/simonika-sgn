<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'type',
        'file_path',
        'original_name',
    ];

    /**
     * Dokumen milik satu karyawan.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Nama tipe dokumen yang lebih mudah dibaca.
     */
    public function getTypeNameAttribute(): string
    {
        return match ($this->type) {
            'sk' => 'SK',
            'cuti' => 'Cuti',
            'pensiun' => 'Pensiun',
            default => ucfirst($this->type),
        };
    }
}