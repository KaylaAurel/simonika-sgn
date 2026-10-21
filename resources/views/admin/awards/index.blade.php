@extends('layouts.admin')

@section('title', 'Penghargaan - SIMONIKA SGN')

@section('page_title', 'Penghargaan')

@section('admin-content')

<div class="award-page">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="award-page-header">

        <div class="award-page-heading">

            <span class="award-page-eyebrow">
                APRESIASI KARYAWAN
            </span>

            <h2>
                Penghargaan
            </h2>

            <p>
                Kelola data penghargaan dan penerima medali
                karyawan SGN.
            </p>

        </div>


        <a
            href="{{ route('admin.awards.create') }}"
            class="award-add-button"
        >
            <span>+</span>
            Tambah Penghargaan
        </a>

    </div>


    {{-- =========================================================
         STATISTICS
    ========================================================== --}}

    <div class="award-stat-grid">

        <div class="award-stat-card">

            <div class="award-stat-icon">
                🏆
            </div>

            <div>

                <span>
                    Total Penghargaan
                </span>

                <strong>
                    {{ $awards->total() }}
                </strong>

            </div>

        </div>


        <div class="award-stat-card">

            <div class="award-stat-icon">
                👤
            </div>

            <div>

                <span>
                    Ditampilkan
                </span>

                <strong>
                    {{ $awards->count() }}
                </strong>

            </div>

        </div>

    </div>


    {{-- =========================================================
         DATA CARD
    ========================================================== --}}

    <div class="award-data-card">


        <div class="award-data-header">

            <div>

                <span class="award-data-eyebrow">
                    DATA PENGHARGAAN
                </span>

                <h3>
                    Daftar Penghargaan
                </h3>

            </div>


            <div class="award-result-count">

                {{ $awards->total() }}

                data

            </div>

        </div>


        <div class="award-table-wrapper">

            <table class="award-table">

                <thead>

                    <tr>

                        <th>
                            Karyawan
                        </th>

                        <th>
                            Penghargaan
                        </th>

                        <th>
                            Tahun
                        </th>

                        <th>
                            Keterangan
                        </th>

                        <th class="award-action-column">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($awards as $award)

                        <tr>


                            {{-- KARYAWAN --}}

                            <td>

                                <div class="award-employee">

                                    <div class="award-employee-avatar">

                                        {{
                                            strtoupper(
                                                substr(
                                                    $award->employee->nama ?? 'K',
                                                    0,
                                                    1
                                                )
                                            )
                                        }}

                                    </div>


                                    <div>

                                        <strong>
                                            {{ $award->employee->nama ?? '-' }}
                                        </strong>

                                        <span>
                                            Nopeg:
                                            {{ $award->employee->nopeg ?? '-' }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            {{-- PENGHARGAAN --}}

                            <td>

                                <div class="award-name">

                                    <div class="award-name-icon">
                                        🏆
                                    </div>

                                    <strong>
                                        {{ $award->nama_penghargaan }}
                                    </strong>

                                </div>

                            </td>


                            {{-- TAHUN --}}

                            <td>

                                @if($award->tahun)

                                    <span class="award-year">
                                        {{ $award->tahun }}
                                    </span>

                                @else

                                    <span class="award-muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- KETERANGAN --}}

                            <td>

                                @if($award->keterangan)

                                    <div
                                        class="award-description"
                                        title="{{ $award->keterangan }}"
                                    >
                                        {{ $award->keterangan }}
                                    </div>

                                @else

                                    <span class="award-muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td>

                                <div class="award-actions">

                                    <a
                                        href="{{ route(
                                            'admin.awards.edit',
                                            $award->id
                                        ) }}"
                                        class="award-action-button award-action-edit"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route(
                                            'admin.awards.destroy',
                                            $award->id
                                        ) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="award-action-button award-action-delete"
                                            data-confirm-delete
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="award-empty-cell"
                            >

                                <div class="award-empty">

                                    <div class="award-empty-icon">
                                        🏆
                                    </div>

                                    <h3>
                                        Belum Ada Penghargaan
                                    </h3>

                                    <p>
                                        Belum terdapat data penghargaan
                                        karyawan.
                                    </p>


                                    <a
                                        href="{{ route('admin.awards.create') }}"
                                        class="award-empty-button"
                                    >
                                        + Tambah Penghargaan
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
             PAGINATION
        ====================================================== --}}

        @if($awards->hasPages())

            <div class="award-pagination">

                <div class="award-pagination-info">

                    Menampilkan

                    <strong>
                        {{ $awards->firstItem() }}
                    </strong>

                    sampai

                    <strong>
                        {{ $awards->lastItem() }}
                    </strong>

                    dari

                    <strong>
                        {{ $awards->total() }}
                    </strong>

                    data

                </div>


                <div class="award-pagination-links">

                    {{ $awards->links() }}

                </div>

            </div>

        @endif

    </div>

</div>

@endsection