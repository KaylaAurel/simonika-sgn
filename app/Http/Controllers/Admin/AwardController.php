<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\Employee;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR PENGHARGAAN
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Award::with('employee');

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

        $awards = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN DATA
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.awards.index',
            [
                'awards' => $awards,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH PENGHARGAAN
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
            'admin.awards.create',
            [
                'employees' => $employees,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN PENGHARGAAN
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'employee_id' => [
                'required',
                'exists:employees,id',
            ],

            'nama_penghargaan' => [
                'required',
                'string',
                'max:255',
            ],

            'tahun' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . (date('Y') + 1),
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

            'nama_penghargaan.required' =>
                'Nama penghargaan wajib diisi.',

            'nama_penghargaan.max' =>
                'Nama penghargaan maksimal 255 karakter.',

            'tahun.integer' =>
                'Tahun harus berupa angka.',

            'tahun.min' =>
                'Tahun penghargaan tidak valid.',

            'tahun.max' =>
                'Tahun penghargaan tidak boleh melebihi ' . (date('Y') + 1) . '.',

        ]);


        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE DATABASE
        |--------------------------------------------------------------------------
        */

        Award::create($validated);


        return redirect()
            ->route('admin.awards.index')
            ->with(
                'success',
                'Data penghargaan berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL PENGHARGAAN
    |--------------------------------------------------------------------------
    */

    public function show(Award $award)
    {
        $award->load('employee');

        return view(
            'admin.awards.show',
            [
                'award' => $award,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Award $award)
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
        | Load data karyawan penghargaan
        |--------------------------------------------------------------------------
        */

        $award->load('employee');

        return view(
            'admin.awards.edit',
            [
                'award' => $award,
                'employees' => $employees,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PENGHARGAAN
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Award $award
    ) {

        $validated = $request->validate([

            'employee_id' => [
                'required',
                'exists:employees,id',
            ],

            'nama_penghargaan' => [
                'required',
                'string',
                'max:255',
            ],

            'tahun' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . (date('Y') + 1),
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

            'nama_penghargaan.required' =>
                'Nama penghargaan wajib diisi.',

            'nama_penghargaan.max' =>
                'Nama penghargaan maksimal 255 karakter.',

            'tahun.integer' =>
                'Tahun harus berupa angka.',

            'tahun.min' =>
                'Tahun penghargaan tidak valid.',

            'tahun.max' =>
                'Tahun penghargaan tidak boleh melebihi ' . (date('Y') + 1) . '.',

        ]);


        /*
        |--------------------------------------------------------------------------
        | UPDATE DATABASE
        |--------------------------------------------------------------------------
        */

        $award->update($validated);


        return redirect()
            ->route('admin.awards.index')
            ->with(
                'success',
                'Data penghargaan berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS PENGHARGAAN
    |--------------------------------------------------------------------------
    */

    public function destroy(Award $award)
    {
        $award->delete();

        return redirect()
            ->route('admin.awards.index')
            ->with(
                'success',
                'Data penghargaan berhasil dihapus.'
            );
    }
}