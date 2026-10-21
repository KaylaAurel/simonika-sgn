@extends('layouts.public')

@section('title', $employee->nama . ' - SIMONIKA SGN')

@section('public-content')

<section class="employee-profile-page">

    <div class="container">

        {{-- BACK --}}
        <a
            href="{{ route('public.employees') }}"
            class="employee-profile-back"
        >
            ← Kembali ke Data Karyawan
        </a>


        {{-- PROFILE HEADER --}}
        <div class="employee-profile-card">

            {{-- FOTO --}}
            <div class="employee-profile-photo-wrapper">

                <img
                    src="{{ $employee->photo_url }}"
                    alt="Foto {{ $employee->nama }}"
                    class="employee-profile-photo"
                >

            </div>


            {{-- DATA UTAMA --}}
            <div class="employee-profile-info">

                <span class="employee-profile-label">
                    PROFIL KARYAWAN
                </span>

                <h1>
                    {{ $employee->nama }}
                </h1>

                <div class="employee-profile-position">
                    {{ $employee->jabatan }}
                </div>

                <div class="employee-profile-division">
                    {{ $employee->sub_bagian }}
                </div>

                <div class="employee-profile-nopeg">
                    No. Pegawai: <strong>{{ $employee->nopeg }}</strong>
                </div>

            </div>

        </div>


        {{-- INFORMASI KARYAWAN --}}
        <div class="employee-profile-section">

            <div class="employee-profile-section-heading">

                <span>INFORMASI</span>

                <h2>Informasi Karyawan</h2>

            </div>


            <div class="employee-information-grid">

                <div class="employee-information-item">

                    <span>Nama Lengkap</span>

                    <strong>
                        {{ $employee->nama }}
                    </strong>

                </div>


                <div class="employee-information-item">

                    <span>Nomor Pegawai</span>

                    <strong>
                        {{ $employee->nopeg }}
                    </strong>

                </div>


                <div class="employee-information-item">

                    <span>Jabatan</span>

                    <strong>
                        {{ $employee->jabatan ?: '-' }}
                    </strong>

                </div>


                <div class="employee-information-item">

                    <span>Sub Bagian</span>

                    <strong>
                        {{ $employee->sub_bagian ?: '-' }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- DOKUMEN --}}
        <div class="employee-profile-section">

            <div class="employee-profile-section-heading">

                <span>DOKUMEN</span>

                <h2>Dokumen Karyawan</h2>

                <p>
                    Dokumen yang tersedia untuk karyawan ini.
                </p>

            </div>


            @if($employee->documents->count())

                <div class="employee-document-grid">

                    @foreach($employee->documents as $document)

                        <div class="employee-document-card">

                            <div class="employee-document-icon">
                                PDF
                            </div>

                            <div class="employee-document-content">

                                <h3>
                                    {{ strtoupper($document->type) }}
                                </h3>

                                <p>
                                    Dokumen karyawan
                                </p>

                            </div>

                            <a
                                href="{{ route('public.document.viewer', $document->id) }}"
                                class="employee-document-button"
                                target="_blank"
                            >
                                Lihat
                                <span>→</span>
                            </a>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="employee-profile-empty">

                    <span>📄</span>

                    <p>
                        Belum ada dokumen yang tersedia.
                    </p>

                </div>

            @endif

        </div>


        {{-- PELATIHAN --}}
        <div class="employee-profile-section">

            <div class="employee-profile-section-heading">

                <span>PENGEMBANGAN</span>

                <h2>Pelatihan</h2>

            </div>


            @if($employee->trainings->count())

                <div class="employee-training-list">

                    @foreach($employee->trainings as $training)

                        <div class="employee-training-item">

                            <div>

                                <h3>
                                    {{ $training->nama_pelatihan }}
                                </h3>

                                <p>
                                    {{ $training->penyelenggara ?: 'Penyelenggara tidak dicantumkan' }}
                                </p>

                            </div>

                            <span>
                                {{ $training->tanggal ? $training->tanggal->format('d M Y') : '-' }}
                            </span>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="employee-profile-empty">

                    <span>🎓</span>

                    <p>
                        Belum ada data pelatihan.
                    </p>

                </div>

            @endif

        </div>


        {{-- PENGHARGAAN --}}
        <div class="employee-profile-section">

            <div class="employee-profile-section-heading">

                <span>APRESIASI</span>

                <h2>Penghargaan</h2>

            </div>


            @if($employee->awards->count())

                <div class="employee-award-list">

                    @foreach($employee->awards as $award)

                        <div class="employee-award-item">

                            <div class="employee-award-icon">
                                ★
                            </div>

                            <div>

                                <h3>
                                    {{ $award->nama_penghargaan }}
                                </h3>

                                <p>
                                    Tahun {{ $award->tahun ?: '-' }}
                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="employee-profile-empty">

                    <span>🏆</span>

                    <p>
                        Belum ada data penghargaan.
                    </p>

                </div>

            @endif

        </div>

    </div>

</section>

@endsection