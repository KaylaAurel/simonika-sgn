@extends('layouts.admin')

@section('title', 'Tambah Karyawan - SIMONIKA SGN')

@section('page_title', 'Tambah Karyawan')

@section('admin-content')

<div class="content-page">

    {{-- HEADER --}}
    <div class="content-header">

        <div>

            <span class="content-eyebrow">
                DATA KARYAWAN
            </span>

            <h2>
                Tambah Karyawan
            </h2>

            <p>
                Masukkan informasi karyawan baru ke dalam sistem.
            </p>

        </div>

        <a
            href="{{ route('admin.employees.index') }}"
            class="btn btn-secondary"
        >
            ← Kembali
        </a>

    </div>


    {{-- FORM --}}
    <form
        action="{{ route('admin.employees.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="form-card"
    >

        @csrf


        {{-- =====================================================
             01. INFORMASI UTAMA
        ====================================================== --}}
        <div class="form-section">

            <div class="form-section-heading">

                <span>
                    01
                </span>

                <div>

                    <h3>
                        Informasi Utama
                    </h3>

                    <p>
                        Data identitas dasar karyawan.
                    </p>

                </div>

            </div>


            <div class="form-grid">

                {{-- NOMOR PEGAWAI --}}
                <div class="form-group">

                    <label for="nopeg">
                        Nomor Pegawai <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="nopeg"
                        name="nopeg"
                        value="{{ old('nopeg') }}"
                        placeholder="Contoh: 20230001"
                        required
                    >

                    @error('nopeg')
                        <small class="form-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- NAMA --}}
                <div class="form-group">

                    <label for="nama">
                        Nama Lengkap <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama') }}"
                        placeholder="Nama lengkap karyawan"
                        required
                    >

                    @error('nama')
                        <small class="form-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- JABATAN --}}
                <div class="form-group">

                    <label for="jabatan">
                        Jabatan <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="jabatan"
                        name="jabatan"
                        value="{{ old('jabatan') }}"
                        placeholder="Contoh: Staff SDM"
                        required
                    >

                    @error('jabatan')
                        <small class="form-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- SUB BAGIAN --}}
                <div class="form-group">

                    <label for="sub_bagian">
                        Sub Bagian <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="sub_bagian"
                        name="sub_bagian"
                        value="{{ old('sub_bagian') }}"
                        placeholder="Contoh: SDM"
                        required
                    >

                    @error('sub_bagian')
                        <small class="form-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

            </div>

        </div>


        {{-- =====================================================
             02. INFORMASI KONTAK
        ====================================================== --}}
        <div class="form-section">

            <div class="form-section-heading">

                <span>
                    02
                </span>

                <div>

                    <h3>
                        Informasi Kontak
                    </h3>

                    <p>
                        Informasi kontak pribadi karyawan.
                    </p>

                </div>

            </div>


            <div class="form-grid">

                {{-- ALAMAT --}}
                <div class="form-group form-group-full">

                    <label for="alamat">
                        Alamat
                    </label>

                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="4"
                        placeholder="Alamat lengkap karyawan"
                    >{{ old('alamat') }}</textarea>

                    @error('alamat')
                        <small class="form-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- NOMOR HP --}}
                <div class="form-group">

                    <label for="no_hp">
                        Nomor HP
                    </label>

                    <input
                        type="text"
                        id="no_hp"
                        name="no_hp"
                        value="{{ old('no_hp') }}"
                        placeholder="08xxxxxxxxxx"
                    >

                    @error('no_hp')
                        <small class="form-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- EMAIL --}}
                <div class="form-group">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="email@contoh.com"
                    >

                    @error('email')
                        <small class="form-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

            </div>

        </div>


        {{-- =====================================================
             03. FOTO & PEOPLE ONCE
        ====================================================== --}}
        <div class="form-section">

            <div class="form-section-heading">

                <span>
                    03
                </span>

                <div>

                    <h3>
                        Foto & People Once
                    </h3>

                    <p>
                        Data pendukung profil karyawan.
                    </p>

                </div>

            </div>


            <div class="form-grid">

                {{-- FOTO --}}
                <div class="form-group">

                    <label for="foto">
                        Foto Karyawan
                    </label>

                    <input
                        type="file"
                        id="foto"
                        name="foto"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <small class="form-hint">
                        JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                    </small>

                    @error('foto')
                        <small class="form-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- PEOPLE ONCE --}}
                <div class="form-group">

                    <label for="people_once_url">
                        Link People Once
                    </label>

                    <input
                        type="url"
                        id="people_once_url"
                        name="people_once_url"
                        value="{{ old('people_once_url') }}"
                        placeholder="https://..."
                    >

                    <small class="form-hint">
                        Masukkan link People Once jika tersedia.
                    </small>

                    @error('people_once_url')
                        <small class="form-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

            </div>

        </div>


        {{-- =====================================================
             ACTION
        ====================================================== --}}
        <div class="form-actions">

            <a
                href="{{ route('admin.employees.index') }}"
                class="btn btn-secondary"
            >
                Batal
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Karyawan
            </button>

        </div>

    </form>

</div>

@endsection