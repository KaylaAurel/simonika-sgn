@extends('layouts.admin')

@section('title', 'Detail Slip Gaji - SIMONIKA SGN')

@section('page_title', 'Detail Slip Gaji')

@section('admin-content')

<div class="content-page salary-page">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="content-header salary-page-header">

        <div>

            <span class="content-eyebrow">
                PAYROLL
            </span>

            <h2>
                Slip Gaji {{ $salarySlip->periode }}
            </h2>

            <p>
                {{ $salarySlip->employee->nama }}
            </p>

        </div>


        <a
            href="{{ route('admin.salary-slips.index') }}"
            class="btn btn-secondary"
        >
            ← Kembali
        </a>

    </div>



    {{-- =========================================================
         DETAIL GRID
    ========================================================== --}}

    <div class="salary-detail-grid">


        {{-- =====================================================
             INFORMASI SLIP
        ====================================================== --}}

        <div class="salary-detail-card">

            <div class="salary-detail-card-header">

                <div class="salary-detail-card-icon">
                    📄
                </div>

                <div>

                    <span>
                        INFORMASI
                    </span>

                    <h3>
                        Informasi Slip Gaji
                    </h3>

                </div>

            </div>


            <div class="salary-detail-list">


                {{-- KARYAWAN --}}

                <div class="salary-detail-item">

                    <span>
                        Karyawan
                    </span>

                    <strong>
                        {{ $salarySlip->employee->nama }}
                    </strong>

                </div>


                {{-- NOPEG --}}

                <div class="salary-detail-item">

                    <span>
                        No. Pegawai
                    </span>

                    <strong>
                        {{ $salarySlip->employee->nopeg }}
                    </strong>

                </div>


                {{-- PERIODE --}}

                <div class="salary-detail-item">

                    <span>
                        Periode
                    </span>

                    <strong>
                        {{ $salarySlip->periode }}
                    </strong>

                </div>


                {{-- STATUS --}}

                <div class="salary-detail-item">

                    <span>
                        Status
                    </span>

                    <strong>

                        @php

                            $statusClass = match ($salarySlip->status) {

                                'sent' => 'badge-green',

                                'failed' => 'badge-red',

                                'processing' => 'badge-yellow',

                                'ready' => 'badge-green',

                                'pending' => 'badge-blue',

                                default => 'badge-blue',

                            };

                        @endphp


                        <span class="badge {{ $statusClass }}">

                            {{ $salarySlip->status_name }}

                        </span>

                    </strong>

                </div>


                {{-- TERAKHIR DIKIRIM --}}

                <div class="salary-detail-item">

                    <span>
                        Terakhir Dikirim
                    </span>

                    <strong>
                        {{ $salarySlip->sent_at?->format('d M Y H:i') ?? '-' }}
                    </strong>

                </div>

            </div>

        </div>



        {{-- =====================================================
             ACTION CARD
        ====================================================== --}}

        <div class="salary-action-card">


            {{-- =================================================
                 STATUS PENDING
            ================================================== --}}

            @if ($salarySlip->status === 'pending')

                <div class="salary-action-icon">
                    🔐
                </div>

                <span class="salary-action-label">
                    WATERMARK
                </span>

                <h3>
                    Proses Slip Gaji
                </h3>

                <p>
                    Slip gaji masih berupa file original.
                    Sebelum dikirim melalui WhatsApp, file
                    harus diberi watermark PT Sinergi Gula Nusantara.
                </p>


                <div class="salary-recipient">

                    <span>
                        Karyawan
                    </span>

                    <strong>
                        {{ $salarySlip->employee->nama }}
                    </strong>

                </div>


                <form
                    action="{{ route(
                        'admin.salary-slips.process-watermark',
                        $salarySlip->id
                    ) }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-primary btn-full"
                    >
                        🔐 Proses Watermark
                    </button>

                </form>


                <small class="salary-action-note">
                    File original tidak akan diubah.
                    Sistem akan membuat file PDF baru yang sudah diberi watermark.
                </small>


            {{-- =================================================
                 STATUS PROCESSING
            ================================================== --}}

            @elseif ($salarySlip->status === 'processing')

                <div class="salary-action-icon">
                    ⏳
                </div>

                <span class="salary-action-label">
                    PROCESSING
                </span>

                <h3>
                    Watermark Sedang Diproses
                </h3>

                <p>
                    Sistem sedang membuat PDF baru dengan
                    watermark PT Sinergi Gula Nusantara.
                    Silakan tunggu beberapa saat.
                </p>


                <div class="salary-processing-box">

                    <span class="salary-processing-spinner">
                        ⟳
                    </span>

                    <span>
                        Memproses PDF...
                    </span>

                </div>


            {{-- =================================================
                 STATUS READY
            ================================================== --}}

            @elseif ($salarySlip->status === 'ready')

                <div class="salary-action-icon">
                    💬
                </div>

                <span class="salary-action-label">
                    SIAP DIKIRIM
                </span>

                <h3>
                    Slip Siap Dikirim
                </h3>

                <p>
                    PDF telah berhasil diberi watermark.
                    Slip gaji sekarang dapat dikirim kepada
                    karyawan melalui WhatsApp menggunakan Fonnte.
                </p>


                <div class="salary-recipient">

                    <span>
                        Penerima
                    </span>

                    <strong>
                        {{ $salarySlip->employee->nama }}
                    </strong>

                </div>


                <div class="salary-action-buttons">


                    {{-- LIHAT WATERMARK --}}

                    <a
                        href="{{ route(
                            'admin.salary-slips.view-watermarked',
                            $salarySlip->id
                        ) }}"
                        target="_blank"
                        class="btn btn-secondary btn-full"
                    >
                        👁 Lihat PDF Watermark
                    </a>


                    {{-- KIRIM WHATSAPP --}}

                    <form
                        action="{{ route(
                            'admin.salary-slips.send-whatsapp',
                            $salarySlip->id
                        ) }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="btn btn-primary btn-full"
                        >
                            💬 Kirim melalui WhatsApp
                        </button>

                    </form>

                </div>


                <small class="salary-action-note">
                    WhatsApp hanya menggunakan PDF yang sudah diberi watermark.
                </small>


            {{-- =================================================
                 STATUS SENT
            ================================================== --}}

            @elseif ($salarySlip->status === 'sent')

                <div class="salary-action-icon">
                    ✅
                </div>

                <span class="salary-action-label">
                    TERKIRIM
                </span>

                <h3>
                    Slip Gaji Sudah Terkirim
                </h3>

                <p>
                    Slip gaji yang sudah diberi watermark
                    telah dikirim kepada karyawan melalui WhatsApp.
                </p>


                <div class="salary-recipient">

                    <span>
                        Penerima
                    </span>

                    <strong>
                        {{ $salarySlip->employee->nama }}
                    </strong>

                </div>


                <div class="salary-action-buttons">

                    <a
                        href="{{ route(
                            'admin.salary-slips.view-watermarked',
                            $salarySlip->id
                        ) }}"
                        target="_blank"
                        class="btn btn-secondary btn-full"
                    >
                        👁 Lihat PDF Watermark
                    </a>

                </div>


            {{-- =================================================
                 STATUS FAILED
            ================================================== --}}

            @elseif ($salarySlip->status === 'failed')

                <div class="salary-action-icon">
                    ⚠️
                </div>

                <span class="salary-action-label">
                    GAGAL
                </span>

                <h3>
                    Proses Gagal
                </h3>

                <p>
                    Terjadi masalah saat memproses slip gaji.
                    Silakan coba proses watermark kembali.
                </p>


                <form
                    action="{{ route(
                        'admin.salary-slips.process-watermark',
                        $salarySlip->id
                    ) }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-primary btn-full"
                    >
                        🔄 Proses Watermark Lagi
                    </button>

                </form>

            @endif

        </div>

    </div>



    {{-- =========================================================
         FILE ORIGINAL
    ========================================================== --}}

    <div class="salary-file-card">

        <div>

            <span class="salary-file-label">
                FILE ORIGINAL
            </span>

            <h3>
                {{ $salarySlip->original_name ?? 'Slip Gaji PDF' }}
            </h3>

            <p>
                File PDF original tersimpan secara private
                dan tidak diubah oleh proses watermark.
            </p>

        </div>


        <a
            href="{{ route(
                'admin.salary-slips.view',
                $salarySlip->id
            ) }}"
            target="_blank"
            class="btn btn-secondary"
        >
            👁 Lihat PDF Original
        </a>

    </div>



    {{-- =========================================================
         FILE WATERMARK
    ========================================================== --}}

    @if (
        $salarySlip->watermarked_path &&
        Storage::disk('local')->exists(
            $salarySlip->watermarked_path
        )
    )

        <div class="salary-file-card salary-watermarked-file">

            <div>

                <span class="salary-file-label">
                    FILE WATERMARK
                </span>

                <h3>
                    PDF Slip Gaji + Watermark SGN
                </h3>

                <p>
                    File ini yang akan digunakan untuk
                    pengiriman melalui WhatsApp.
                </p>

            </div>


            <a
                href="{{ route(
                    'admin.salary-slips.view-watermarked',
                    $salarySlip->id
                ) }}"
                target="_blank"
                class="btn btn-primary"
            >
                👁 Lihat PDF Watermark
            </a>

        </div>

    @endif

</div>

@endsection