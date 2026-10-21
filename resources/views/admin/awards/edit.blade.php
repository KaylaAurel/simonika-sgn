@extends('layouts.admin')

@section('title', 'Edit Penghargaan - SIMONIKA SGN')

@section('page_title', 'Edit Penghargaan')

@section('admin-content')

<div class="award-edit-page">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="award-edit-header">

        <div class="award-edit-heading">

            <span class="award-edit-eyebrow">
                APRESIASI KARYAWAN
            </span>

            <h2>
                Edit Penghargaan
            </h2>

            <p>
                Perbarui informasi penghargaan karyawan.
            </p>

        </div>


        <a
            href="{{ route('admin.awards.index') }}"
            class="award-edit-back"
        >
            <span>←</span>
            Kembali
        </a>

    </div>


    {{-- =========================================================
         VALIDATION ERROR
    ========================================================== --}}

    @if ($errors->any())

        <div class="award-edit-alert">

            <div class="award-edit-alert-icon">
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
        action="{{ route('admin.awards.update', $award->id) }}"
        method="POST"
        class="award-edit-form"
    >

        @csrf

        @method('PUT')


        {{-- =====================================================
             CARD INFORMASI PENGHARGAAN
        ====================================================== --}}

        <div class="award-edit-card">


            {{-- CARD HEADER --}}

            <div class="award-edit-card-header">

                <div class="award-edit-card-icon">
                    🏆
                </div>

                <div>

                    <h3>
                        Informasi Penghargaan
                    </h3>

                    <p>
                        Perbarui data penghargaan karyawan.
                    </p>

                </div>

            </div>


            {{-- =================================================
                 FORM BODY
            ================================================== --}}

            <div class="award-edit-form-body">

                <div class="award-edit-form-grid">


                    {{-- =============================================
                         KARYAWAN
                    ============================================== --}}

                    <div class="award-edit-form-group">

                        <label>
                            Karyawan
                        </label>


                        {{--

                            PENTING:

                            Input ini tidak boleh disabled karena
                            employee_id harus dikirim ke controller.

                            Nama karyawan tetap tidak dapat diedit,
                            tetapi ID-nya dikirim melalui hidden input.

                        --}}

                        <input
                            type="hidden"
                            name="employee_id"
                            value="{{ old('employee_id', $award->employee_id) }}"
                        >


                        <div class="award-employee-box">

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


                        <small class="award-edit-hint">
                            Data karyawan tidak dapat diubah pada halaman ini.
                        </small>


                        @error('employee_id')

                            <small class="award-edit-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- =============================================
                         NAMA PENGHARGAAN
                    ============================================== --}}

                    <div class="award-edit-form-group">

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
                            value="{{ old(
                                'nama_penghargaan',
                                $award->nama_penghargaan
                            ) }}"
                            placeholder="Contoh: Satyalancana"
                            required
                        >


                        @error('nama_penghargaan')

                            <small class="award-edit-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- =============================================
                         TAHUN
                    ============================================== --}}

                    <div class="award-edit-form-group">

                        <label for="tahun">
                            Tahun
                        </label>


                        <input
                            type="number"
                            id="tahun"
                            name="tahun"
                            value="{{ old('tahun', $award->tahun) }}"
                            min="1900"
                            max="{{ date('Y') + 1 }}"
                            placeholder="Contoh: 2026"
                        >


                        @error('tahun')

                            <small class="award-edit-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- =============================================
                         KETERANGAN
                    ============================================== --}}

                    <div class="award-edit-form-group award-edit-full">

                        <label for="keterangan">
                            Keterangan
                        </label>


                        <textarea
                            id="keterangan"
                            name="keterangan"
                            rows="6"
                            placeholder="Tambahkan keterangan mengenai penghargaan..."
                        >{{ old(
                            'keterangan',
                            $award->keterangan
                        ) }}</textarea>


                        @error('keterangan')

                            <small class="award-edit-error">
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

        <div class="award-edit-actions">

            <a
                href="{{ route('admin.awards.index') }}"
                class="award-edit-cancel"
            >
                Batal
            </a>


            <button
                type="submit"
                class="award-edit-submit"
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