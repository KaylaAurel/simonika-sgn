<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Training extends Model
{
    /**
     * Kolom yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'employee_id',
        'nama_pelatihan',
        'penyelenggara',
        'tanggal',
        'keterangan',
    ];

    /**
     * Konversi tipe data.
     */
    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Relasi ke karyawan.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}