@extends('layouts.app')

@section('body_class', 'public-page')

@section('content')

    {{-- NAVBAR --}}
    @include('components.navbar')


    {{-- CONTENT HALAMAN --}}
    <main>
        @yield('public-content')
    </main>


   {{-- FINAL INFORMATION --}}

<section class="final-section">

    <div class="container">

        <div class="final-grid">

            <div class="final-brand">

                <span class="final-label">
                    PT SINERGI GULA NUSANTARA
                </span>

                <h2>
                    SIMONIKA
                </h2>

                <p>
                    Sistem Monitoring Karyawan SGN yang
                    dirancang untuk membantu penyajian
                    informasi SDM secara terstruktur,
                    modern, dan mudah diakses.
                </p>

            </div>


            <div class="final-links">

                <h3>
                    Navigasi
                </h3>

                <a href="{{ route('public.home') }}">
                    Beranda
                </a>

                <a href="{{ route('public.employees') }}">
                    Data Karyawan
                </a>

                <a href="{{ route('public.home') }}#tentang">
                    Tentang SIMONIKA
                </a>

                <a href="{{ route('login') }}">
                    Login Admin
                </a>

            </div>


            <div class="final-links">

                <h3>
                    Informasi
                </h3>

                <span>
                    Profil Karyawan
                </span>

                <span>
                    Dokumen
                </span>

                <span>
                    Pelatihan
                </span>

                <span>
                    Penghargaan
                </span>

            </div>

        </div>

    </div>

</section>


{{-- COPYRIGHT --}}

<footer class="site-footer">

    <div class="container footer-container">

        <div class="footer-brand">

            <img
                src="{{ asset('images/logosgn.png') }}"
                alt="Logo SGN"
            >

            <div>

                <strong>
                    SIMONIKA SGN
                </strong>

                <small>
                    Sistem Monitoring Karyawan SGN
                </small>

            </div>

        </div>


        <p>
            © {{ date('Y') }}
            PT Sinergi Gula Nusantara.
            All rights reserved.
        </p>

    </div>

</footer>


@endsection