@extends('layouts.admin')

@section('title', 'Upload Slip Gaji - SIMONIKA SGN')

@section('page_title', 'Upload Slip Gaji')

@section('admin-content')

<div class="salary-page">

    {{-- HEADER --}}
    <div class="salary-page-header">
        <div>
            <span class="salary-eyebrow">MANAJEMEN SLIP GAJI</span>

            <h1>Upload Slip Gaji</h1>

            <p>
                Upload slip gaji karyawan dalam format PDF untuk disimpan
                dan diproses melalui sistem SIMONIKA SGN.
            </p>
        </div>

        <a
            href="{{ route('admin.salary-slips.index') }}"
            class="salary-back-button"
        >
            <span>←</span>
            Kembali
        </a>
    </div>


    {{-- FORM --}}
    <div class="salary-upload-layout">

        <div class="salary-upload-card">

            <div class="salary-card-heading">
                <div class="salary-card-icon">
                    ↑
                </div>

                <div>
                    <h2>Data Slip Gaji</h2>
                    <p>
                        Lengkapi data berikut sebelum mengunggah file.
                    </p>
                </div>
            </div>


            <form
                action="{{ route('admin.salary-slips.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                {{-- ERROR --}}
                @if ($errors->any())
                    <div class="salary-alert salary-alert-error">
                        <strong>Periksa kembali data yang dimasukkan.</strong>

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                {{-- SUCCESS --}}
                @if (session('success'))
                    <div class="salary-alert salary-alert-success">
                        {{ session('success') }}
                    </div>
                @endif


                {{-- KARYAWAN --}}
                <div class="salary-form-group">

                    <label for="employee_id">
                        Karyawan
                        <span>*</span>
                    </label>

                    <select
                        name="employee_id"
                        id="employee_id"
                        class="salary-form-control"
                        required
                    >

                        <option value="">
                            Pilih karyawan
                        </option>

                        @foreach ($employees as $employee)

                            <option
                                value="{{ $employee->id }}"
                                {{ old('employee_id') == $employee->id ? 'selected' : '' }}
                            >
                                {{ $employee->nama }}
                                — {{ $employee->nopeg }}
                            </option>

                        @endforeach

                    </select>

                    <small>
                        Pilih karyawan yang menerima slip gaji ini.
                    </small>

                </div>


                {{-- PERIODE --}}
                <div class="salary-form-group">

                    <label for="periode">
                        Periode Gaji
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        name="periode"
                        id="periode"
                        class="salary-form-control"
                        value="{{ old('periode') }}"
                        placeholder="Contoh: September 2026"
                        required
                    >

                    <small>
                        Masukkan periode sesuai bulan slip gaji.
                    </small>

                </div>


                {{-- FILE --}}
                <div class="salary-form-group">

                    <label for="file">
                        File Slip Gaji
                        <span>*</span>
                    </label>

                    <div class="salary-file-wrapper">

                        <input
                            type="file"
                            name="file"
                            id="file"
                            class="salary-file-input"
                            accept=".pdf,application/pdf"
                            required
                        >

                        <div class="salary-file-content">

                            <div class="salary-file-icon">
                                PDF
                            </div>

                            <div>
                                <strong id="file-name">
                                    Pilih file slip gaji
                                </strong>

                                <span>
                                    Format PDF • Maksimal 10 MB
                                </span>
                            </div>

                        </div>

                    </div>

                    <small>
                        Gunakan file PDF slip gaji yang berasal dari SAP.
                    </small>

                </div>


                {{-- INFORMATION --}}
                <div class="salary-info-box">

                    <div class="salary-info-icon">
                        i
                    </div>

                    <div>
                        <strong>Informasi</strong>

                        <p>
                            File yang diupload akan disimpan secara privat
                            dan dapat diproses untuk pengiriman slip gaji
                            kepada karyawan melalui WhatsApp.
                        </p>
                    </div>

                </div>


                {{-- ACTION --}}
                <div class="salary-form-actions">

                    <a
                        href="{{ route('admin.salary-slips.index') }}"
                        class="salary-cancel-button"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="salary-submit-button"
                    >
                        <span>↑</span>
                        Upload Slip Gaji
                    </button>

                </div>

            </form>

        </div>


        {{-- SIDE INFO --}}
        <aside class="salary-upload-info">

            <div class="salary-side-icon">
                PDF
            </div>

            <h3>Ketentuan File</h3>

            <ul>
                <li>File harus berformat PDF.</li>
                <li>Ukuran maksimal 10 MB.</li>
                <li>Pastikan slip gaji sesuai dengan karyawan.</li>
                <li>Periode gaji harus diisi dengan benar.</li>
            </ul>

            <div class="salary-side-divider"></div>

            <span class="salary-side-label">
                ALUR SLIP GAJI
            </span>

            <div class="salary-step">
                <span>01</span>
                <p>Upload PDF SAP</p>
            </div>

            <div class="salary-step">
                <span>02</span>
                <p>Data tersimpan</p>
            </div>

            <div class="salary-step">
                <span>03</span>
                <p>Proses watermark</p>
            </div>

            <div class="salary-step">
                <span>04</span>
                <p>Kirim melalui WhatsApp</p>
            </div>

        </aside>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const fileInput = document.getElementById('file');
    const fileName = document.getElementById('file-name');

    if (fileInput && fileName) {

        fileInput.addEventListener('change', function () {

            if (this.files.length > 0) {

                fileName.textContent = this.files[0].name;

            } else {

                fileName.textContent = 'Pilih file slip gaji';

            }

        });

    }

});
</script>

@endsection