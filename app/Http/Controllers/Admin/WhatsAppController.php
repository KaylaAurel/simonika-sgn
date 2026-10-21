<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\SalarySlip;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Storage;
use Throwable;

class WhatsAppController extends Controller
{
    /**
     * Mengirim slip gaji yang sudah diberi watermark
     * melalui WhatsApp menggunakan Fonnte.
     */
    public function sendSalarySlip(
        SalarySlip $salarySlip,
        FonnteService $fonnteService
    ) {
        /*
        |--------------------------------------------------------------------------
        | Load data karyawan
        |--------------------------------------------------------------------------
        */

        $salarySlip->load('employee');

        $employee = $salarySlip->employee;

        /*
        |--------------------------------------------------------------------------
        | Pastikan karyawan tersedia
        |--------------------------------------------------------------------------
        */

        if (!$employee) {
            return back()->with(
                'error',
                'Data karyawan untuk slip gaji tidak ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan nomor HP tersedia
        |--------------------------------------------------------------------------
        */

        if (!$employee->no_hp) {
            return back()->with(
                'error',
                'Nomor WhatsApp karyawan belum tersedia.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Slip harus sudah diberi watermark
        |--------------------------------------------------------------------------
        */

        if ($salarySlip->status !== 'ready') {
            return back()->with(
                'error',
                'Slip gaji belum siap dikirim. Silakan proses watermark terlebih dahulu.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan path PDF watermark tersedia
        |--------------------------------------------------------------------------
        */

        if (!$salarySlip->watermarked_path) {
            return back()->with(
                'error',
                'File PDF watermark belum tersedia.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan file PDF watermark benar-benar ada
        |--------------------------------------------------------------------------
        */

        if (
            !Storage::disk('local')->exists(
                $salarySlip->watermarked_path
            )
        ) {
            return back()->with(
                'error',
                'File PDF watermark tidak ditemukan di storage.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Buat nama file yang akan dikirim
        |--------------------------------------------------------------------------
        */

        $employeeName = preg_replace(
            '/[^A-Za-z0-9\-_]/',
            '-',
            $employee->nama
        );

        $periode = preg_replace(
            '/[^A-Za-z0-9\-_]/',
            '-',
            $salarySlip->periode
        );

        $filename =
            'Slip-Gaji-' .
            $periode .
            '-' .
            $employeeName .
            '.pdf';

        /*
        |--------------------------------------------------------------------------
        | Buat pesan WhatsApp
        |--------------------------------------------------------------------------
        */

        $message =
            "Halo {$employee->nama} 👋\n\n" .
            "Berikut kami sampaikan slip gaji " .
            "untuk periode *{$salarySlip->periode}*.\n\n" .
            "Dokumen terlampir merupakan slip gaji " .
            "yang telah diberi watermark resmi " .
            "*PT Sinergi Gula Nusantara*.\n\n" .
            "Mohon menjaga kerahasiaan dokumen ini " .
            "dan tidak menyebarluaskannya.\n\n" .
            "Terima kasih.";

        /*
        |--------------------------------------------------------------------------
        | Ubah status menjadi processing
        |--------------------------------------------------------------------------
        */

        $salarySlip->update([
            'status' => 'processing',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Kirim melalui Fonnte
        |--------------------------------------------------------------------------
        */

        try {
            $response = $fonnteService->sendFile(
                $employee->no_hp,
                $message,
                $salarySlip->watermarked_path,
                $filename
            );

            /*
            |--------------------------------------------------------------------------
            | Jika berhasil
            |--------------------------------------------------------------------------
            */

            $salarySlip->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            return redirect()
                ->route(
                    'admin.salary-slips.show',
                    $salarySlip->id
                )
                ->with(
                    'success',
                    'Slip gaji berhasil dikirim melalui WhatsApp ke ' .
                    $employee->nama . '.'
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

            return back()->with(
                'error',
                'Pengiriman WhatsApp gagal: ' .
                $e->getMessage()
            );
        }
    }


    /**
     * Mengirim slip gaji terbaru milik karyawan.
     *
     * Digunakan apabila admin mengirim slip langsung
     * dari halaman data karyawan.
     */
    public function sendLatestSalarySlip(
        Employee $employee,
        FonnteService $fonnteService
    ) {
        /*
        |--------------------------------------------------------------------------
        | Pastikan nomor HP tersedia
        |--------------------------------------------------------------------------
        */

        if (!$employee->no_hp) {
            return back()->with(
                'error',
                'Nomor WhatsApp karyawan belum tersedia.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Cari slip gaji terbaru yang sudah siap dikirim
        |--------------------------------------------------------------------------
        */

        $salarySlip = SalarySlip::where(
            'employee_id',
            $employee->id
        )
            ->where(
                'status',
                'ready'
            )
            ->latest()
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Jika tidak ditemukan
        |--------------------------------------------------------------------------
        */

        if (!$salarySlip) {
            return back()->with(
                'error',
                'Tidak ditemukan slip gaji yang siap dikirim untuk karyawan ini.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Redirect ke proses pengiriman
        |--------------------------------------------------------------------------
        |
        | Kita panggil method yang sama supaya seluruh proses
        | pengiriman tetap menggunakan satu alur.
        |
        */

        return $this->sendSalarySlip(
            $salarySlip,
            $fonnteService
        );
    }


    /**
     * Mengecek status pengiriman slip gaji.
     */
    public function status(
        SalarySlip $salarySlip
    ) {
        return response()->json([
            'salary_slip_id' => $salarySlip->id,
            'employee_id' => $salarySlip->employee_id,
            'employee_name' => $salarySlip->employee?->nama,
            'status' => $salarySlip->status,
            'status_name' => $salarySlip->status_name,
            'sent_at' => $salarySlip->sent_at?->format(
                'Y-m-d H:i:s'
            ),
        ]);
    }
}