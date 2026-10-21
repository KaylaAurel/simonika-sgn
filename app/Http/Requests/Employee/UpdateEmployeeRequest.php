<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Menentukan apakah request diizinkan.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi.
     */
    public function rules(): array
    {
        $employee = $this->route('employee');

        return [

            /*
            |--------------------------------------------------------------------------
            | NOMOR PEGAWAI
            |--------------------------------------------------------------------------
            */

            'nopeg' => [
                'required',
                'string',
                'max:50',
                Rule::unique('employees', 'nopeg')
                    ->ignore($employee->id),
            ],

            /*
            |--------------------------------------------------------------------------
            | DATA UTAMA
            |--------------------------------------------------------------------------
            */

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'required',
                'string',
                'max:255',
            ],

            'sub_bagian' => [
                'required',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | KONTAK
            |--------------------------------------------------------------------------
            */

            'alamat' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'no_hp' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | FOTO
            |--------------------------------------------------------------------------
            */

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            /*
            |--------------------------------------------------------------------------
            | PEOPLE ONCE
            |--------------------------------------------------------------------------
            */

            'people_once_url' => [
                'nullable',
                'url',
                'max:500',
            ],

        ];
    }

    /**
     * Pesan validasi.
     */
    public function messages(): array
    {
        return [

            'nopeg.required' =>
                'Nomor pegawai wajib diisi.',

            'nopeg.unique' =>
                'Nomor pegawai tersebut sudah digunakan oleh karyawan lain.',

            'nama.required' =>
                'Nama lengkap wajib diisi.',

            'jabatan.required' =>
                'Jabatan wajib diisi.',

            'sub_bagian.required' =>
                'Sub bagian wajib diisi.',

            'alamat.max' =>
                'Alamat maksimal 1000 karakter.',

            'no_hp.max' =>
                'Nomor HP maksimal 30 karakter.',

            'email.email' =>
                'Format email tidak valid.',

            'foto.image' =>
                'File yang diupload harus berupa gambar.',

            'foto.mimes' =>
                'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',

            'foto.max' =>
                'Ukuran foto maksimal 2 MB.',

            'people_once_url.url' =>
                'Format link People Once tidak valid.',

        ];
    }
}