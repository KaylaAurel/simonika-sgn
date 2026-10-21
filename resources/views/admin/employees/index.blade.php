@extends('layouts.admin')

@section('title', 'Data Karyawan - SIMONIKA SGN')

@section('page_title', 'Data Karyawan')

@section('admin-content')

<div class="employee-page">

    {{-- =====================================================
         HEADER HALAMAN
    ====================================================== --}}

    <div class="employee-page-header">

        <div class="employee-page-heading">

            <span class="employee-page-eyebrow">
                MANAJEMEN SDM
            </span>

            <h1>
                Data Karyawan
            </h1>

            <p>
                Kelola informasi karyawan PT Sinergi Gula Nusantara
                secara terstruktur melalui SIMONIKA.
            </p>

        </div>


        <a
            href="{{ route('admin.employees.create') }}"
            class="employee-add-button"
        >
            <span class="employee-add-icon">
                +
            </span>

            <span>
                Tambah Karyawan
            </span>
        </a>

    </div>


    {{-- =====================================================
         STATISTIK
    ====================================================== --}}

    <div class="employee-mini-stats">

        {{-- Total Karyawan --}}
        <div class="employee-mini-stat">

            <div class="employee-mini-icon">
                👥
            </div>

            <div>

                <span>
                    Total Karyawan
                </span>

                <strong>
                    {{ $employees->total() }}
                </strong>

            </div>

        </div>


        {{-- Hasil Ditampilkan --}}
        <div class="employee-mini-stat">

            <div class="employee-mini-icon">
                🔎
            </div>

            <div>

                <span>
                    Ditampilkan
                </span>

                <strong>
                    {{ $employees->count() }}
                </strong>

            </div>

        </div>


        {{-- Sub Bagian --}}
        <div class="employee-mini-stat">

            <div class="employee-mini-icon">
                🏢
            </div>

            <div>

                <span>
                    Sub Bagian
                </span>

                <strong>
                    {{ $subBagians->count() }}
                </strong>

            </div>

        </div>


        {{-- Jabatan --}}
        <div class="employee-mini-stat">

            <div class="employee-mini-icon">
                💼
            </div>

            <div>

                <span>
                    Jabatan
                </span>

                <strong>
                    {{ $jabatans->count() }}
                </strong>

            </div>

        </div>

    </div>


    {{-- =====================================================
         SEARCH & FILTER
    ====================================================== --}}

    <div class="employee-filter-card">

        <div class="employee-filter-heading">

            <div class="employee-filter-title">

                <div class="employee-filter-title-icon">
                    ⌕
                </div>

                <div>

                    <strong>
                        Cari & Filter Karyawan
                    </strong>

                    <span>
                        Temukan data berdasarkan nama, nopeg,
                        jabatan, atau sub bagian.
                    </span>

                </div>

            </div>

        </div>


        <form
            action="{{ route('admin.employees.index') }}"
            method="GET"
            class="employee-filter-form"
        >

            {{-- SEARCH --}}

            <div class="employee-search-wrapper">

                <label for="search">
                    Pencarian
                </label>

                <div class="employee-search-box">

                    <span class="employee-search-icon">
                        🔍
                    </span>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama, nopeg, jabatan, email..."
                    >

                </div>

            </div>


            {{-- JABATAN --}}

            <div class="employee-filter-field">

                <label for="jabatan">
                    Jabatan
                </label>

                <select
                    name="jabatan"
                    id="jabatan"
                >

                    <option value="">
                        Semua Jabatan
                    </option>

                    @foreach($jabatans as $jabatan)

                        <option
                            value="{{ $jabatan }}"
                            @selected(request('jabatan') === $jabatan)
                        >
                            {{ $jabatan }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- SUB BAGIAN --}}

            <div class="employee-filter-field">

                <label for="sub_bagian">
                    Sub Bagian
                </label>

                <select
                    name="sub_bagian"
                    id="sub_bagian"
                >

                    <option value="">
                        Semua Sub Bagian
                    </option>

                    @foreach($subBagians as $subBagian)

                        <option
                            value="{{ $subBagian }}"
                            @selected(request('sub_bagian') === $subBagian)
                        >
                            {{ $subBagian }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- BUTTON --}}

            <div class="employee-filter-actions">

                <button
                    type="submit"
                    class="employee-search-button"
                >
                    <span>🔍</span>
                    Cari
                </button>


                @if(request()->hasAny([
                    'search',
                    'jabatan',
                    'sub_bagian'
                ]))

                    <a
                        href="{{ route('admin.employees.index') }}"
                        class="employee-reset-button"
                    >
                        Reset
                    </a>

                @endif

            </div>

        </form>

    </div>


    {{-- =====================================================
         DATA KARYAWAN
    ====================================================== --}}

    <div class="employee-data-card">

        {{-- HEADER TABLE --}}

        <div class="employee-data-header">

            <div>

                <span class="employee-data-eyebrow">
                    DATABASE KARYAWAN
                </span>

                <h2>
                    Daftar Karyawan
                </h2>

            </div>


            <div class="employee-result-count">

                <strong>
                    {{ $employees->total() }}
                </strong>

                <span>
                    karyawan
                </span>

            </div>

        </div>


        {{-- =================================================
             JIKA ADA DATA
        ================================================== --}}

        @if($employees->count() > 0)

            <div class="employee-table-wrapper">

                <table class="employee-table">

                    <thead>

                        <tr>

                            <th>
                                Karyawan
                            </th>

                            <th>
                                No. Pegawai
                            </th>

                            <th>
                                Jabatan
                            </th>

                            <th>
                                Sub Bagian
                            </th>

                            <th class="employee-action-column">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($employees as $employee)

                            <tr>

                                {{-- ==========================
                                     PROFIL
                                =========================== --}}

                                <td>

                                    <div class="employee-profile-cell">

                                        <div class="employee-avatar">

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


                                        <div class="employee-profile-info">

                                            <strong>
                                                {{ $employee->nama }}
                                            </strong>


                                            @if($employee->email)

                                                <span>
                                                    {{ $employee->email }}
                                                </span>

                                            @else

                                                <span class="employee-no-data">
                                                    Email belum tersedia
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- ==========================
                                     NOPEG
                                =========================== --}}

                                <td>

                                    <span class="employee-nopeg">
                                        {{ $employee->nopeg }}
                                    </span>

                                </td>


                                {{-- ==========================
                                     JABATAN
                                =========================== --}}

                                <td>

                                    <span class="employee-position">
                                        {{ $employee->jabatan ?: '-' }}
                                    </span>

                                </td>


                                {{-- ==========================
                                     SUB BAGIAN
                                =========================== --}}

                                <td>

                                    @if($employee->sub_bagian)

                                        <span class="employee-department">
                                            {{ $employee->sub_bagian }}
                                        </span>

                                    @else

                                        <span class="employee-no-data">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- ==========================
                                     AKSI
                                =========================== --}}

                                <td>

                                    <div class="employee-actions">

                                        {{-- DETAIL --}}

                                        <a
                                            href="{{ route('admin.employees.show', $employee) }}"
                                            class="employee-action-button employee-action-view"
                                            title="Lihat detail"
                                        >
                                            👁
                                        </a>


                                        {{-- EDIT --}}

                                        <a
                                            href="{{ route('admin.employees.edit', $employee) }}"
                                            class="employee-action-button employee-action-edit"
                                            title="Edit data"
                                        >
                                            ✎
                                        </a>


                                        {{-- HAPUS --}}

                                        <form
                                            action="{{ route('admin.employees.destroy', $employee) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data {{ $employee->nama }}?')"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="employee-action-button employee-action-delete"
                                                title="Hapus data"
                                            >
                                                🗑
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- =================================================
                 PAGINATION
            ================================================== --}}

            @if($employees->hasPages())

                <div class="employee-pagination">

                    <div class="employee-pagination-info">

                        Menampilkan

                        <strong>
                            {{ $employees->firstItem() }}
                        </strong>

                        -

                        <strong>
                            {{ $employees->lastItem() }}
                        </strong>

                        dari

                        <strong>
                            {{ $employees->total() }}
                        </strong>

                        karyawan

                    </div>


                    <div class="employee-pagination-links">

                        {{ $employees->links() }}

                    </div>

                </div>

            @endif


        {{-- =================================================
             EMPTY STATE
        ================================================== --}}

        @else

            <div class="employee-empty">

                <div class="employee-empty-icon">
                    👥
                </div>


                <h3>

                    @if(request()->hasAny([
                        'search',
                        'jabatan',
                        'sub_bagian'
                    ]))

                        Data Tidak Ditemukan

                    @else

                        Belum Ada Data Karyawan

                    @endif

                </h3>


                <p>

                    @if(request()->hasAny([
                        'search',
                        'jabatan',
                        'sub_bagian'
                    ]))

                        Tidak ada karyawan yang sesuai
                        dengan pencarian atau filter yang digunakan.

                    @else

                        Belum ada data karyawan yang
                        ditambahkan ke dalam sistem.

                    @endif

                </p>


                @if(request()->hasAny([
                    'search',
                    'jabatan',
                    'sub_bagian'
                ]))

                    <a
                        href="{{ route('admin.employees.index') }}"
                        class="employee-empty-button"
                    >
                        Reset Pencarian
                    </a>

                @else

                    <a
                        href="{{ route('admin.employees.create') }}"
                        class="employee-empty-button"
                    >
                        + Tambah Karyawan
                    </a>

                @endif

            </div>

        @endif

    </div>

</div>

@endsection