@extends('layouts.public')

@section('title', 'SIMONIKA SGN - Sistem Monitoring Karyawan')

@section('meta_description')
    SIMONIKA SGN - Sistem Monitoring Karyawan PT Sinergi Gula Nusantara
@endsection


@section('public-content')


{{-- =========================================================
     HERO SECTION
========================================================= --}}

<section class="hero-section">

    <div class="container hero-grid">

        {{-- LEFT CONTENT --}}
        <div class="hero-content">

            <div class="hero-eyebrow">
                PT SINERGI GULA NUSANTARA PG NGADIREDJO
            </div>


            <h1>
                Mengenal Lebih Dekat
                <span>Karyawan SGN.</span>
            </h1>


            <p class="hero-description">
                SIMONIKA SGN merupakan sistem monitoring karyawan
                yang membantu menyajikan informasi karyawan secara
                terstruktur, modern, dan mudah diakses.
            </p>


            <div class="hero-actions">

                <a
                    href="{{ route('public.employees') }}"
                    class="btn btn-primary"
                >
                    Lihat Data Karyawan
                    <span>→</span>
                </a>


                <a
                    href="#tentang"
                    class="btn btn-secondary"
                >
                    Tentang SIMONIKA
                </a>

            </div>


            {{-- MINI TRUST --}}
            <div class="hero-trust">

                <div class="trust-item">
                    <span class="trust-check">✓</span>

                    <div>
                        <strong>Data Terstruktur</strong>
                        <small>Informasi SDM tersusun rapi</small>
                    </div>
                </div>


                <div class="trust-item">
                    <span class="trust-check">✓</span>

                    <div>
                        <strong>Akses Mudah</strong>
                        <small>Informasi dapat ditemukan dengan cepat</small>
                    </div>
                </div>

            </div>

        </div>


        {{-- RIGHT VISUAL --}}
        <div class="hero-visual">

            <div class="hero-card">

                <div class="hero-card-top">

                    <span class="hero-card-label">
                        SISTEM MONITORING
                    </span>

                    <span class="hero-card-status">
                        ● ONLINE
                    </span>

                </div>


                <div class="hero-logo-wrapper">

                    <div class="hero-logo-circle">

                        <img
                            src="{{ asset('images/logosgn.png') }}"
                            alt="Logo SGN"
                            class="hero-logo"
                        >

                    </div>

                </div>


                <div class="hero-card-content">

                    <span>
                        PT SINERGI GULA NUSANTARA
                    </span>

                    <h2>
                        SIMONIKA
                    </h2>

                    <p>
                        Sistem Monitoring Karyawan SGN
                    </p>

                </div>


                <div class="hero-card-line"></div>


                <div class="hero-card-footer">

                    <div>
                        <strong>Data SDM</strong>
                        <span>Terstruktur</span>
                    </div>

                    <div>
                        <strong>Digital</strong>
                        <span>Terintegrasi</span>
                    </div>

                </div>

            </div>


            {{-- FLOATING CARD --}}
            <div class="floating-card floating-card-one">

                <div class="floating-icon">
                    👥
                </div>

                <div>
                    <strong>Data Karyawan</strong>
                    <span>Tersedia</span>
                </div>

            </div>


            <div class="floating-card floating-card-two">

                <div class="floating-icon">
                    ✓
                </div>

                <div>
                    <strong>Informasi SDM</strong>
                    <span>Terorganisir</span>
                </div>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
     QUICK STATS
========================================================= --}}

<section class="stats-section">

    <div class="container">

        <div class="stats-grid">


           {{-- STAT 1 --}}
<div class="stat-item">

    <div class="stat-icon">
        👥
    </div>

    <div class="stat-content">

        <strong>
            {{ $totalEmployees }}+
        </strong>

        <span>
            Data Karyawan SGN
        </span>

    </div>

</div>


            {{-- STAT 2 --}}
            <div class="stat-item">

                <div class="stat-icon">
                    🏢
                </div>

                <div class="stat-content">

                    <strong>
                        SGN
                    </strong>

                    <span>
                        PT Sinergi Gula Nusantara
                    </span>

                </div>

            </div>


            {{-- STAT 3 --}}
            <div class="stat-item">

                <div class="stat-icon">
                    📊
                </div>

                <div class="stat-content">

                    <strong>
                        Terstruktur
                    </strong>

                    <span>
                        Pengelolaan Data SDM
                    </span>

                </div>

            </div>


            {{-- STAT 4 --}}
            <div class="stat-item">

                <div class="stat-icon">
                    📄
                </div>

                <div class="stat-content">

                    <strong>
                        Terpusat
                    </strong>

                    <span>
                        Informasi Dokumen Karyawan
                    </span>

                </div>

            </div>


            {{-- STAT 5 --}}
            <div class="stat-item">

                <div class="stat-icon">
                    🎓
                </div>

                <div class="stat-content">

                    <strong>
                        Tercatat
                    </strong>

                    <span>
                        Riwayat Pelatihan Karyawan
                    </span>

                </div>

            </div>


            {{-- STAT 6 --}}
            <div class="stat-item">

                <div class="stat-icon">
                    🏆
                </div>

                <div class="stat-content">

                    <strong>
                        Terdokumentasi
                    </strong>

                    <span>
                        Penghargaan dan Apresiasi
                    </span>

                </div>

            </div>


        </div>

    </div>

</section>

        </div>

    </div>

</section>



{{-- =========================================================
     TENTANG SIMONIKA
========================================================= --}}

<section
    id="tentang"
    class="about-section"
>

    <div class="container">

        {{-- SECTION HEADING --}}
        <div class="section-heading">

            <span>
                TENTANG SIMONIKA
            </span>

            <h2>
                Satu tempat untuk informasi
                karyawan SGN.
            </h2>

            <p>
                SIMONIKA dirancang untuk membantu penyajian
                informasi karyawan PT Sinergi Gula Nusantara
                secara lebih terstruktur, modern, dan mudah
                diakses.
            </p>

        </div>


        {{-- ABOUT GRID --}}
        <div class="about-grid">


            {{-- MAIN CARD --}}
            <div class="about-main-card">

                <div class="about-number">
                    01
                </div>

                <div class="about-main-content">

                    <span class="about-card-label">
                        INFORMASI SDM
                    </span>

                    <h3>
                        Informasi Karyawan
                        Lebih Terstruktur
                    </h3>

                    <p>
                        SIMONIKA menyediakan satu tempat untuk
                        mengelola dan menyajikan informasi
                        karyawan secara lebih terorganisir,
                        mulai dari profil, jabatan, hingga
                        informasi pendukung lainnya.
                    </p>

                    <p>
                        Dengan informasi yang tersusun dalam satu
                        sistem, pencarian dan penyajian data
                        karyawan dapat dilakukan dengan lebih
                        praktis.
                    </p>

                    <div class="about-main-footer">
                        <span>
                            ✓ Data Terorganisir
                        </span>

                        <span>
                            ✓ Akses Lebih Praktis
                        </span>
                    </div>

                </div>

            </div>


            {{-- SIDE CARD --}}
            <div class="about-side-card">

                <div class="about-side-top">

                    <span class="about-side-icon">
                        SGN
                    </span>

                    <span class="about-side-status">
                        DIGITAL
                    </span>

                </div>

                <h3>
                    Sistem Digital
                </h3>

                <p>
                    Mendukung pengelolaan informasi sumber daya
                    manusia melalui sistem digital yang lebih
                    praktis, terorganisir, dan mudah digunakan.
                </p>

                <div class="about-side-list">

                    <span>
                        ✓ Data Karyawan
                    </span>

                    <span>
                        ✓ Dokumen Karyawan
                    </span>

                    <span>
                        ✓ Riwayat Pelatihan
                    </span>

                    <span>
                        ✓ Penghargaan
                    </span>

                </div>

            </div>

        </div>


        {{-- ABOUT HIGHLIGHTS --}}
        <div class="about-bottom">

            <div class="about-bottom-card">

                <div class="about-bottom-icon">
                    01
                </div>

                <div>
                    <strong>
                        Terstruktur
                    </strong>

                    <span>
                        Informasi tersusun dalam satu sistem.
                    </span>
                </div>

                <div class="about-arrow">
                    →
                </div>

            </div>


            <div class="about-bottom-card">

                <div class="about-bottom-icon">
                    02
                </div>

                <div>
                    <strong>
                        Terpusat
                    </strong>

                    <span>
                        Data karyawan dikelola secara terorganisir.
                    </span>
                </div>

                <div class="about-arrow">
                    →
                </div>

            </div>


            <div class="about-bottom-card">

                <div class="about-bottom-icon">
                    03
                </div>

                <div>
                    <strong>
                        Mudah Diakses
                    </strong>

                    <span>
                        Informasi dapat ditemukan dengan lebih praktis.
                    </span>
                </div>

                <div class="about-arrow">
                    →
                </div>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
     FITUR UTAMA
========================================================= --}}

<section class="features-section">

    <div class="container">


        <div class="section-heading centered">

            <span>
                FITUR UTAMA
            </span>

            <h2>
                Semua informasi penting
                dalam satu sistem.
            </h2>

            <p>
                SIMONIKA membantu menyajikan berbagai informasi
                yang berkaitan dengan karyawan secara lebih
                sederhana dan terstruktur.
            </p>

        </div>


        <div class="feature-grid">


            {{-- PROFIL --}}

            <div class="feature-card">

                <div class="feature-card-top">

                    <div class="feature-icon">
                        👤
                    </div>

                    <span class="feature-number">
                        01
                    </span>

                </div>

                <h3>
                    Profil Karyawan
                </h3>

                <p>
                    Informasi dasar karyawan dapat ditemukan
                    dengan mudah melalui sistem.
                </p>

                <div class="feature-link">
                    Informasi Karyawan →
                </div>

            </div>


            {{-- DOKUMEN --}}

            <div class="feature-card">

                <div class="feature-card-top">

                    <div class="feature-icon">
                        📄
                    </div>

                    <span class="feature-number">
                        02
                    </span>

                </div>

                <h3>
                    Dokumen
                </h3>

                <p>
                    Informasi dokumen tertentu dapat diakses
                    melalui tampilan yang lebih terstruktur.
                </p>

                <div class="feature-link">
                    Dokumen Karyawan →
                </div>

            </div>


            {{-- PELATIHAN --}}

            <div class="feature-card">

                <div class="feature-card-top">

                    <div class="feature-icon">
                        📚
                    </div>

                    <span class="feature-number">
                        03
                    </span>

                </div>

                <h3>
                    Riwayat Pelatihan
                </h3>

                <p>
                    Riwayat pengembangan kompetensi karyawan
                    dapat dikelola secara terpusat.
                </p>

                <div class="feature-link">
                    Riwayat Pelatihan →
                </div>

            </div>


            {{-- PENGHARGAAN --}}

            <div class="feature-card">

                <div class="feature-card-top">

                    <div class="feature-icon">
                        🏆
                    </div>

                    <span class="feature-number">
                        04
                    </span>

                </div>

                <h3>
                    Penghargaan
                </h3>

                <p>
                    Data penghargaan dan apresiasi karyawan
                    tersimpan secara terstruktur.
                </p>

                <div class="feature-link">
                    Data Penghargaan →
                </div>

            </div>


            {{-- PEOPLE ONCE --}}

            <div class="feature-card">

                <div class="feature-card-top">

                    <div class="feature-icon">
                        🔗
                    </div>

                    <span class="feature-number">
                        05
                    </span>

                </div>

                <h3>
                    People Once
                </h3>

                <p>
                    Akses menuju platform People Once
                    untuk mendukung kebutuhan informasi
                    karyawan.
                </p>

                <div class="feature-link">
                    Akses People Once →
                </div>

            </div>


            {{-- MONITORING --}}

            <div class="feature-card">

                <div class="feature-card-top">

                    <div class="feature-icon">
                        📊
                    </div>

                    <span class="feature-number">
                        06
                    </span>

                </div>

                <h3>
                    Monitoring SDM
                </h3>

                <p>
                    Membantu pengelolaan data karyawan
                    secara terpusat dan sistematis.
                </p>

                <div class="feature-link">
                    Monitoring Data →
                </div>

            </div>


        </div>

    </div>

</section>



{{-- =========================================================
     HOW IT WORKS
========================================================= --}}

<section class="process-section">

    <div class="container">


        <div class="section-heading centered">

            <span>
                CARA KERJA
            </span>

            <h2>
                Informasi karyawan,
                lebih mudah ditemukan.
            </h2>

            <p>
                SIMONIKA dirancang dengan alur sederhana
                sehingga informasi dapat diakses secara
                lebih praktis.
            </p>

        </div>


        <div class="process-grid">


            <div class="process-item">

                <div class="process-number">
                    01
                </div>

                <div class="process-line"></div>

                <h3>
                    Cari Karyawan
                </h3>

                <p>
                    Temukan data karyawan melalui halaman
                    Data Karyawan.
                </p>

            </div>


            <div class="process-item">

                <div class="process-number">
                    02
                </div>

                <div class="process-line"></div>

                <h3>
                    Lihat Profil
                </h3>

                <p>
                    Informasi dasar karyawan ditampilkan
                    dalam profil yang terstruktur.
                </p>

            </div>


            <div class="process-item">

                <div class="process-number">
                    03
                </div>

                <div class="process-line"></div>

                <h3>
                    Akses Informasi
                </h3>

                <p>
                    Informasi yang tersedia dapat dilihat
                    sesuai hak akses pengguna.
                </p>

            </div>


            <div class="process-item">

                <div class="process-number">
                    04
                </div>

                <h3>
                    Informasi Terpusat
                </h3>

                <p>
                    Data karyawan tersaji dalam satu sistem
                    monitoring yang terorganisir.
                </p>

            </div>


        </div>

    </div>

</section>



{{-- =========================================================
     CTA
========================================================= --}}

<section class="cta-section">

    <div class="container">

        <div class="cta-card">


            <div class="cta-content">

                <span>
                    SIMONIKA SGN
                </span>

                <h2>
                    Temukan informasi
                    karyawan dengan lebih mudah.
                </h2>

                <p>
                    Jelajahi data karyawan SGN melalui
                    SIMONIKA dengan tampilan yang sederhana
                    dan informatif.
                </p>


                <a
                    href="{{ route('public.employees') }}"
                    class="btn btn-primary"
                >
                    Lihat Data Karyawan
                    <span>→</span>
                </a>

            </div>


            <div class="cta-decoration">

                <div class="cta-circle circle-one"></div>
                <div class="cta-circle circle-two"></div>
                <div class="cta-circle circle-three"></div>

            </div>

        </div>

    </div>

</section>



@endsection