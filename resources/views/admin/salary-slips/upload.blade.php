@extends('layouts.admin')

@section('title', 'Upload Slip Gaji - SIMONIKA SGN')

@section('page_title', 'Upload Slip Gaji')

@section('admin-content')

<div class="content-page salary-page">

    {{-- HEADER --}}
    <div class="content-header salary-page-header">

        <div>

            <span class="content-eyebrow">
                PAYROLL
            </span>

            <h2>
                Upload Slip Gaji
            </h2>

            <p>
                Upload slip gaji dari SAP Payroll untuk diproses.
            </p>

        </div>


        <a
            href="{{ route('admin.salary-slips.index') }}"
            class="btn btn-secondary"
        >
            ← Kembali
        </a>

    </div>


    {{-- INFO --}}
    <div class="salary-info-banner">

        <div class="salary-info-icon">
            🔐
        </div>

        <div>

            <strong>
                Proses keamanan slip gaji
            </strong>

            <p>
                File akan disimpan secara private dan diproses
                menggunakan watermark SIMONIKA SGN sebelum
                dikirim melalui WhatsApp.
            </p>

        </div>

    </div>


    {{-- FORM --}}
    <form
        action="{{ route('admin.salary-slips.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="salary-form-card"
    >

        @csrf


        <div class="salary-form-section">

            <div class="salary-form-heading">

                <span>
                    DATA SLIP
                </span>

                <h3>
                    Informasi Slip Gaji
                </h3>

                <p>
                    Tentukan karyawan dan periode slip gaji.
                </p>

            </div>


            <div class="salary-form-grid">


                {{-- KARYAWAN --}}
                <div class="form-group">

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
                                @selected(old('employee_id') == $employee->id)
                            >

                                {{ $employee->nama }}
                                — {{ $employee->nopeg }}

                            </option>

                        @endforeach

                    </select>


                    @error('employee_id')

                        <small class="form-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- PERIODE --}}
                <div class="form-group">

                    <label for="periode">

                        Periode Slip Gaji
                        <span>*</span>

                    </label>


                    <input
                        type="text"
                        id="periode"
                        name="periode"
                        value="{{ old('periode') }}"
                        placeholder="Contoh: September 2026"
                        required
                    >


                    @error('periode')

                        <small class="form-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- FILE --}}
                <div class="form-group salary-file-input">

                    <label for="file">

                        File Slip Gaji
                        <span>*</span>

                    </label>


                    <input
                        type="file"
                        id="file"
                        name="file"
                        accept=".pdf,application/pdf"
                        required
                    >


                    <small class="form-hint">
                        Format PDF dengan ukuran maksimal 10 MB.
                    </small>


                    @error('file')

                        <small class="form-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>

            </div>

        </div>


        {{-- ACTION --}}
        <div class="salary-form-actions">

            <a
                href="{{ route('admin.salary-slips.index') }}"
                class="btn btn-secondary"
            >
                Batal
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Upload & Proses
            </button>

        </div>

    </form>

</div>

@endsection