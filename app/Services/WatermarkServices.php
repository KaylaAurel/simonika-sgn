<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use setasign\Fpdi\Fpdi;

/**
 * FPDI dengan dukungan rotasi teks.
 */
class RotatableFpdi extends Fpdi
{
    protected float $angle = 0;

    /**
     * Memutar posisi canvas PDF.
     */
    public function Rotate(
        float $angle,
        float $x = -1,
        float $y = -1
    ): void {
        if ($this->angle != 0) {
            $this->_out('Q');
        }

        $this->angle = $angle;

        if ($angle == 0) {
            return;
        }

        if ($x == -1) {
            $x = $this->GetX();
        }

        if ($y == -1) {
            $y = $this->GetY();
        }

        $angle = $angle * M_PI / 180;

        $c = cos($angle);
        $s = sin($angle);

        $cx = $x * $this->k;
        $cy = ($this->h - $y) * $this->k;

        $this->_out(
            sprintf(
                'q %.5F %.5F %.5F %.5F %.5F %.5F cm',
                $c,
                $s,
                -$s,
                $c,
                $cx - $c * $cx + $s * $cy,
                $cy - $s * $cx - $c * $cy
            )
        );
    }

    /**
     * Menutup halaman PDF dan memastikan rotasi
     * tidak terbawa ke halaman berikutnya.
     */
    protected function _endpage(): void
    {
        if ($this->angle != 0) {
            $this->angle = 0;

            $this->_out('Q');
        }

        parent::_endpage();
    }
}


/**
 * Service untuk memberikan watermark pada PDF slip gaji.
 */
class WatermarkService
{
    /**
     * Menambahkan watermark ke seluruh halaman PDF.
     *
     * @param UploadedFile|string $source
     * @param string $outputPath
     * @return string
     */
    public function addWatermark(
        UploadedFile|string $source,
        string $outputPath
    ): string {
        /*
        |--------------------------------------------------------------------------
        | 1. Cari file sumber
        |--------------------------------------------------------------------------
        */

        $sourcePath = $this->resolveSourcePath($source);

        if (!file_exists($sourcePath)) {
            throw new RuntimeException(
                'File PDF sumber tidak ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Pastikan file merupakan PDF
        |--------------------------------------------------------------------------
        */

        $extension = strtolower(
            pathinfo(
                $sourcePath,
                PATHINFO_EXTENSION
            )
        );

        if ($extension !== 'pdf') {
            throw new RuntimeException(
                'File sumber harus berupa PDF.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Buat object PDF
        |--------------------------------------------------------------------------
        */

        $pdf = new RotatableFpdi();

        /*
        |--------------------------------------------------------------------------
        | 4. Baca PDF sumber
        |--------------------------------------------------------------------------
        */

        try {
            $pageCount = $pdf->setSourceFile(
                $sourcePath
            );
        } catch (\Throwable $e) {
            throw new RuntimeException(
                'PDF tidak dapat diproses: ' .
                $e->getMessage()
            );
        }

        if ($pageCount < 1) {
            throw new RuntimeException(
                'PDF tidak memiliki halaman.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Proses setiap halaman
        |--------------------------------------------------------------------------
        */

        for (
            $page = 1;
            $page <= $pageCount;
            $page++
        ) {
            /*
            |--------------------------------------------------------------------------
            | Import halaman PDF
            |--------------------------------------------------------------------------
            */

            $template = $pdf->importPage(
                $page
            );

            /*
            |--------------------------------------------------------------------------
            | Ambil ukuran halaman
            |--------------------------------------------------------------------------
            */

            $size = $pdf->getTemplateSize(
                $template
            );

            /*
            |--------------------------------------------------------------------------
            | Tentukan orientasi halaman
            |--------------------------------------------------------------------------
            */

            $orientation =
                $size['width'] > $size['height']
                    ? 'L'
                    : 'P';

            /*
            |--------------------------------------------------------------------------
            | Buat halaman baru dengan ukuran
            | yang sama seperti halaman original
            |--------------------------------------------------------------------------
            */

            $pdf->AddPage(
                $orientation,
                [
                    $size['width'],
                    $size['height'],
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Masukkan halaman original
            |--------------------------------------------------------------------------
            */

            $pdf->useTemplate(
                $template
            );

            /*
            |--------------------------------------------------------------------------
            | Tambahkan watermark
            |--------------------------------------------------------------------------
            */

            $this->addWatermarkText(
                $pdf,
                $size['width'],
                $size['height']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Tentukan lokasi file output
        |--------------------------------------------------------------------------
        */

        $fullOutputPath =
            Storage::disk('local')
                ->path($outputPath);

        /*
        |--------------------------------------------------------------------------
        | 7. Buat folder jika belum ada
        |--------------------------------------------------------------------------
        */

        $directory = dirname(
            $fullOutputPath
        );

        if (!is_dir($directory)) {
            mkdir(
                $directory,
                0755,
                true
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 8. Simpan PDF watermark
        |--------------------------------------------------------------------------
        */

        try {
            $pdf->Output(
                'F',
                $fullOutputPath
            );
        } catch (\Throwable $e) {
            throw new RuntimeException(
                'PDF watermark gagal disimpan: ' .
                $e->getMessage()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 9. Pastikan file benar-benar berhasil dibuat
        |--------------------------------------------------------------------------
        */

        if (!file_exists($fullOutputPath)) {
            throw new RuntimeException(
                'File PDF watermark tidak berhasil dibuat.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 10. Return path relatif storage
        |--------------------------------------------------------------------------
        */

        return $outputPath;
    }


    /**
     * Menambahkan teks watermark pada halaman PDF.
     */
    protected function addWatermarkText(
        RotatableFpdi $pdf,
        float $width,
        float $height
    ): void {
        /*
        |--------------------------------------------------------------------------
        | Posisi tengah halaman
        |--------------------------------------------------------------------------
        */

        $centerX = $width / 2;
        $centerY = $height / 2;

        /*
        |--------------------------------------------------------------------------
        | Font watermark
        |--------------------------------------------------------------------------
        */

        $pdf->SetFont(
            'Helvetica',
            'B',
            24
        );

        /*
        |--------------------------------------------------------------------------
        | Warna watermark
        |--------------------------------------------------------------------------
        |
        | Abu-abu agar tetap terlihat tetapi tidak terlalu
        | mengganggu isi slip gaji.
        |
        */

        $pdf->SetTextColor(
            190,
            190,
            190
        );

        /*
        |--------------------------------------------------------------------------
        | Teks watermark
        |--------------------------------------------------------------------------
        */

        $text =
            'PT SINERGI GULA NUSANTARA';

        /*
        |--------------------------------------------------------------------------
        | Hitung lebar teks
        |--------------------------------------------------------------------------
        */

        $textWidth =
            $pdf->GetStringWidth(
                $text
            );

        /*
        |--------------------------------------------------------------------------
        | Putar teks 45 derajat
        |--------------------------------------------------------------------------
        */

        $pdf->Rotate(
            45,
            $centerX,
            $centerY
        );

        /*
        |--------------------------------------------------------------------------
        | Tentukan posisi teks
        |--------------------------------------------------------------------------
        */

        $x =
            $centerX -
            ($textWidth / 2);

        $y =
            $centerY;

        /*
        |--------------------------------------------------------------------------
        | Tulis watermark
        |--------------------------------------------------------------------------
        */

        $pdf->Text(
            $x,
            $y,
            $text
        );

        /*
        |--------------------------------------------------------------------------
        | Kembalikan rotasi ke normal
        |--------------------------------------------------------------------------
        */

        $pdf->Rotate(0);
    }


    /**
     * Mengambil path asli file PDF.
     *
     * Bisa menerima:
     *
     * 1. UploadedFile
     * 2. Path file relatif terhadap storage/app
     */
    protected function resolveSourcePath(
        UploadedFile|string $source
    ): string {
        /*
        |--------------------------------------------------------------------------
        | Jika sumber merupakan file upload
        |--------------------------------------------------------------------------
        */

        if ($source instanceof UploadedFile) {
            $realPath =
                $source->getRealPath();

            if (!$realPath) {
                throw new RuntimeException(
                    'File upload tidak dapat ditemukan.'
                );
            }

            return $realPath;
        }

        /*
        |--------------------------------------------------------------------------
        | Jika sumber merupakan path file
        |--------------------------------------------------------------------------
        */

        $path =
            Storage::disk('local')
                ->path($source);

        if (!file_exists($path)) {
            throw new RuntimeException(
                'File sumber tidak ditemukan di storage.'
            );
        }

        return $path;
    }
}