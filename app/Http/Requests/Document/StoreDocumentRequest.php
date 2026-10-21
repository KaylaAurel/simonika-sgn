<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => [
                'required',
                'exists:employees,id',
            ],

            'type' => [
                'required',
                'in:sk,cuti,pensiun',
            ],

            'file' => [
                'required',
                'file',
                'mimes:pdf',
                'max:10240',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' =>
                'Karyawan wajib dipilih.',

            'employee_id.exists' =>
                'Data karyawan tidak ditemukan.',

            'type.required' =>
                'Jenis dokumen wajib dipilih.',

            'type.in' =>
                'Jenis dokumen tidak valid.',

            'file.required' =>
                'File dokumen wajib diupload.',

            'file.file' =>
                'File yang diupload tidak valid.',

            'file.mimes' =>
                'Dokumen harus berformat PDF.',

            'file.max' =>
                'Ukuran dokumen maksimal 10 MB.',
        ];
    }
}