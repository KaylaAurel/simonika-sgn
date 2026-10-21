<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Tentukan apakah user boleh melakukan request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi data karyawan.
     */
    public function rules(): array
    {
        return [

            'nopeg' => [
                'required',
                'string',
                'max:50',
                'unique:employees,nopeg',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
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

            'people_once_url' => [
                'nullable',
                'url',
                'max:500',
            ],

        ];
    }

    /**
     * Pesan validasi custom.
     */
    public function messages(): array
    {
        return [

            'nopeg.required' =>
                'Nomor pegawai wajib diisi.',

            'nopeg.unique' =>
                'Nomor pegawai tersebut sudah terdaftar.',

            'nama.required' =>
                'Nama lengkap wajib diisi.',

            'jabatan.required' =>
                'Jabatan wajib diisi.',

            'sub_bagian.required' =>
                'Sub bagian wajib diisi.',

            'foto.image' =>
                'File foto harus berupa gambar.',

            'foto.mimes' =>
                'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',

            'foto.max' =>
                'Ukuran foto maksimal 2 MB.',

            'email.email' =>
                'Format email tidak valid.',

            'people_once_url.url' =>
                'Format link People Once tidak valid.',

        ];
    }
}