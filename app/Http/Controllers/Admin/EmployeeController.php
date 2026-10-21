<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR KARYAWAN
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Employee::query();

        /*
        |--------------------------------------------------------------------------
        | PENCARIAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->input('search');

            $query->where(function ($q) use ($search) {

                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nopeg', 'like', '%' . $search . '%')
                    ->orWhere('jabatan', 'like', '%' . $search . '%')
                    ->orWhere('sub_bagian', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%');

            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER JABATAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('jabatan')) {

            $query->where(
                'jabatan',
                $request->input('jabatan')
            );

        }

        /*
        |--------------------------------------------------------------------------
        | FILTER SUB BAGIAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('sub_bagian')) {

            $query->where(
                'sub_bagian',
                $request->input('sub_bagian')
            );

        }

        /*
        |--------------------------------------------------------------------------
        | DATA KARYAWAN
        |--------------------------------------------------------------------------
        */

        $employees = $query
            ->orderBy('nama', 'asc')
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK FILTER
        |--------------------------------------------------------------------------
        */

        $jabatans = Employee::query()
            ->whereNotNull('jabatan')
            ->where('jabatan', '!=', '')
            ->select('jabatan')
            ->distinct()
            ->orderBy('jabatan')
            ->pluck('jabatan');

        $subBagians = Employee::query()
            ->whereNotNull('sub_bagian')
            ->where('sub_bagian', '!=', '')
            ->select('sub_bagian')
            ->distinct()
            ->orderBy('sub_bagian')
            ->pluck('sub_bagian');

        return view(
            'admin.employees.index',
            [
                'employees' => $employees,
                'jabatans' => $jabatans,
                'subBagians' => $subBagians,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH KARYAWAN
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.employees.create');
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN KARYAWAN
    |--------------------------------------------------------------------------
    */

    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | UPLOAD FOTO
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto')) {

            $data['foto'] = $request
                ->file('foto')
                ->store(
                    'employees/photos',
                    'local'
                );
        }

        Employee::create($data);

        return redirect()
            ->route('admin.employees.index')
            ->with(
                'success',
                'Data karyawan berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL KARYAWAN
    |--------------------------------------------------------------------------
    */

    public function show(Employee $employee)
    {
        $employee->load([
            'documents',
            'trainings',
            'awards',
            'salarySlips',
        ]);

        return view(
            'admin.employees.show',
            [
                'employee' => $employee,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM EDIT KARYAWAN
    |--------------------------------------------------------------------------
    */

    public function edit(Employee $employee)
    {
        return view(
            'admin.employees.edit',
            [
                'employee' => $employee,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE KARYAWAN
    |--------------------------------------------------------------------------
    */

    public function update(
        UpdateEmployeeRequest $request,
        Employee $employee
    ) {
        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | UPLOAD FOTO BARU
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto')) {

            /*
            Hapus foto lama jika ada.
            */

            if (
                $employee->foto &&
                Storage::disk('local')->exists(
                    $employee->foto
                )
            ) {

                Storage::disk('local')->delete(
                    $employee->foto
                );
            }

            $data['foto'] = $request
                ->file('foto')
                ->store(
                    'employees/photos',
                    'local'
                );
        }

        $employee->update($data);

        return redirect()
            ->route(
                'admin.employees.index'
            )
            ->with(
                'success',
                'Data karyawan berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS KARYAWAN
    |--------------------------------------------------------------------------
    */

    public function destroy(Employee $employee)
    {
        /*
        |--------------------------------------------------------------------------
        | HAPUS FOTO
        |--------------------------------------------------------------------------
        */

        if (
            $employee->foto &&
            Storage::disk('local')->exists(
                $employee->foto
            )
        ) {

            Storage::disk('local')->delete(
                $employee->foto
            );
        }

        $employee->delete();

        return redirect()
            ->route(
                'admin.employees.index'
            )
            ->with(
                'success',
                'Data karyawan berhasil dihapus.'
            );
    }
}