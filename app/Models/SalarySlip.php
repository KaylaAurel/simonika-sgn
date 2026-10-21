<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarySlip extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'employee_id',

        'periode',

        'original_name',

        'file_path',

        'watermarked_path',

        'status',

        'sent_at',

    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'sent_at' => 'datetime',

    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function employee()
    {
        return $this->belongsTo(
            Employee::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS NAME
    |--------------------------------------------------------------------------
    |
    | Status database:
    |
    | pending
    | processing
    | ready
    | sent
    | failed
    |
    */

    public function getStatusNameAttribute(): string
    {
        return match ($this->status) {

            'pending' => 'Menunggu',

            'processing' => 'Memproses',

            'ready' => 'Siap Dikirim',

            'sent' => 'Terkirim',

            'failed' => 'Gagal',

            default => 'Belum Diproses',

        };
    }
}