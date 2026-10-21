<?php

namespace App\Http\Requests\SalarySlip;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalarySlipRequest extends FormRequest
{
    /**
     * Menentukan apakah user boleh mengunggah slip gaji.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Aturan validasi slip gaji.
     */
    public function rules(): array
    {
        return [
            'employee_id' => [
                'required',
                'integer',
                'exists:employees,id',
            ],

            'periode' => [
                'required',
                'string',
                'max:100',
            ],

            'file' => [
                'required',
                'file',
                'mimes:pdf',
                'max:10240',
            ],
        ];
    }

    /**
     * Pesan validasi.
     */
    public function messages(): array
    {
        return [
            'employee_id.required' => 'Karyawan wajib dipilih.',
            'employee_id.exists' => 'Data karyawan tidak ditemukan.',

            'periode.required' => 'Periode slip gaji wajib diisi.',

            'file.required' => 'File slip gaji wajib diunggah.',
            'file.file' => 'File slip gaji tidak valid.',
            'file.mimes' => 'Slip gaji harus berformat PDF.',
            'file.max' => 'Ukuran slip gaji maksimal 10 MB.',
        ];
    }
}