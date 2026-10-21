@extends('layouts.app')

@section('title', 'Login Admin - SIMONIKA SGN')

@section('body_class', 'login-page')

@section('content')

<div class="login-page-wrapper">

    {{-- Background Decoration --}}
    <div class="login-orb login-orb-one"></div>
    <div class="login-orb login-orb-two"></div>
    <div class="login-orb login-orb-three"></div>

    <div class="login-grid-pattern"></div>

    {{-- Login Card --}}
    <div class="login-card">

        {{-- LEFT : BRAND --}}
        <div class="login-brand-panel">

            <div class="brand-top">

                <div class="brand-logo-box">
                    <img
                        src="{{ asset('images/logosgn.png') }}"
                        alt="Logo PT Sinergi Gula Nusantara"
                    >
                </div>

                <div class="brand-company">
                    <strong>PT SINERGI GULA NUSANTARA</strong>
                    <span>PG Ngadiredjo</span>
                </div>

            </div>


            <div class="brand-main">

                <span class="brand-eyebrow">
                    SISTEM INFORMASI SDM
                </span>

                <h1>
                    SIMONIKA
                    <span>SGN</span>
                </h1>

                <p>
                    Sistem Monitoring Karyawan SGN yang dirancang
                    untuk membantu pengelolaan informasi SDM
                    secara lebih terstruktur, aman, dan terintegrasi.
                </p>

            </div>


            {{-- Feature --}}
            <div class="brand-features">

                <div class="brand-feature">

                    <div class="feature-icon">
                        👥
                    </div>

                    <div>
                        <strong>Data Karyawan</strong>
                        <span>Informasi SDM terpusat</span>
                    </div>

                </div>


                <div class="brand-feature">

                    <div class="feature-icon">
                        📄
                    </div>

                    <div>
                        <strong>Dokumen SDM</strong>
                        <span>Dokumen tersimpan terstruktur</span>
                    </div>

                </div>


                <div class="brand-feature">

                    <div class="feature-icon">
                        📊
                    </div>

                    <div>
                        <strong>Monitoring</strong>
                        <span>Pengelolaan data lebih mudah</span>
                    </div>

                </div>

            </div>


            <div class="brand-footer">

                <span>
                    SIMONIKA SGN
                </span>

                <span class="brand-footer-dot">
                    •
                </span>

                <span>
                    Human Resources
                </span>

            </div>

        </div>


        {{-- RIGHT : LOGIN --}}
        <div class="login-form-panel">

            <div class="login-form-content">

                <div class="login-welcome">

                    <div class="welcome-icon">
                        <span>↗</span>
                    </div>

                    <div>

                        <span class="login-label">
                            ADMIN SDM
                        </span>

                        <h2>
                            Selamat Datang
                        </h2>

                    </div>

                </div>


                <p class="login-description">
                    Silakan masuk menggunakan akun admin
                    untuk mengakses dashboard SIMONIKA.
                </p>


                {{-- Alert --}}
                <x-alert />


                <form
                    action="{{ route('login.process') }}"
                    method="POST"
                    class="login-form"
                >

                    @csrf


                    {{-- EMAIL --}}
                    <div class="login-field">

                        <label for="email">
                            Email
                        </label>

                        <div class="login-input-wrapper">

                            <div class="login-input-icon">
                                @
                            </div>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Masukkan email admin"
                                autocomplete="email"
                                required
                                autofocus
                            >

                        </div>

                        @error('email')

                            <small class="login-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- PASSWORD --}}
                    <div class="login-field">

                        <div class="login-label-row">

                            <label for="password">
                                Password
                            </label>

                        </div>

                        <div class="login-input-wrapper">

                            <div class="login-input-icon">
                                •
                            </div>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                            >

                            <button
                                type="button"
                                class="login-password-toggle"
                                data-password-toggle="password"
                            >
                                Tampilkan
                            </button>

                        </div>

                        @error('password')

                            <small class="login-error">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- OPTIONS --}}
                    <div class="login-options">

                        <label class="remember-label">

                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                            >

                            <span class="custom-checkbox"></span>

                            <span>
                                Ingat saya
                            </span>

                        </label>

                    </div>


                    {{-- BUTTON --}}
                    <button
                        type="submit"
                        class="login-submit-button"
                    >

                        <span>
                            Masuk ke Dashboard
                        </span>

                        <span class="submit-arrow">
                            →
                        </span>

                    </button>

                </form>


                {{-- Back --}}
                <a
                    href="{{ route('public.home') }}"
                    class="login-back-link"
                >

                    <span>←</span>

                    Kembali ke halaman utama

                </a>


                <div class="login-security">

                    <span class="security-icon">
                        🔒
                    </span>

                    <span>
                        Halaman khusus Admin SDM
                    </span>

                </div>

            </div>

        </div>

    </div>


    {{-- Bottom Copyright --}}
    <div class="login-copyright">

        © {{ date('Y') }}
        PT Sinergi Gula Nusantara
        <span>•</span>
        SIMONIKA SGN

    </div>

</div>

@endsection