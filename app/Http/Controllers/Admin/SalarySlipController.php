<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\SalarySlip;
use App\Services\WatermarkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SalarySlipController extends Controller
{
    /**
     * Menampilkan daftar slip gaji.
     */
    public function index(Request $request)
    {
        $query = SalarySlip::with('employee');

        /*
        |--------------------------------------------------------------------------
        | SEARCH
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
        | FILTER PERIODE
        |--------------------------------------------------------------------------
        */

        if ($request->filled('periode')) {

            $query->where(
                'periode',
                'like',
                '%' . $request->input('periode') . '%'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATA SLIP GAJI
        |--------------------------------------------------------------------------
        */

        $salarySlips = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();


        return view('admin.salary-slips.index', [

            'salarySlips' => $salarySlips,

        ]);
    }


    /**
     * Form upload slip gaji.
     */
    public function create()
    {
        $employees = Employee::orderBy('nama')->get();

        return view('admin.salary-slips.create', [

            'employees' => $employees,

        ]);
    }


    /**
     * Simpan slip gaji original.
     *
     * Status awal:
     * pending = menunggu proses watermark.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'employee_id' => [
                'required',
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

        ]);


        /*
        |--------------------------------------------------------------------------
        | UPLOAD FILE ORIGINAL
        |--------------------------------------------------------------------------
        */

        $file = $request->file('file');

        $originalName = $file->getClientOriginalName();

        $path = $file->store(
            'salary-slips/original',
            'local'
        );


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA
        |--------------------------------------------------------------------------
        */

        SalarySlip::create([

            'employee_id' => $validated['employee_id'],

            'periode' => $validated['periode'],

            'original_name' => $originalName,

            'file_path' => $path,

            'watermarked_path' => null,

            'status' => 'pending',

            'sent_at' => null,

        ]);


        return redirect()
            ->route('admin.salary-slips.index')
            ->with(
                'success',
                'Slip gaji berhasil diupload dan menunggu proses watermark.'
            );
    }


    /**
     * Detail slip gaji.
     */
    public function show(SalarySlip $salarySlip)
    {
        $salarySlip->load('employee');

        return view('admin.salary-slips.show', [

            'salarySlip' => $salarySlip,

        ]);
    }


    /**
     * Proses watermark PDF.
     *
     * Alur:
     *
     * PDF Original
     *      ↓
     * WatermarkService
     *      ↓
     * PDF Watermarked
     *      ↓
     * status = ready
     */
    public function processWatermark(
        SalarySlip $salarySlip,
        WatermarkService $watermarkService
    ) {
        /*
        |--------------------------------------------------------------------------
        | Pastikan file original tersedia
        |--------------------------------------------------------------------------
        */

        if (
            !$salarySlip->file_path ||
            !Storage::disk('local')->exists(
                $salarySlip->file_path
            )
        ) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'File PDF original tidak ditemukan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Tandai sedang diproses
        |--------------------------------------------------------------------------
        */

        $salarySlip->update([
            'status' => 'processing',
        ]);


        try {

            /*
            |--------------------------------------------------------------------------
            | Nama file watermark
            |--------------------------------------------------------------------------
            */

            $originalFileName = pathinfo(
                $salarySlip->file_path,
                PATHINFO_FILENAME
            );

            $watermarkedPath =
                'salary-slips/watermarked/' .
                $originalFileName .
                '-watermarked.pdf';


            /*
            |--------------------------------------------------------------------------
            | Jika sebelumnya sudah ada watermark,
            | hapus terlebih dahulu.
            |--------------------------------------------------------------------------
            */

            if (
                Storage::disk('local')->exists(
                    $watermarkedPath
                )
            ) {

                Storage::disk('local')->delete(
                    $watermarkedPath
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Jalankan WatermarkService
            |--------------------------------------------------------------------------
            */

            $resultPath = $watermarkService->addWatermark(

                $salarySlip->file_path,

                $watermarkedPath

            );


            /*
            |--------------------------------------------------------------------------
            | Pastikan hasil watermark benar-benar ada
            |--------------------------------------------------------------------------
            */

            if (
                !Storage::disk('local')->exists(
                    $resultPath
                )
            ) {

                throw new \RuntimeException(
                    'File PDF watermark tidak berhasil dibuat.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Simpan hasil watermark
            |--------------------------------------------------------------------------
            */

            $salarySlip->update([

                'watermarked_path' => $resultPath,

                'status' => 'ready',

            ]);


            return redirect()
                ->route(
                    'admin.salary-slips.show',
                    $salarySlip->id
                )
                ->with(
                    'success',
                    'Watermark berhasil dibuat. Slip gaji siap dikirim melalui WhatsApp.'
                );

        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Jika gagal
            |--------------------------------------------------------------------------
            */

            $salarySlip->update([

                'status' => 'failed',

            ]);


            return redirect()
                ->back()
                ->with(
                    'error',
                    'Proses watermark gagal: ' .
                    $e->getMessage()
                );
        }
    }


    /**
     * Lihat PDF original.
     */
    public function view(SalarySlip $salarySlip)
    {
        if (
            !$salarySlip->file_path ||
            !Storage::disk('local')->exists(
                $salarySlip->file_path
            )
        ) {

            abort(
                404,
                'File slip gaji original tidak ditemukan.'
            );

        }


        return response()->file(

            Storage::disk('local')->path(
                $salarySlip->file_path
            )

        );
    }


    /**
     * Lihat PDF yang sudah diberi watermark.
     */
    public function viewWatermarked(SalarySlip $salarySlip)
    {
        if (
            !$salarySlip->watermarked_path ||
            !Storage::disk('local')->exists(
                $salarySlip->watermarked_path
            )
        ) {

            abort(
                404,
                'File slip gaji watermark tidak ditemukan.'
            );

        }


        return response()->file(

            Storage::disk('local')->path(
                $salarySlip->watermarked_path
            )

        );
    }


    /**
     * Hapus slip gaji.
     *
     * Menghapus:
     * - PDF original
     * - PDF watermark
     * - record database
     */
    public function destroy(SalarySlip $salarySlip)
    {
        /*
        |--------------------------------------------------------------------------
        | Hapus PDF original
        |--------------------------------------------------------------------------
        */

        if (
            $salarySlip->file_path &&
            Storage::disk('local')->exists(
                $salarySlip->file_path
            )
        ) {

            Storage::disk('local')->delete(
                $salarySlip->file_path
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Hapus PDF watermark
        |--------------------------------------------------------------------------
        */

        if (
            $salarySlip->watermarked_path &&
            Storage::disk('local')->exists(
                $salarySlip->watermarked_path
            )
        ) {

            Storage::disk('local')->delete(
                $salarySlip->watermarked_path
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Hapus data database
        |--------------------------------------------------------------------------
        */

        $salarySlip->delete();


        return redirect()
            ->route('admin.salary-slips.index')
            ->with(
                'success',
                'Slip gaji berhasil dihapus.'
            );
    }
}