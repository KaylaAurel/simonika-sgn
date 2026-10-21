<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'nopeg',
        'nama',
        'foto',
        'jabatan',
        'sub_bagian',
        'alamat',
        'no_hp',
        'email',
        'people_once_url',
    ];

    /**
     * Dokumen karyawan:
     * SK, cuti, pensiun.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    /**
     * Data pelatihan karyawan.
     */
    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class);
    }

    /**
     * Data penghargaan / PMP karyawan.
     */
    public function awards(): HasMany
    {
        return $this->hasMany(Award::class);
    }

    /**
     * Slip gaji karyawan.
     */
    public function salarySlips(): HasMany
    {
        return $this->hasMany(SalarySlip::class);
    }

    /**
     * Mengambil dokumen berdasarkan tipe.
     */
    public function documentsByType(string $type)
    {
        return $this->documents()
            ->where('type', $type)
            ->get();
    }

    /**
     * Mendapatkan nama foto atau foto default.
     */
    public function getPhotoUrlAttribute(): string
    {
        if (!$this->foto) {
            return asset('images/default-avatar.png');
        }

        return route('public.employee.photo', $this->id);
    }
}