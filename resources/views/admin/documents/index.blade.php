@extends('layouts.admin')

@section('title', 'Dokumen Karyawan - SIMONIKA SGN')

@section('page_title', 'Dokumen Karyawan')

@section('admin-content')

<div class="document-page">

    {{-- HEADER --}}
    <div class="document-page-header">

        <div class="document-page-heading">

            <span class="document-page-eyebrow">
                DOKUMEN SDM
            </span>

            <h2>
                Dokumen Karyawan
            </h2>

            <p>
                Kelola SK, dokumen cuti, dan dokumen pensiun karyawan
                secara terpusat melalui SIMONIKA SGN.
            </p>

        </div>

        <a
            href="{{ route('admin.documents.create') }}"
            class="document-upload-button"
        >
            <span class="document-upload-button-icon">
                +
            </span>

            Upload Dokumen
        </a>

    </div>


    {{-- STATISTICS --}}
    <div class="document-stats">

        {{-- TOTAL --}}
        <div class="document-stat-card">

            <div class="document-stat-icon document-stat-icon-total">
                <span>▣</span>
            </div>

            <div class="document-stat-content">

                <span>
                    TOTAL DOKUMEN
                </span>

                <strong>
                    {{ $documents->total() }}
                </strong>

                <small>
                    Seluruh dokumen karyawan
                </small>

            </div>

        </div>


        {{-- SK --}}
        <div class="document-stat-card">

            <div class="document-stat-icon document-stat-icon-sk">
                <span>SK</span>
            </div>

            <div class="document-stat-content">

                <span>
                    SURAT KEPUTUSAN
                </span>

                <strong>
                    {{ $documents->getCollection()->where('type', 'sk')->count() }}
                </strong>

                <small>
                    SK pada halaman ini
                </small>

            </div>

        </div>


        {{-- CUTI --}}
        <div class="document-stat-card">

            <div class="document-stat-icon document-stat-icon-cuti">
                <span>C</span>
            </div>

            <div class="document-stat-content">

                <span>
                    DOKUMEN CUTI
                </span>

                <strong>
                    {{ $documents->getCollection()->where('type', 'cuti')->count() }}
                </strong>

                <small>
                    Dokumen cuti pada halaman ini
                </small>

            </div>

        </div>


        {{-- PENSIUN --}}
        <div class="document-stat-card">

            <div class="document-stat-icon document-stat-icon-pensiun">
                <span>P</span>
            </div>

            <div class="document-stat-content">

                <span>
                    DOKUMEN PENSIUN
                </span>

                <strong>
                    {{ $documents->getCollection()->where('type', 'pensiun')->count() }}
                </strong>

                <small>
                    Dokumen pensiun pada halaman ini
                </small>

            </div>

        </div>

    </div>


    {{-- DATA CARD --}}
    <div class="document-data-card">

        {{-- CARD HEADER --}}
        <div class="document-data-header">

            <div>

                <span class="document-data-eyebrow">
                    ARSIP DOKUMEN
                </span>

                <h3>
                    Daftar Dokumen Karyawan
                </h3>

            </div>

            <div class="document-result-count">

                <strong>
                    {{ $documents->total() }}
                </strong>

                <span>
                    dokumen
                </span>

            </div>

        </div>


        {{-- TABLE --}}
        <div class="document-table-wrapper">

            <table class="document-table">

                <thead>

                    <tr>

                        <th>
                            Karyawan
                        </th>

                        <th>
                            Jenis Dokumen
                        </th>

                        <th>
                            Nama File
                        </th>

                        <th>
                            Upload
                        </th>

                        <th class="document-action-heading">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($documents as $document)

                        <tr>

                            {{-- KARYAWAN --}}
                            <td>

                                <div class="document-employee">

                                    <div class="document-employee-avatar">

                                        <img
                                            src="{{ $document->employee->photo_url }}"
                                            alt="{{ $document->employee->nama }}"
                                        >

                                    </div>

                                    <div class="document-employee-info">

                                        <strong>
                                            {{ $document->employee->nama }}
                                        </strong>

                                        <span>
                                            {{ $document->employee->nopeg }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            {{-- JENIS --}}
                            <td>

                                @if($document->type === 'sk')

                                    <span class="document-type-badge document-type-sk">
                                        <span>SK</span>
                                        Surat Keputusan
                                    </span>

                                @elseif($document->type === 'cuti')

                                    <span class="document-type-badge document-type-cuti">
                                        <span>C</span>
                                        Cuti
                                    </span>

                                @elseif($document->type === 'pensiun')

                                    <span class="document-type-badge document-type-pensiun">
                                        <span>P</span>
                                        Pensiun
                                    </span>

                                @else

                                    <span class="document-type-badge document-type-other">
                                        Dokumen
                                    </span>

                                @endif

                            </td>


                            {{-- FILE --}}
                            <td>

                                <div class="document-file">

                                    <div class="document-file-icon">
                                        PDF
                                    </div>

                                    <div class="document-file-info">

                                        <strong
                                            title="{{ $document->original_name }}"
                                        >
                                            {{ $document->original_name }}
                                        </strong>

                                        <span>
                                            Dokumen PDF
                                        </span>

                                    </div>

                                </div>

                            </td>


                            {{-- DATE --}}
                            <td>

                                <div class="document-date">

                                    <strong>
                                        {{ $document->created_at->format('d M Y') }}
                                    </strong>

                                    <span>
                                        {{ $document->created_at->format('H:i') }}
                                    </span>

                                </div>

                            </td>


                            {{-- ACTION --}}
                            <td>

                                <div class="document-actions">

                                    <a
                                        href="{{ route('admin.documents.view', $document->id) }}"
                                        class="document-action document-action-view"
                                        title="Lihat dokumen"
                                    >
                                        <span>◉</span>
                                        Lihat
                                    </a>


                                    <a
                                        href="{{ route('admin.documents.edit', $document->id) }}"
                                        class="document-action document-action-edit"
                                        title="Edit dokumen"
                                    >
                                        <span>✎</span>
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route('admin.documents.destroy', $document->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="document-action document-action-delete"
                                            title="Hapus dokumen"
                                        >
                                            <span>×</span>
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
                                class="document-empty-cell"
                            >

                                <div class="document-empty">

                                    <div class="document-empty-icon">
                                        PDF
                                    </div>

                                    <h3>
                                        Belum Ada Dokumen
                                    </h3>

                                    <p>
                                        Belum terdapat dokumen karyawan
                                        yang tersimpan di dalam sistem.
                                    </p>

                                    <a
                                        href="{{ route('admin.documents.create') }}"
                                        class="document-empty-button"
                                    >
                                        + Upload Dokumen
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($documents->hasPages())

            <div class="document-pagination">

                <div class="document-pagination-info">

                    Menampilkan

                    <strong>
                        {{ $documents->firstItem() }}
                    </strong>

                    sampai

                    <strong>
                        {{ $documents->lastItem() }}
                    </strong>

                    dari

                    <strong>
                        {{ $documents->total() }}
                    </strong>

                    dokumen

                </div>

                <div class="document-pagination-links">
                    {{ $documents->links() }}
                </div>

            </div>

        @endif

    </div>

</div>

@endsection