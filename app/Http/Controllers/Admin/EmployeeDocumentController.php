<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\StoreDocumentRequest;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeDocumentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR DOKUMEN
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = EmployeeDocument::with('employee');

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
        | FILTER JENIS DOKUMEN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('type')) {

            $query->where(
                'type',
                $request->input('type')
            );
        }

        $documents = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.documents.index', [
            'documents' => $documents,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH DOKUMEN
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $employees = Employee::query()
            ->orderBy('nama', 'asc')
            ->get();

        return view('admin.documents.create', [
            'employees' => $employees,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN DOKUMEN
    |--------------------------------------------------------------------------
    */

    public function store(StoreDocumentRequest $request)
    {
        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Upload file PDF
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $type = $request->input('type');

            $data['file_path'] = $file->store(
                'documents/' . $type,
                'local'
            );

            $data['original_name'] = $file->getClientOriginalName();
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan data dokumen
        |--------------------------------------------------------------------------
        */

        EmployeeDocument::create($data);

        return redirect()
            ->route('admin.documents.index')
            ->with(
                'success',
                'Dokumen karyawan berhasil diupload.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM EDIT DOKUMEN
    |--------------------------------------------------------------------------
    */

    public function edit(EmployeeDocument $document)
    {
        $employees = Employee::query()
            ->orderBy('nama', 'asc')
            ->get();

        return view('admin.documents.edit', [
            'document' => $document,
            'employees' => $employees,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE DOKUMEN
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        EmployeeDocument $document
    ) {
        $request->validate([
            'employee_id' => [
                'required',
                'exists:employees,id',
            ],

            'type' => [
                'required',
                'in:sk,cuti,pensiun',
            ],

            'file' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:10240',
            ],
        ], [
            'employee_id.required' => 'Karyawan wajib dipilih.',
            'employee_id.exists' => 'Data karyawan tidak ditemukan.',
            'type.required' => 'Jenis dokumen wajib dipilih.',
            'type.in' => 'Jenis dokumen tidak valid.',
            'file.file' => 'File yang diupload tidak valid.',
            'file.mimes' => 'Dokumen harus berformat PDF.',
            'file.max' => 'Ukuran dokumen maksimal 10 MB.',
        ]);

        $data = [
            'employee_id' => $request->input('employee_id'),
            'type' => $request->input('type'),
        ];

        /*
        |--------------------------------------------------------------------------
        | Jika upload PDF baru
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('file')) {

            /*
            |--------------------------------------------------------------------------
            | Hapus file lama
            |--------------------------------------------------------------------------
            */

            if (
                $document->file_path &&
                Storage::disk('local')->exists(
                    $document->file_path
                )
            ) {
                Storage::disk('local')->delete(
                    $document->file_path
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Upload file baru
            |--------------------------------------------------------------------------
            */

            $file = $request->file('file');

            $data['file_path'] = $file->store(
                'documents/' . $request->input('type'),
                'local'
            );

            $data['original_name'] =
                $file->getClientOriginalName();
        }

        $document->update($data);

        return redirect()
            ->route('admin.documents.index')
            ->with(
                'success',
                'Dokumen berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS DOKUMEN
    |--------------------------------------------------------------------------
    */

    public function destroy(EmployeeDocument $document)
    {
        /*
        |--------------------------------------------------------------------------
        | Hapus file PDF
        |--------------------------------------------------------------------------
        */

        if (
            $document->file_path &&
            Storage::disk('local')->exists(
                $document->file_path
            )
        ) {
            Storage::disk('local')->delete(
                $document->file_path
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus record database
        |--------------------------------------------------------------------------
        */

        $document->delete();

        return redirect()
            ->route('admin.documents.index')
            ->with(
                'success',
                'Dokumen berhasil dihapus.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LIHAT DOKUMEN
    |--------------------------------------------------------------------------
    */

    public function view(EmployeeDocument $document)
    {
        if (
            !$document->file_path ||
            !Storage::disk('local')->exists(
                $document->file_path
            )
        ) {
            abort(
                404,
                'File dokumen tidak ditemukan.'
            );
        }

        return response()->file(
            Storage::disk('local')->path(
                $document->file_path
            )
        );
    }
}