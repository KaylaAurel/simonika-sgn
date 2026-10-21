<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use RuntimeException;

class FonnteService
{
    /**
     * Token API Fonnte.
     */
    protected string $token;

    /**
     * Endpoint API Fonnte.
     */
    protected string $endpoint;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->token = trim(
            (string) config('services.fonnte.token')
        );

        $this->endpoint = trim(
            (string) config(
                'services.fonnte.endpoint',
                'https://api.fonnte.com/send'
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Pastikan token tersedia
        |--------------------------------------------------------------------------
        */

        if ($this->token === '') {
            throw new RuntimeException(
                'FONNTE_TOKEN belum dikonfigurasi di file .env.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan endpoint tersedia
        |--------------------------------------------------------------------------
        */

        if ($this->endpoint === '') {
            throw new RuntimeException(
                'FONNTE_ENDPOINT belum dikonfigurasi.'
            );
        }
    }


    /**
     * Mengirim pesan WhatsApp tanpa file.
     */
    public function sendMessage(
        string $target,
        string $message
    ): array {
        /*
        |--------------------------------------------------------------------------
        | Normalisasi nomor
        |--------------------------------------------------------------------------
        */

        $target = $this->normalizePhoneNumber(
            $target
        );

        if ($target === '') {
            throw new RuntimeException(
                'Nomor WhatsApp tujuan tidak valid.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Data request
        |--------------------------------------------------------------------------
        */

        $postFields = [
            'target' => $target,

            'message' => $message,

            'countryCode' => '62',
        ];

        /*
        |--------------------------------------------------------------------------
        | Kirim request
        |--------------------------------------------------------------------------
        */

        return $this->sendRequest(
            $postFields
        );
    }


    /**
     * Mengirim pesan WhatsApp beserta file.
     *
     * File diambil dari storage/app.
     *
     * Contoh:
     *
     * salary-slips/watermarked/slip-001.pdf
     */
    public function sendFile(
        string $target,
        string $message,
        string $filePath,
        ?string $filename = null
    ): array {
        /*
        |--------------------------------------------------------------------------
        | Normalisasi nomor
        |--------------------------------------------------------------------------
        */

        $target = $this->normalizePhoneNumber(
            $target
        );

        if ($target === '') {
            throw new RuntimeException(
                'Nomor WhatsApp tujuan tidak valid.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan file tersedia di storage
        |--------------------------------------------------------------------------
        */

        if (
            !Storage::disk('local')->exists(
                $filePath
            )
        ) {
            throw new RuntimeException(
                'File yang akan dikirim tidak ditemukan: ' .
                $filePath
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Path absolut
        |--------------------------------------------------------------------------
        */

        $absolutePath =
            Storage::disk('local')
                ->path($filePath);

        /*
        |--------------------------------------------------------------------------
        | Cek keberadaan file
        |--------------------------------------------------------------------------
        */

        if (!file_exists($absolutePath)) {
            throw new RuntimeException(
                'File PDF tidak ditemukan pada server: ' .
                $absolutePath
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Cek file bisa dibaca
        |--------------------------------------------------------------------------
        */

        if (!is_readable($absolutePath)) {
            throw new RuntimeException(
                'File PDF tidak dapat dibaca oleh sistem.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan file PDF
        |--------------------------------------------------------------------------
        */

        $extension = strtolower(
            pathinfo(
                $absolutePath,
                PATHINFO_EXTENSION
            )
        );

        if ($extension !== 'pdf') {
            throw new RuntimeException(
                'File yang dikirim melalui WhatsApp harus berupa PDF.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Nama file attachment
        |--------------------------------------------------------------------------
        */

        $filename = $filename
            ?: basename($absolutePath);

        /*
        |--------------------------------------------------------------------------
        | MIME type
        |--------------------------------------------------------------------------
        */

        $mimeType = mime_content_type(
            $absolutePath
        );

        if (!$mimeType) {
            $mimeType = 'application/pdf';
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan cURL tersedia
        |--------------------------------------------------------------------------
        */

        if (!function_exists('curl_init')) {
            throw new RuntimeException(
                'PHP cURL extension belum aktif.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CURLFile
        |--------------------------------------------------------------------------
        |
        | File dikirim sebagai multipart upload.
        |
        */

        $curlFile = new \CURLFile(
            $absolutePath,
            $mimeType,
            $filename
        );

        /*
        |--------------------------------------------------------------------------
        | Data multipart
        |--------------------------------------------------------------------------
        */

        $postFields = [
            'target' => $target,

            'message' => $message,

            'file' => $curlFile,

            'filename' => $filename,

            'countryCode' => '62',
        ];

        /*
        |--------------------------------------------------------------------------
        | Kirim request
        |--------------------------------------------------------------------------
        */

        return $this->sendRequest(
            $postFields
        );
    }


    /**
     * Mengirim HTTP request ke Fonnte.
     *
     * Method ini menggunakan cURL karena Fonnte
     * menerima attachment sebagai multipart file.
     */
    protected function sendRequest(
        array $postFields
    ): array {
        /*
        |--------------------------------------------------------------------------
        | Inisialisasi cURL
        |--------------------------------------------------------------------------
        */

        $curl = curl_init();

        if ($curl === false) {
            throw new RuntimeException(
                'Gagal menginisialisasi cURL.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Konfigurasi cURL
        |--------------------------------------------------------------------------
        */

        curl_setopt_array(
            $curl,
            [
                CURLOPT_URL =>
                    $this->endpoint,

                CURLOPT_RETURNTRANSFER =>
                    true,

                CURLOPT_ENCODING =>
                    '',

                CURLOPT_MAXREDIRS =>
                    10,

                CURLOPT_TIMEOUT =>
                    120,

                CURLOPT_CONNECTTIMEOUT =>
                    30,

                CURLOPT_FOLLOWLOCATION =>
                    true,

                CURLOPT_HTTP_VERSION =>
                    CURL_HTTP_VERSION_1_1,

                CURLOPT_CUSTOMREQUEST =>
                    'POST',

                CURLOPT_POST =>
                    true,

                CURLOPT_POSTFIELDS =>
                    $postFields,

                CURLOPT_HTTPHEADER => [
                    'Authorization: ' .
                    $this->token,

                    'Accept: application/json',
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Eksekusi request
        |--------------------------------------------------------------------------
        */

        $responseBody =
            curl_exec($curl);

        /*
        |--------------------------------------------------------------------------
        | Cek error cURL
        |--------------------------------------------------------------------------
        */

        if ($responseBody === false) {
            $errorNumber =
                curl_errno($curl);

            $errorMessage =
                curl_error($curl);

            curl_close($curl);

            throw new RuntimeException(
                'Gagal menghubungi Fonnte. ' .
                'cURL error ' .
                $errorNumber .
                ': ' .
                $errorMessage
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil HTTP status
        |--------------------------------------------------------------------------
        */

        $httpStatus =
            curl_getinfo(
                $curl,
                CURLINFO_HTTP_CODE
            );

        /*
        |--------------------------------------------------------------------------
        | Ambil content type
        |--------------------------------------------------------------------------
        */

        $contentType =
            curl_getinfo(
                $curl,
                CURLINFO_CONTENT_TYPE
            );

        curl_close($curl);

        /*
        |--------------------------------------------------------------------------
        | HTTP error
        |--------------------------------------------------------------------------
        */

        if (
            $httpStatus < 200 ||
            $httpStatus >= 300
        ) {
            throw new RuntimeException(
                'Fonnte mengembalikan HTTP ' .
                $httpStatus .
                ': ' .
                $responseBody
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Decode JSON
        |--------------------------------------------------------------------------
        */

        $data = json_decode(
            $responseBody,
            true
        );

        /*
        |--------------------------------------------------------------------------
        | Response bukan JSON
        |--------------------------------------------------------------------------
        */

        if (!is_array($data)) {
            throw new RuntimeException(
                'Response dari Fonnte tidak valid. ' .
                'HTTP ' .
                $httpStatus .
                '. Content-Type: ' .
                ($contentType ?: '-') .
                '. Response: ' .
                $responseBody
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Cek status Fonnte
        |--------------------------------------------------------------------------
        */

        if (
            isset($data['status']) &&
            (
                $data['status'] === false ||
                $data['status'] === 'false' ||
                $data['status'] === 0 ||
                $data['status'] === '0'
            )
        ) {
            $reason =
                $data['reason']
                ?? $data['message']
                ?? 'Alasan tidak diketahui.';

            throw new RuntimeException(
                'Fonnte menolak pengiriman: ' .
                $reason
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Return response
        |--------------------------------------------------------------------------
        */

        return $data;
    }


    /**
     * Normalisasi nomor WhatsApp Indonesia.
     *
     * Contoh:
     *
     * 081234567890
     * → 6281234567890
     *
     * +6281234567890
     * → 6281234567890
     *
     * 6281234567890
     * → 6281234567890
     *
     * 81234567890
     * → 6281234567890
     */
    protected function normalizePhoneNumber(
        string $phone
    ): string {
        /*
        |--------------------------------------------------------------------------
        | Hapus karakter selain angka
        |--------------------------------------------------------------------------
        */

        $phone = preg_replace(
            '/[^0-9]/',
            '',
            $phone
        );

        if (!$phone) {
            return '';
        }

        /*
        |--------------------------------------------------------------------------
        | 08xxxxxxxx → 628xxxxxxxx
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $phone,
                '0'
            )
        ) {
            return '62' .
                substr(
                    $phone,
                    1
                );
        }

        /*
        |--------------------------------------------------------------------------
        | 8xxxxxxxx → 628xxxxxxxx
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $phone,
                '8'
            )
        ) {
            return '62' .
                $phone;
        }

        /*
        |--------------------------------------------------------------------------
        | Sudah menggunakan 62
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $phone,
                '62'
            )
        ) {
            return $phone;
        }

        /*
        |--------------------------------------------------------------------------
        | Format lain
        |--------------------------------------------------------------------------
        */

        return $phone;
    }
}