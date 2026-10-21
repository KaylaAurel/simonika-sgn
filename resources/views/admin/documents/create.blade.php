@extends('layouts.admin')

@section('title', 'Upload Dokumen - SIMONIKA SGN')

@section('page_title', 'Upload Dokumen')

@section('admin-content')

<div class="document-create-page">

    {{-- HEADER --}}
    <div class="document-create-header">

        <div class="document-create-heading">

            <span class="document-create-eyebrow">
                DOKUMEN SDM
            </span>

            <h2>
                Upload Dokumen
            </h2>

            <p>
                Tambahkan dokumen resmi karyawan ke dalam sistem SIMONIKA SGN.
            </p>

        </div>

        <a
            href="{{ route('admin.documents.index') }}"
            class="document-back-button"
        >
            <span>←</span>
            Kembali
        </a>

    </div>


    {{-- ERROR VALIDATION --}}
    @if ($errors->any())

        <div class="document-alert document-alert-error">

            <div class="document-alert-icon">
                !
            </div>

            <div>

                <strong>
                    Data belum dapat disimpan
                </strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        </div>

    @endif


    {{-- FORM --}}
    <form
        action="{{ route('admin.documents.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="document-form-card"
    >

        @csrf


        {{-- SECTION 1 --}}
        <div class="document-form-section">

            <div class="document-section-heading">

                <div class="document-section-number">
                    01
                </div>

                <div>
                    <h3>
                        Informasi Dokumen
                    </h3>

                    <p>
                        Pilih karyawan dan jenis dokumen yang akan diunggah.
                    </p>
                </div>

            </div>


            <div class="document-form-grid">

                {{-- KARYAWAN --}}
                <div class="document-form-group">

                    <label for="employee_id">
                        Karyawan
                        <span>*</span>
                    </label>

                    <select
                        id="employee_id"
                        name="employee_id"
                        required
                    >

                        <option value="">
                            -- Pilih Karyawan --
                        </option>

                        @foreach($employees as $employee)

                            <option
                                value="{{ $employee->id }}"
                                @selected(old('employee_id', request('employee_id')) == $employee->id)
                            >
                                {{ $employee->nama }}
                                — {{ $employee->nopeg }}
                            </option>

                        @endforeach

                    </select>

                    <small>
                        Pilih karyawan yang memiliki dokumen ini.
                    </small>

                </div>


                {{-- JENIS DOKUMEN --}}
                <div class="document-form-group">

                    <label for="type">
                        Jenis Dokumen
                        <span>*</span>
                    </label>

                    <select
                        id="type"
                        name="type"
                        required
                    >

                        <option value="">
                            -- Pilih Jenis Dokumen --
                        </option>

                        <option
                            value="sk"
                            @selected(old('type') === 'sk')
                        >
                            SK / Surat Keputusan
                        </option>

                        <option
                            value="cuti"
                            @selected(old('type') === 'cuti')
                        >
                            Cuti
                        </option>

                        <option
                            value="pensiun"
                            @selected(old('type') === 'pensiun')
                        >
                            Pensiun
                        </option>

                    </select>

                    <small>
                        Tentukan kategori dokumen yang diupload.
                    </small>

                </div>

            </div>

        </div>


        {{-- SECTION 2 --}}
        <div class="document-form-section">

            <div class="document-section-heading">

                <div class="document-section-number">
                    02
                </div>

                <div>
                    <h3>
                        File Dokumen
                    </h3>

                    <p>
                        Upload dokumen dalam format PDF.
                    </p>
                </div>

            </div>


            <div class="document-upload-area">

                <div class="document-upload-icon">
                    PDF
                </div>

                <div class="document-upload-content">

                    <label for="file">
                        File Dokumen PDF
                        <span>*</span>
                    </label>

                    <input
                        type="file"
                        id="file"
                        name="file"
                        accept=".pdf,application/pdf"
                        required
                    >

                    <small>
                        Format yang diperbolehkan: PDF. Maksimal ukuran file 10 MB.
                    </small>

                </div>

            </div>

        </div>


        {{-- INFO --}}
        <div class="document-info-box">

            <div class="document-info-icon">
                i
            </div>

            <div>

                <strong>
                    Informasi
                </strong>

                <p>
                    Pastikan dokumen yang diupload merupakan dokumen resmi
                    dan sesuai dengan karyawan yang dipilih.
                </p>

            </div>

        </div>


        {{-- ACTION --}}
        <div class="document-form-actions">

            <a
                href="{{ route('admin.documents.index') }}"
                class="document-cancel-button"
            >
                Batal
            </a>

            <button
                type="submit"
                class="document-submit-button"
            >
                <span>↑</span>
                Upload Dokumen
            </button>

        </div>

    </form>

</div>

@endsection