<nav class="site-navbar">

    <div class="container navbar-inner">

        {{-- LOGO --}}
        <a
            href="{{ route('public.home') }}"
            class="brand"
        >

            <img
                src="{{ asset('images/logosgn.png') }}"
                alt="Logo SGN"
                class="brand-logo"
            >

            <div class="brand-text">

                <strong>
                    SIMONIKA
                </strong>

                <span>
                    SGN
                </span>

            </div>

        </a>


        {{-- MENU --}}
        <div class="navbar-menu">

            <a
                href="{{ route('public.home') }}"
                class="navbar-link"
            >
                Beranda
            </a>

            <a
                href="{{ route('public.employees') }}"
                class="navbar-link"
            >
                Data Karyawan
            </a>

        </div>


        {{-- LOGIN --}}
        <a
            href="{{ route('login') }}"
            class="navbar-login"
        >
            <span>↪</span>
            Login Admin
        </a>

    </div>

</nav>