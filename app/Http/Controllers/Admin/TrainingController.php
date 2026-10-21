<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR PELATIHAN
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Training::with('employee');

        /*
        |--------------------------------------------------------------------------
        | PENCARIAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->input('search');

            $query->whereHas('employee', function ($q) use ($search) {

                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nopeg', 'like', '%' . $search . '%');

            });
        }


        /*
        |--------------------------------------------------------------------------
        | URUTKAN DATA
        |--------------------------------------------------------------------------
        */

        $trainings = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN DATA
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.trainings.index',
            [
                'trainings' => $trainings,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH PELATIHAN
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil semua karyawan
        |--------------------------------------------------------------------------
        */

        $employees = Employee::query()
            ->orderBy('nama', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Kirim data karyawan ke Blade
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.trainings.create',
            [
                'employees' => $employees,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN PELATIHAN
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'employee_id' => [
                'required',
                'exists:employees,id',
            ],

            'nama_pelatihan' => [
                'required',
                'string',
                'max:255',
            ],

            'penyelenggara' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tanggal' => [
                'nullable',
                'date',
            ],

            'lokasi' => [
                'nullable',
                'string',
                'max:255',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

        ], [

            'employee_id.required' =>
                'Karyawan wajib dipilih.',

            'employee_id.exists' =>
                'Data karyawan tidak ditemukan.',

            'nama_pelatihan.required' =>
                'Nama pelatihan wajib diisi.',

            'nama_pelatihan.max' =>
                'Nama pelatihan maksimal 255 karakter.',

            'tanggal.date' =>
                'Format tanggal pelatihan tidak valid.',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Simpan ke database
        |--------------------------------------------------------------------------
        */

        Training::create($validated);


        return redirect()
            ->route('admin.trainings.index')
            ->with(
                'success',
                'Data pelatihan berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL PELATIHAN
    |--------------------------------------------------------------------------
    */

    public function show(Training $training)
    {
        $training->load('employee');

        return view(
            'admin.trainings.show',
            [
                'training' => $training,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Training $training)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil semua karyawan
        |--------------------------------------------------------------------------
        */

        $employees = Employee::query()
            ->orderBy('nama', 'asc')
            ->get();


        return view(
            'admin.trainings.edit',
            [
                'training' => $training,
                'employees' => $employees,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PELATIHAN
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Training $training
    ) {

        $validated = $request->validate([

            'employee_id' => [
                'required',
                'exists:employees,id',
            ],

            'nama_pelatihan' => [
                'required',
                'string',
                'max:255',
            ],

            'penyelenggara' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tanggal' => [
                'nullable',
                'date',
            ],

            'lokasi' => [
                'nullable',
                'string',
                'max:255',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

        ], [

            'employee_id.required' =>
                'Karyawan wajib dipilih.',

            'employee_id.exists' =>
                'Data karyawan tidak ditemukan.',

            'nama_pelatihan.required' =>
                'Nama pelatihan wajib diisi.',

            'tanggal.date' =>
                'Format tanggal pelatihan tidak valid.',

        ]);


        $training->update($validated);


        return redirect()
            ->route('admin.trainings.index')
            ->with(
                'success',
                'Data pelatihan berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS PELATIHAN
    |--------------------------------------------------------------------------
    */

    public function destroy(Training $training)
    {
        $training->delete();

        return redirect()
            ->route('admin.trainings.index')
            ->with(
                'success',
                'Data pelatihan berhasil dihapus.'
            );
    }
}