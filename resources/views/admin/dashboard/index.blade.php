@extends('layouts.admin')

@section('title', 'Dashboard Admin - SIMONIKA SGN')

@section('page_title', 'Dashboard')

@section('admin-content')

<div class="dashboard-page">

    {{-- =====================================================
         WELCOME
    ====================================================== --}}
    <section class="dashboard-welcome">

        <div class="dashboard-welcome-content">

            <span class="dashboard-eyebrow">
                ADMIN SDM
            </span>

            <h1>
                Selamat Datang di SIMONIKA
            </h1>

            <p>
                Kelola dan monitor informasi karyawan
                PT Sinergi Gula Nusantara melalui
                satu sistem terintegrasi.
            </p>

        </div>

        <div class="dashboard-welcome-icon">
            <span>SGN</span>
        </div>

    </section>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}
    <section class="dashboard-stat-grid">

        {{-- Total Karyawan --}}
        <div class="dashboard-stat-card">

            <div class="dashboard-stat-icon">
                👥
            </div>

            <div class="dashboard-stat-content">

                <span>
                    Total Karyawan
                </span>

                <strong>
                    {{ $totalEmployees }}
                </strong>

            </div>

        </div>


        {{-- Total Dokumen --}}
        <div class="dashboard-stat-card">

            <div class="dashboard-stat-icon">
                📄
            </div>

            <div class="dashboard-stat-content">

                <span>
                    Dokumen Karyawan
                </span>

                <strong>
                    {{ $totalDocuments }}
                </strong>

            </div>

        </div>


        {{-- Total Pelatihan --}}
        <div class="dashboard-stat-card">

            <div class="dashboard-stat-icon">
                🎓
            </div>

            <div class="dashboard-stat-content">

                <span>
                    Riwayat Pelatihan
                </span>

                <strong>
                    {{ $totalTrainings }}
                </strong>

            </div>

        </div>


        {{-- Total Penghargaan --}}
        <div class="dashboard-stat-card">

            <div class="dashboard-stat-icon">
                🏆
            </div>

            <div class="dashboard-stat-content">

                <span>
                    Penghargaan
                </span>

                <strong>
                    {{ $totalAwards }}
                </strong>

            </div>

        </div>

    </section>


    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}
    <section class="dashboard-main-grid">


        {{-- =================================================
             KARYAWAN TERBARU
        ================================================== --}}
        <div class="dashboard-panel">

            <div class="dashboard-panel-header">

                <div>

                    <span class="dashboard-panel-eyebrow">
                        DATA TERBARU
                    </span>

                    <h2>
                        Karyawan Terbaru
                    </h2>

                </div>

                <a
                    href="{{ route('admin.employees.index') }}"
                    class="dashboard-panel-link"
                >
                    Lihat Semua
                    <span>→</span>
                </a>

            </div>


            @if($recentEmployees->count() > 0)

                <div class="recent-employee-list">

                    @foreach($recentEmployees as $employee)

                        <div class="recent-employee-item">

                            {{-- Foto --}}
                            <div class="recent-employee-avatar">

                                @if($employee->foto)

                                    <img
                                        src="{{ $employee->photo_url }}"
                                        alt="{{ $employee->nama }}"
                                    >

                                @else

                                    <span>
                                        {{ strtoupper(substr($employee->nama, 0, 1)) }}
                                    </span>

                                @endif

                            </div>


                            {{-- Informasi --}}
                            <div class="recent-employee-info">

                                <strong>
                                    {{ $employee->nama }}
                                </strong>

                                <span>
                                    Nopeg: {{ $employee->nopeg }}
                                </span>

                                <small>
                                    {{ $employee->jabatan }}
                                </small>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                {{-- Empty State --}}
                <div class="dashboard-empty">

                    <div class="dashboard-empty-icon">
                        👥
                    </div>

                    <h3>
                        Belum Ada Data Karyawan
                    </h3>

                    <p>
                        Data karyawan yang ditambahkan
                        oleh Admin SDM akan muncul di sini.
                    </p>

                    <a
                        href="{{ route('admin.employees.create') }}"
                        class="dashboard-empty-button"
                    >
                        <span>+</span>
                        Tambah Karyawan
                    </a>

                </div>

            @endif

        </div>


        {{-- =================================================
             AKSES CEPAT
        ================================================== --}}
        <div class="dashboard-panel">

            <div class="dashboard-panel-header">

                <div>

                    <span class="dashboard-panel-eyebrow">
                        AKSES CEPAT
                    </span>

                    <h2>
                        Menu Utama
                    </h2>

                </div>

            </div>


            <div class="dashboard-quick-menu">


                {{-- Tambah Karyawan --}}
                <a
                    href="{{ route('admin.employees.create') }}"
                    class="dashboard-quick-item"
                >

                    <span class="quick-item-icon">
                        👤
                    </span>

                    <span class="quick-item-content">

                        <strong>
                            Tambah Karyawan
                        </strong>

                        <small>
                            Tambahkan data karyawan baru
                        </small>

                    </span>

                    <b>
                        →
                    </b>

                </a>


                {{-- Tambah Dokumen --}}
                <a
                    href="{{ route('admin.documents.create') }}"
                    class="dashboard-quick-item"
                >

                    <span class="quick-item-icon">
                        📄
                    </span>

                    <span class="quick-item-content">

                        <strong>
                            Tambah Dokumen
                        </strong>

                        <small>
                            Upload SK, cuti, atau pensiun
                        </small>

                    </span>

                    <b>
                        →
                    </b>

                </a>


                {{-- Tambah Pelatihan --}}
                <a
                    href="{{ route('admin.trainings.create') }}"
                    class="dashboard-quick-item"
                >

                    <span class="quick-item-icon">
                        🎓
                    </span>

                    <span class="quick-item-content">

                        <strong>
                            Tambah Pelatihan
                        </strong>

                        <small>
                            Catat riwayat pelatihan karyawan
                        </small>

                    </span>

                    <b>
                        →
                    </b>

                </a>


                {{-- Tambah Penghargaan --}}
                <a
                    href="{{ route('admin.awards.create') }}"
                    class="dashboard-quick-item"
                >

                    <span class="quick-item-icon">
                        🏆
                    </span>

                    <span class="quick-item-content">

                        <strong>
                            Tambah Penghargaan
                        </strong>

                        <small>
                            Catat penghargaan karyawan
                        </small>

                    </span>

                    <b>
                        →
                    </b>

                </a>

            </div>

        </div>

    </section>

</div>

@endsection