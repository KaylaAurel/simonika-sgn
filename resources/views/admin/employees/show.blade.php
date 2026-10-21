@extends('layouts.admin')

@section('title', 'Detail Karyawan - SIMONIKA SGN')

@section('page_title', 'Detail Karyawan')

@section('admin-content')

<div class="employee-detail-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}
    <div class="employee-detail-header">

        <div class="employee-detail-heading">

            <span class="employee-detail-eyebrow">
                PROFIL KARYAWAN
            </span>

            <h2>
                Detail Karyawan
            </h2>

            <p>
                Informasi lengkap mengenai data dan riwayat
                {{ $employee->nama }}.
            </p>

        </div>


        <div class="employee-detail-actions">

            <a
                href="{{ route('admin.employees.edit', $employee->id) }}"
                class="employee-detail-btn employee-detail-btn-primary"
            >
                <span>✎</span>
                Edit Data
            </a>

            <a
                href="{{ route('admin.employees.index') }}"
                class="employee-detail-btn employee-detail-btn-secondary"
            >
                ← Kembali
            </a>

        </div>

    </div>


    {{-- =====================================================
         PROFILE HERO
    ====================================================== --}}
    <div class="employee-profile-hero">

        <div class="employee-profile-main">

            <div class="employee-profile-photo-wrapper">

                <img
                    src="{{ $employee->photo_url }}"
                    alt="{{ $employee->nama }}"
                    class="employee-profile-photo-image"
                >

            </div>


            <div class="employee-profile-identity">

                <span class="employee-profile-nopeg">
                    NOPEG {{ $employee->nopeg }}
                </span>

                <h1>
                    {{ $employee->nama }}
                </h1>

                <p class="employee-profile-position">
                    {{ $employee->jabatan }}
                </p>

                <span class="employee-profile-department">
                    {{ $employee->sub_bagian }}
                </span>

            </div>

        </div>


        <div class="employee-profile-status">

            <span class="employee-status-dot"></span>

            <div>
                <strong>
                    Data Karyawan
                </strong>

                <small>
                    Aktif dalam sistem
                </small>
            </div>

        </div>

    </div>


    {{-- =====================================================
         INFORMASI UTAMA
    ====================================================== --}}
    <div class="employee-detail-section">

        <div class="employee-section-title">

            <div class="employee-section-number">
                01
            </div>

            <div>
                <span>
                    INFORMASI
                </span>

                <h3>
                    Data Karyawan
                </h3>
            </div>

        </div>


        <div class="employee-info-grid">

            {{-- NOPEG --}}
            <div class="employee-info-item">

                <span class="employee-info-label">
                    Nomor Pegawai
                </span>

                <strong>
                    {{ $employee->nopeg ?: '-' }}
                </strong>

            </div>


            {{-- NAMA --}}
            <div class="employee-info-item">

                <span class="employee-info-label">
                    Nama Lengkap
                </span>

                <strong>
                    {{ $employee->nama ?: '-' }}
                </strong>

            </div>


            {{-- JABATAN --}}
            <div class="employee-info-item">

                <span class="employee-info-label">
                    Jabatan
                </span>

                <strong>
                    {{ $employee->jabatan ?: '-' }}
                </strong>

            </div>


            {{-- SUB BAGIAN --}}
            <div class="employee-info-item">

                <span class="employee-info-label">
                    Sub Bagian
                </span>

                <strong>
                    {{ $employee->sub_bagian ?: '-' }}
                </strong>

            </div>

        </div>

    </div>


    {{-- =====================================================
         INFORMASI KONTAK
    ====================================================== --}}
    <div class="employee-detail-section">

        <div class="employee-section-title">

            <div class="employee-section-number">
                02
            </div>

            <div>
                <span>
                    KONTAK
                </span>

                <h3>
                    Informasi Kontak
                </h3>
            </div>

        </div>


        <div class="employee-contact-grid">

            {{-- ALAMAT --}}
            <div class="employee-contact-card">

                <div class="employee-contact-icon">
                    ⌂
                </div>

                <div>

                    <span>
                        Alamat
                    </span>

                    <strong>
                        {{ $employee->alamat ?: '-' }}
                    </strong>

                </div>

            </div>


            {{-- NOMOR HP --}}
            <div class="employee-contact-card">

                <div class="employee-contact-icon">
                    ☎
                </div>

                <div>

                    <span>
                        Nomor HP
                    </span>

                    <strong>
                        {{ $employee->no_hp ?: '-' }}
                    </strong>

                </div>

            </div>


            {{-- EMAIL --}}
            <div class="employee-contact-card">

                <div class="employee-contact-icon">
                    @
                </div>

                <div>

                    <span>
                        Email
                    </span>

                    <strong>
                        {{ $employee->email ?: '-' }}
                    </strong>

                </div>

            </div>


            {{-- PEOPLE ONCE --}}
            <div class="employee-contact-card">

                <div class="employee-contact-icon">
                    ↗
                </div>

                <div>

                    <span>
                        People Once
                    </span>

                    @if($employee->people_once_url)

                        <a
                            href="{{ $employee->people_once_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            Buka People Once →
                        </a>

                    @else

                        <strong>
                            -
                        </strong>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         DOKUMEN
    ====================================================== --}}
    <div class="employee-detail-section">

        <div class="employee-section-heading-row">

            <div class="employee-section-title">

                <div class="employee-section-number">
                    03
                </div>

                <div>

                    <span>
                        DOKUMEN
                    </span>

                    <h3>
                        Dokumen Karyawan
                    </h3>

                    <p>
                        Kelola dokumen SK, cuti, dan pensiun karyawan.
                    </p>

                </div>

            </div>


            <a
                href="{{ route('admin.documents.create', ['employee_id' => $employee->id]) }}"
                class="employee-section-action"
            >
                <span>+</span>
                Upload Dokumen
            </a>

        </div>


        @if($employee->documents->count())

            <div class="employee-document-grid">

                @foreach($employee->documents as $document)

                    <div class="employee-document-card">

                        <div class="employee-document-icon">
                            PDF
                        </div>

                        <div class="employee-document-content">

                            <span class="employee-document-type">
                                {{ strtoupper($document->type) }}
                            </span>

                            <h4>
                                {{ ucfirst($document->type) }}
                            </h4>

                            <p>
                                Dokumen karyawan
                            </p>

                        </div>

                        <a
                            href="{{ route('admin.documents.view', $document->id) }}"
                            class="employee-document-view"
                            target="_blank"
                        >
                            Lihat
                        </a>

                    </div>

                @endforeach

            </div>

        @else

            <div class="employee-empty-card">

                <div class="employee-empty-icon">
                    📄
                </div>

                <div>

                    <h4>
                        Belum ada dokumen
                    </h4>

                    <p>
                        SK, cuti, dan pensiun belum tersedia
                        untuk karyawan ini.
                    </p>

                </div>

                <a
                    href="{{ route('admin.documents.create', ['employee_id' => $employee->id]) }}"
                    class="employee-empty-action"
                >
                    Upload Dokumen
                </a>

            </div>

        @endif

    </div>


    {{-- =====================================================
         PELATIHAN
    ====================================================== --}}
    <div class="employee-detail-section">

        <div class="employee-section-heading-row">

            <div class="employee-section-title">

                <div class="employee-section-number">
                    04
                </div>

                <div>

                    <span>
                        PENGEMBANGAN
                    </span>

                    <h3>
                        Riwayat Pelatihan
                    </h3>

                    <p>
                        Riwayat pelatihan yang pernah diikuti.
                    </p>

                </div>

            </div>


            <a
                href="{{ route('admin.trainings.create', ['employee_id' => $employee->id]) }}"
                class="employee-section-action"
            >
                <span>+</span>
                Tambah Pelatihan
            </a>

        </div>


        @if($employee->trainings->count())

            <div class="employee-training-list">

                @foreach($employee->trainings as $training)

                    <div class="employee-training-item">

                        <div class="employee-training-icon">
                            🎓
                        </div>

                        <div class="employee-training-content">

                            <span class="employee-training-date">
                                {{ $training->tanggal?->format('d M Y') ?? '-' }}
                            </span>

                            <h4>
                                {{ $training->nama_pelatihan }}
                            </h4>

                            <p>
                                {{ $training->penyelenggara ?: 'Penyelenggara tidak dicantumkan' }}
                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="employee-empty-card">

                <div class="employee-empty-icon">
                    🎓
                </div>

                <div>

                    <h4>
                        Belum ada pelatihan
                    </h4>

                    <p>
                        Belum terdapat riwayat pelatihan
                        untuk karyawan ini.
                    </p>

                </div>

                <a
                    href="{{ route('admin.trainings.create', ['employee_id' => $employee->id]) }}"
                    class="employee-empty-action"
                >
                    Tambah Pelatihan
                </a>

            </div>

        @endif

    </div>


    {{-- =====================================================
         PENGHARGAAN
    ====================================================== --}}
    <div class="employee-detail-section">

        <div class="employee-section-heading-row">

            <div class="employee-section-title">

                <div class="employee-section-number">
                    05
                </div>

                <div>

                    <span>
                        APRESIASI
                    </span>

                    <h3>
                        Penghargaan
                    </h3>

                    <p>
                        Riwayat penghargaan dan apresiasi karyawan.
                    </p>

                </div>

            </div>


            <a
                href="{{ route('admin.awards.create', ['employee_id' => $employee->id]) }}"
                class="employee-section-action"
            >
                <span>+</span>
                Tambah Penghargaan
            </a>

        </div>


        @if($employee->awards->count())

            <div class="employee-award-grid">

                @foreach($employee->awards as $award)

                    <div class="employee-award-card">

                        <div class="employee-award-icon">
                            🏆
                        </div>

                        <div class="employee-award-content">

                            <span class="employee-award-year">
                                {{ $award->tahun ?? '-' }}
                            </span>

                            <h4>
                                {{ $award->nama_penghargaan }}
                            </h4>

                            <p>
                                {{ $award->keterangan ?: 'Tidak ada keterangan.' }}
                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="employee-empty-card">

                <div class="employee-empty-icon">
                    🏆
                </div>

                <div>

                    <h4>
                        Belum ada penghargaan
                    </h4>

                    <p>
                        Belum terdapat data penghargaan
                        untuk karyawan ini.
                    </p>

                </div>

                <a
                    href="{{ route('admin.awards.create', ['employee_id' => $employee->id]) }}"
                    class="employee-empty-action"
                >
                    Tambah Penghargaan
                </a>

            </div>

        @endif

    </div>


    {{-- =====================================================
         INFORMASI SISTEM
    ====================================================== --}}
    <div class="employee-system-info">

        <div>

            <span>
                DATA SISTEM
            </span>

            <strong>
                Informasi terakhir diperbarui
            </strong>

        </div>

        <div class="employee-system-date">

            <div>
                <small>
                    Dibuat
                </small>

                <strong>
                    {{ $employee->created_at?->format('d M Y, H:i') ?? '-' }}
                </strong>
            </div>

            <div>
                <small>
                    Terakhir diperbarui
                </small>

                <strong>
                    {{ $employee->updated_at?->format('d M Y, H:i') ?? '-' }}
                </strong>
            </div>

        </div>

    </div>

</div>

@endsection