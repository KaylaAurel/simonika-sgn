@extends('layouts.admin')

@section('title', 'Edit Pelatihan - SIMONIKA SGN')

@section('page_title', 'Edit Pelatihan')

@section('admin-content')

<div class="training-edit-page">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="training-edit-header">

        <div class="training-edit-heading">

            <span class="training-edit-eyebrow">
                PENGEMBANGAN SDM
            </span>

            <h2>
                Edit Pelatihan
            </h2>

            <p>
                Perbarui informasi pelatihan karyawan.
            </p>

        </div>


        <a
            href="{{ route('admin.trainings.index') }}"
            class="training-edit-back"
        >
            <span>←</span>
            Kembali
        </a>

    </div>


    {{-- =========================================================
         VALIDATION ERROR
    ========================================================== --}}

    @if ($errors->any())

        <div class="training-edit-alert">

            <div class="training-edit-alert-icon">
                !
            </div>

            <div>

                <strong>
                    Terjadi kesalahan
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
        action="{{ route('admin.trainings.update', $training->id) }}"
        method="POST"
        class="training-edit-form"
    >

        @csrf

        @method('PUT')


        {{-- =====================================================
             CARD INFORMASI PELATIHAN
        ====================================================== --}}

        <div class="training-edit-card">

            {{-- CARD HEADER --}}

            <div class="training-edit-card-header">

                <div class="training-edit-card-icon">
                    🎓
                </div>

                <div>

                    <h3>
                        Informasi Pelatihan
                    </h3>

                    <p>
                        Perbarui data pelatihan karyawan.
                    </p>

                </div>

            </div>


            {{-- FORM CONTENT --}}

            <div class="training-edit-form-grid">


                {{-- =================================================
                     KARYAWAN
                ================================================== --}}

                <div class="training-edit-form-group">

                    <label>
                        Karyawan
                    </label>

                    {{--

                        WAJIB ADA.

                        Nama karyawan hanya ditampilkan,
                        tetapi employee_id tetap dikirim
                        ke controller melalui hidden input.

                    --}}

                    <input
                        type="hidden"
                        name="employee_id"
                        value="{{ old('employee_id', $training->employee_id) }}"
                    >


                    <div class="training-employee-box">

                        <div class="training-employee-avatar">

                            {{
                                strtoupper(
                                    substr(
                                        $training->employee->nama ?? 'K',
                                        0,
                                        1
                                    )
                                )
                            }}

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


                    <small class="training-edit-hint">
                        Data karyawan tidak dapat diubah pada halaman ini.
                    </small>


                    @error('employee_id')

                        <small class="training-edit-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- =================================================
                     NAMA PELATIHAN
                ================================================== --}}

                <div class="training-edit-form-group">

                    <label for="nama_pelatihan">

                        Nama Pelatihan

                        <span class="required">
                            *
                        </span>

                    </label>


                    <input
                        type="text"
                        id="nama_pelatihan"
                        name="nama_pelatihan"
                        value="{{ old('nama_pelatihan', $training->nama_pelatihan) }}"
                        placeholder="Contoh: Pelatihan Microsoft Excel"
                        required
                    >


                    @error('nama_pelatihan')

                        <small class="training-edit-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- =================================================
                     PENYELENGGARA
                ================================================== --}}

                <div class="training-edit-form-group">

                    <label for="penyelenggara">
                        Penyelenggara
                    </label>


                    <input
                        type="text"
                        id="penyelenggara"
                        name="penyelenggara"
                        value="{{ old('penyelenggara', $training->penyelenggara) }}"
                        placeholder="Contoh: PT Sinergi Gula Nusantara"
                    >


                    @error('penyelenggara')

                        <small class="training-edit-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- =================================================
                     TANGGAL
                ================================================== --}}

                <div class="training-edit-form-group">

                    <label for="tanggal">
                        Tanggal
                    </label>


                    <input
                        type="date"
                        id="tanggal"
                        name="tanggal"
                        value="{{
                            old(
                                'tanggal',
                                $training->tanggal
                                    ? $training->tanggal->format('Y-m-d')
                                    : ''
                            )
                        }}"
                    >


                    @error('tanggal')

                        <small class="training-edit-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- =================================================
                     KETERANGAN
                ================================================== --}}

                <div class="training-edit-form-group training-edit-full">

                    <label for="keterangan">
                        Keterangan
                    </label>


                    <textarea
                        id="keterangan"
                        name="keterangan"
                        rows="6"
                        placeholder="Tambahkan keterangan mengenai pelatihan..."
                    >{{ old('keterangan', $training->keterangan) }}</textarea>


                    @error('keterangan')

                        <small class="training-edit-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>

            </div>

        </div>


        {{-- =========================================================
             ACTION BUTTON
        ========================================================== --}}

        <div class="training-edit-actions">

            <a
                href="{{ route('admin.trainings.index') }}"
                class="training-edit-cancel"
            >
                Batal
            </a>


            <button
                type="submit"
                class="training-edit-submit"
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