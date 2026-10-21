@extends('layouts.admin')

@section('title', 'Tambah Pelatihan - SIMONIKA SGN')

@section('page_title', 'Tambah Pelatihan')

@section('admin-content')

<div class="training-create-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="training-create-header">

        <div class="training-create-heading">

            <span class="training-create-eyebrow">
                PENGEMBANGAN SDM
            </span>

            <h2>
                Tambah Pelatihan
            </h2>

            <p>
                Tambahkan riwayat pelatihan yang telah diikuti oleh karyawan.
            </p>

        </div>

        <a
            href="{{ route('admin.trainings.index') }}"
            class="training-back-button"
        >
            <span>←</span>
            Kembali
        </a>

    </div>


    {{-- =====================================================
         VALIDATION ERROR
    ====================================================== --}}

    @if ($errors->any())

        <div class="training-alert">

            <div class="training-alert-icon">
                !
            </div>

            <div>

                <strong>
                    Periksa kembali data
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


    {{-- =====================================================
         FORM
    ====================================================== --}}

    <form
        action="{{ route('admin.trainings.store') }}"
        method="POST"
        class="training-form"
    >

        @csrf


        <div class="training-form-card">

            {{-- CARD HEADER --}}

            <div class="training-form-card-header">

                <div class="training-form-card-icon">
                    🎓
                </div>

                <div>

                    <h3>
                        Informasi Pelatihan
                    </h3>

                    <p>
                        Lengkapi informasi pelatihan karyawan.
                    </p>

                </div>

            </div>


            {{-- FORM CONTENT --}}

            <div class="training-form-grid">


                {{-- KARYAWAN --}}

                <div class="training-form-group">

                    <label for="employee_id">

                        Karyawan

                        <span class="required">
                            *
                        </span>

                    </label>

                    <select
                        name="employee_id"
                        id="employee_id"
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

                        <small class="training-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- NAMA PELATIHAN --}}

                <div class="training-form-group">

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
                        value="{{ old('nama_pelatihan') }}"
                        placeholder="Contoh: Pelatihan K3 Dasar"
                        required
                    >

                    @error('nama_pelatihan')

                        <small class="training-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- PENYELENGGARA --}}

                <div class="training-form-group">

                    <label for="penyelenggara">
                        Penyelenggara
                    </label>

                    <input
                        type="text"
                        id="penyelenggara"
                        name="penyelenggara"
                        value="{{ old('penyelenggara') }}"
                        placeholder="Contoh: PT Sinergi Gula Nusantara"
                    >

                    @error('penyelenggara')

                        <small class="training-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- TANGGAL --}}

                <div class="training-form-group">

                    <label for="tanggal">
                        Tanggal Pelatihan
                    </label>

                    <input
                        type="date"
                        id="tanggal"
                        name="tanggal"
                        value="{{ old('tanggal') }}"
                    >

                    @error('tanggal')

                        <small class="training-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- KETERANGAN --}}

                <div class="training-form-group training-form-full">

                    <label for="keterangan">
                        Keterangan
                    </label>

                    <textarea
                        id="keterangan"
                        name="keterangan"
                        rows="5"
                        placeholder="Tambahkan keterangan mengenai pelatihan jika diperlukan..."
                    >{{ old('keterangan') }}</textarea>

                    @error('keterangan')

                        <small class="training-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>

            </div>

        </div>


        {{-- =====================================================
             ACTION
        ====================================================== --}}

        <div class="training-form-actions">

            <a
                href="{{ route('admin.trainings.index') }}"
                class="training-cancel-button"
            >
                Batal
            </a>

            <button
                type="submit"
                class="training-submit-button"
            >

                <span>
                    ✓
                </span>

                Simpan Pelatihan

            </button>

        </div>

    </form>

</div>

@endsection