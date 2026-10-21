@extends('layouts.admin')

@section('title', 'Tambah Penghargaan - SIMONIKA SGN')

@section('page_title', 'Tambah Penghargaan')

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
                Tambah Penghargaan
            </h2>

            <p>
                Tambahkan data penghargaan atau medali yang diterima
                oleh karyawan SGN.
            </p>

        </div>


        <a
            href="{{ route('admin.awards.index') }}"
            class="award-back-button"
        >
            <span>←</span>
            Kembali
        </a>

    </div>


    {{-- =========================================================
         VALIDATION ERROR
    ========================================================== --}}

    @if ($errors->any())

        <div class="award-alert">

            <div class="award-alert-icon">
                !
            </div>

            <div>

                <strong>
                    Periksa kembali data yang diinput.
                </strong>

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    @endif


    {{-- =========================================================
         FORM
    ========================================================== --}}

    <form
        action="{{ route('admin.awards.store') }}"
        method="POST"
        class="award-form"
    >

        @csrf


        <div class="award-form-card">


            {{-- =================================================
                 CARD HEADER
            ================================================== --}}

            <div class="award-form-card-header">

                <div class="award-form-icon">
                    🏆
                </div>

                <div>

                    <h3>
                        Informasi Penghargaan
                    </h3>

                    <p>
                        Lengkapi informasi penghargaan karyawan.
                    </p>

                </div>

            </div>


            {{-- =================================================
                 FORM BODY
            ================================================== --}}

            <div class="award-form-body">

                <div class="award-form-grid">


                    {{-- =============================================
                         KARYAWAN
                    ============================================== --}}

                    <div class="award-form-group">

                        <label for="employee_id">

                            Karyawan

                            <span class="required">
                                *
                            </span>

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
                                    @selected(
                                        old(
                                            'employee_id',
                                            request('employee_id')
                                        ) == $employee->id
                                    )
                                >
                                    {{ $employee->nama }}
                                    — {{ $employee->nopeg }}
                                </option>

                            @endforeach

                        </select>


                        @error('employee_id')

                            <small class="award-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- =============================================
                         NAMA PENGHARGAAN
                    ============================================== --}}

                    <div class="award-form-group">

                        <label for="nama_penghargaan">

                            Nama Penghargaan

                            <span class="required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            id="nama_penghargaan"
                            name="nama_penghargaan"
                            value="{{ old('nama_penghargaan') }}"
                            placeholder="Contoh: Satyalancana"
                            required
                        >


                        @error('nama_penghargaan')

                            <small class="award-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- =============================================
                         TAHUN
                    ============================================== --}}

                    <div class="award-form-group">

                        <label for="tahun">
                            Tahun
                        </label>


                        <input
                            type="number"
                            id="tahun"
                            name="tahun"
                            value="{{ old('tahun') }}"
                            placeholder="Contoh: 2026"
                            min="1900"
                            max="{{ date('Y') + 1 }}"
                        >


                        @error('tahun')

                            <small class="award-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- =============================================
                         KETERANGAN
                    ============================================== --}}

                    <div class="award-form-group award-form-full">

                        <label for="keterangan">
                            Keterangan
                        </label>


                        <textarea
                            id="keterangan"
                            name="keterangan"
                            rows="6"
                            placeholder="Tambahkan keterangan mengenai penghargaan..."
                        >{{ old('keterangan') }}</textarea>


                        @error('keterangan')

                            <small class="award-form-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
             ACTION BUTTON
        ========================================================== --}}

        <div class="award-form-actions">

            <a
                href="{{ route('admin.awards.index') }}"
                class="award-cancel-button"
            >
                Batal
            </a>


            <button
                type="submit"
                class="award-submit-button"
            >

                <span>
                    ✓
                </span>

                Simpan Penghargaan

            </button>

        </div>

    </form>

</div>

@endsection