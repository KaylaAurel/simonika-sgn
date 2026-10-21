@extends('layouts.admin')

@section('title', 'Pelatihan - SIMONIKA SGN')

@section('page_title', 'Pelatihan')

@section('admin-content')

<div class="training-index-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="training-index-header">

        <div class="training-index-heading">

            <span class="training-index-eyebrow">
                PENGEMBANGAN SDM
            </span>

            <h2>
                Riwayat Pelatihan
            </h2>

            <p>
                Kelola riwayat pelatihan dan pengembangan kompetensi karyawan.
            </p>

        </div>

        <a
            href="{{ route('admin.trainings.create') }}"
            class="training-add-button"
        >

            <span class="training-add-icon">
                +
            </span>

            Tambah Pelatihan

        </a>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="training-stat-grid">

        <div class="training-stat-card">

            <div class="training-stat-icon">
                🎓
            </div>

            <div>

                <span>
                    TOTAL PELATIHAN
                </span>

                <strong>
                    {{ $trainings->total() }}
                </strong>

            </div>

        </div>


        <div class="training-stat-card">

            <div class="training-stat-icon">
                👥
            </div>

            <div>

                <span>
                    KARYAWAN TERDATA
                </span>

                <strong>
                    {{ $trainings->pluck('employee_id')->unique()->count() }}
                </strong>

            </div>

        </div>

    </div>


    {{-- =====================================================
         DATA CARD
    ====================================================== --}}

    <div class="training-data-card">


        {{-- DATA HEADER --}}

        <div class="training-data-header">

            <div>

                <span class="training-data-eyebrow">
                    DATA PELATIHAN
                </span>

                <h3>
                    Daftar Riwayat Pelatihan
                </h3>

            </div>

            <div class="training-result-count">

                Menampilkan
                <strong>
                    {{ $trainings->count() }}
                </strong>
                dari
                <strong>
                    {{ $trainings->total() }}
                </strong>
                data

            </div>

        </div>


        {{-- TABLE --}}

        <div class="training-table-wrapper">

            <table class="training-table">

                <thead>

                    <tr>

                        <th>
                            KARYAWAN
                        </th>

                        <th>
                            PELATIHAN
                        </th>

                        <th>
                            PENYELENGGARA
                        </th>

                        <th>
                            TANGGAL
                        </th>

                        <th class="training-action-column">
                            AKSI
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($trainings as $training)

                        <tr>

                            {{-- KARYAWAN --}}

                            <td>

                                <div class="training-employee">

                                    <div class="training-employee-avatar">

                                        {{ strtoupper(
                                            substr(
                                                $training->employee->nama ?? 'K',
                                                0,
                                                1
                                            )
                                        ) }}

                                    </div>

                                    <div>

                                        <strong>
                                            {{ $training->employee->nama ?? '-' }}
                                        </strong>

                                        <span>
                                            Nopeg:
                                            {{ $training->employee->nopeg ?? '-' }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            {{-- PELATIHAN --}}

                            <td>

                                <div class="training-name">

                                    <strong>
                                        {{ $training->nama_pelatihan }}
                                    </strong>

                                    @if($training->keterangan)

                                        <span>
                                            {{ \Illuminate\Support\Str::limit(
                                                $training->keterangan,
                                                70
                                            ) }}
                                        </span>

                                    @endif

                                </div>

                            </td>


                            {{-- PENYELENGGARA --}}

                            <td>

                                <span class="training-organizer">

                                    {{ $training->penyelenggara ?: '-' }}

                                </span>

                            </td>


                            {{-- TANGGAL --}}

                            <td>

                                @if($training->tanggal)

                                    <span class="training-date">

                                        {{ $training->tanggal->format('d M Y') }}

                                    </span>

                                @else

                                    <span class="training-date-empty">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td>

                                <div class="training-actions">

                                    <a
                                        href="{{ route(
                                            'admin.trainings.edit',
                                            $training->id
                                        ) }}"
                                        class="training-action training-action-edit"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route(
                                            'admin.trainings.destroy',
                                            $training->id
                                        ) }}"
                                        method="POST"
                                        onsubmit="return confirm(
                                            'Apakah Anda yakin ingin menghapus data pelatihan ini?'
                                        );"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="training-action training-action-delete"
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
                                class="training-empty-cell"
                            >

                                <div class="training-empty">

                                    <div class="training-empty-icon">
                                        🎓
                                    </div>

                                    <h3>
                                        Belum Ada Data Pelatihan
                                    </h3>

                                    <p>
                                        Belum terdapat riwayat pelatihan
                                        karyawan di dalam sistem.
                                    </p>

                                    <a
                                        href="{{ route(
                                            'admin.trainings.create'
                                        ) }}"
                                        class="training-empty-button"
                                    >
                                        + Tambah Pelatihan
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             PAGINATION
        ================================================== --}}

        @if($trainings->hasPages())

            <div class="training-pagination">

                <div class="training-pagination-info">

                    Menampilkan

                    <strong>
                        {{ $trainings->firstItem() }}
                    </strong>

                    sampai

                    <strong>
                        {{ $trainings->lastItem() }}
                    </strong>

                    dari

                    <strong>
                        {{ $trainings->total() }}
                    </strong>

                    pelatihan

                </div>

                <div class="training-pagination-links">

                    {{ $trainings->links() }}

                </div>

            </div>

        @endif

    </div>

</div>

@endsection