@extends('layouts.admin')

@section('title', 'Edit Dokumen - SIMONIKA SGN')

@section('page_title', 'Edit Dokumen')

@section('admin-content')

<div class="document-edit-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="document-edit-header">

        <div class="document-edit-heading">

            <span class="document-edit-eyebrow">
                DOKUMEN SDM
            </span>

            <h2>
                Edit Dokumen
            </h2>

            <p>
                Perbarui informasi dan file dokumen karyawan
                {{ $document->employee->nama }}.
            </p>

        </div>


        <a
            href="{{ route('admin.documents.index') }}"
            class="document-edit-back"
        >
            <span>←</span>
            Kembali
        </a>

    </div>


    {{-- =====================================================
         FORM
    ====================================================== --}}

    <form
        action="{{ route('admin.documents.update', $document->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="document-edit-form"
    >

        @csrf
        @method('PUT')


        {{-- =================================================
             INFORMASI DOKUMEN
        ================================================== --}}

        <div class="document-edit-card">


            {{-- CARD HEADER --}}
            <div class="document-edit-card-header">

                <div class="document-edit-card-icon">
                    📄
                </div>

                <div>

                    <h3>
                        Informasi Dokumen
                    </h3>

                    <p>
                        Periksa data dokumen sebelum melakukan perubahan.
                    </p>

                </div>

            </div>


            {{-- FORM CONTENT --}}
            <div class="document-edit-form-grid">


                {{-- =================================================
                     KARYAWAN
                ================================================== --}}

                <div class="document-edit-form-group">

                    <label>
                        Karyawan
                    </label>


                    {{-- PENTING:
                         employee_id harus tetap dikirim
                         ke controller ketika form disubmit.
                    --}}
                    <input
                        type="hidden"
                        name="employee_id"
                        value="{{ $document->employee_id }}"
                    >


                    <div class="document-employee-box">

                        <div class="document-employee-avatar">

                            {{ strtoupper(
                                substr(
                                    $document->employee->nama ?? 'K',
                                    0,
                                    1
                                )
                            ) }}

                        </div>


                        <div class="document-employee-info">

                            <strong>
                                {{ $document->employee->nama }}
                            </strong>

                            <span>
                                Nopeg:
                                {{ $document->employee->nopeg }}
                            </span>

                        </div>

                    </div>


                    @error('employee_id')

                        <small class="document-edit-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- =================================================
                     JENIS DOKUMEN
                ================================================== --}}

                <div class="document-edit-form-group">

                    <label for="type">

                        Jenis Dokumen

                        <span class="required">
                            *
                        </span>

                    </label>


                    <select
                        id="type"
                        name="type"
                        required
                    >

                        <option
                            value="sk"
                            @selected(
                                old('type', $document->type) === 'sk'
                            )
                        >
                            SK
                        </option>

                        <option
                            value="cuti"
                            @selected(
                                old('type', $document->type) === 'cuti'
                            )
                        >
                            Cuti
                        </option>

                        <option
                            value="pensiun"
                            @selected(
                                old('type', $document->type) === 'pensiun'
                            )
                        >
                            Pensiun
                        </option>

                    </select>


                    @error('type')

                        <small class="document-edit-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- =================================================
                     FILE SAAT INI
                ================================================== --}}

                <div
                    class="document-edit-form-group document-edit-full"
                >

                    <label>
                        File Saat Ini
                    </label>


                    <div class="document-current-file">

                        <div class="document-current-file-icon">
                            PDF
                        </div>


                        <div class="document-current-file-info">

                            <strong>
                                {{ $document->original_name ?: 'Dokumen PDF' }}
                            </strong>

                            <span>
                                Diunggah
                                {{ $document->created_at->format('d M Y') }}
                            </span>

                        </div>


                        <a
                            href="{{ route('admin.documents.view', $document->id) }}"
                            target="_blank"
                            class="document-current-view"
                        >
                            Lihat
                        </a>

                    </div>

                </div>


                {{-- =================================================
                     GANTI FILE
                ================================================== --}}

                <div
                    class="document-edit-form-group document-edit-full"
                >

                    <label for="file">

                        Ganti File

                        <span class="optional">
                            Opsional
                        </span>

                    </label>


                    {{-- FILE UPLOAD AREA --}}
                    <div
                        class="document-file-upload"
                        id="documentFileUpload"
                    >

                        {{-- INPUT FILE --}}
                        <input
                            type="file"
                            id="file"
                            name="file"
                            accept=".pdf,application/pdf"
                        >


                        {{-- TAMPILAN DEFAULT --}}
                        <div
                            class="document-file-upload-content"
                            id="documentUploadDefault"
                        >

                            <div class="document-upload-icon">
                                ↑
                            </div>

                            <strong>
                                Pilih file PDF baru
                            </strong>

                            <span>
                                Klik area ini untuk memilih file
                            </span>

                        </div>


                        {{-- =================================================
                             FILE YANG BARU DIPILIH
                        ================================================== --}}

                        <div
                            class="document-selected-file"
                            id="documentSelectedFile"
                        >

                            <div class="document-selected-file-icon">
                                PDF
                            </div>


                            <div class="document-selected-file-info">

                                <strong id="selectedFileName">
                                    Nama file
                                </strong>

                                <span id="selectedFileSize">
                                    Ukuran file
                                </span>

                            </div>


                            <button
                                type="button"
                                class="document-remove-file"
                                id="removeSelectedFile"
                                title="Hapus file yang dipilih"
                            >
                                ×
                            </button>

                        </div>

                    </div>


                    {{-- =================================================
                         PREVIEW PDF BARU
                    ================================================== --}}

                    <div
                        class="document-pdf-preview"
                        id="documentPdfPreview"
                    >

                        <div class="document-pdf-preview-header">

                            <div>

                                <strong>
                                    Preview PDF Baru
                                </strong>

                                <span>
                                    Dokumen ini belum disimpan.
                                    Preview hanya untuk pemeriksaan.
                                </span>

                            </div>

                        </div>


                        <iframe
                            id="documentPdfFrame"
                            title="Preview PDF Baru"
                        ></iframe>

                    </div>


                    {{-- HINT --}}
                    <small class="document-edit-hint">

                        Kosongkan jika tidak ingin mengganti file.

                        Format PDF, maksimal 10 MB.

                    </small>


                    @error('file')

                        <small class="document-edit-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>

            </div>

        </div>


        {{-- =====================================================
             ACTION BUTTON
        ====================================================== --}}

        <div class="document-edit-actions">

            <a
                href="{{ route('admin.documents.index') }}"
                class="document-edit-cancel"
            >
                Batal
            </a>


            <button
                type="submit"
                class="document-edit-submit"
            >

                <span>
                    ✓
                </span>

                Simpan Perubahan

            </button>

        </div>

    </form>

</div>

@endsection