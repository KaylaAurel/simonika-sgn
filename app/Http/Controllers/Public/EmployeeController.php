<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeDocument;
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
        /*
        |--------------------------------------------------------------------------
        | QUERY DASAR
        |--------------------------------------------------------------------------
        */

        $query = Employee::query();


        /*
        |--------------------------------------------------------------------------
        | PENCARIAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->input('search');

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'nopeg',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'jabatan',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'sub_bagian',
                    'like',
                    '%' . $search . '%'
                );

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
        | AMBIL DATA KARYAWAN
        |--------------------------------------------------------------------------
        */

        $employees = $query
            ->orderBy('nama', 'asc')
            ->paginate(12)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | DATA JABATAN
        |--------------------------------------------------------------------------
        */

        $jabatans = Employee::query()
            ->whereNotNull('jabatan')
            ->where('jabatan', '!=', '')
            ->select('jabatan')
            ->distinct()
            ->orderBy('jabatan')
            ->pluck('jabatan');


        /*
        |--------------------------------------------------------------------------
        | DATA SUB BAGIAN
        |--------------------------------------------------------------------------
        */

        $subBagians = Employee::query()
            ->whereNotNull('sub_bagian')
            ->where('sub_bagian', '!=', '')
            ->select('sub_bagian')
            ->distinct()
            ->orderBy('sub_bagian')
            ->pluck('sub_bagian');


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'public.employees.index',
            [
                'employees' => $employees,
                'jabatans' => $jabatans,
                'subBagians' => $subBagians,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL KARYAWAN
    |--------------------------------------------------------------------------
    */

    public function show(Employee $employee)
    {
        /*
        |--------------------------------------------------------------------------
        | DATA YANG BOLEH DITAMPILKAN PUBLIK
        |--------------------------------------------------------------------------
        |
        | Kita hanya load data yang memang diperlukan.
        |
        */

        $employee->load([
            'documents',
            'trainings',
            'awards',
        ]);

        return view(
            'public.employees.show',
            [
                'employee' => $employee,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FOTO KARYAWAN
    |--------------------------------------------------------------------------
    */

    public function photo(Employee $employee)
    {
        /*
        Tidak ada foto.
        */

        if (!$employee->foto) {
            abort(404);
        }


        $path = $employee->foto;


        /*
        Cek file di storage private.
        */

        if (
            !Storage::disk('local')->exists($path)
        ) {
            abort(404);
        }


        /*
        Tampilkan foto melalui controller.
        */

        return response()->file(
            Storage::disk('local')->path($path)
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DOKUMEN KARYAWAN
    |--------------------------------------------------------------------------
    */

    public function document(
        EmployeeDocument $document
    ) {
        /*
        Ambil relasi karyawan.
        */

        $document->load('employee');


        /*
        Pastikan file tersedia.
        */

        if (
            !Storage::disk('local')->exists(
                $document->file_path
            )
        ) {
            abort(404);
        }


        /*
        Tampilkan PDF melalui response file.
        */

        return response()->file(
            Storage::disk('local')->path(
                $document->file_path
            )
        );
    }
}