<aside class="admin-sidebar">

    <div class="sidebar-brand">

        <img
            src="{{ asset('images/logosgn.png') }}"
            alt="Logo SGN"
        >

        <div>
            <strong>
                SIMONIKA
            </strong>

            <span>
                ADMIN SDM
            </span>
        </div>

    </div>


    <div class="sidebar-section">

        <span class="sidebar-label">
            MENU UTAMA
        </span>

        <a
            href="{{ route('admin.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
        >
            <span class="sidebar-icon">⌂</span>
            <span>Dashboard</span>
        </a>


        <a
            href="{{ route('admin.employees.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}"
        >
            <span class="sidebar-icon">👥</span>
            <span>Data Karyawan</span>
        </a>


        <a
            href="{{ route('admin.documents.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}"
        >
            <span class="sidebar-icon">📄</span>
            <span>Dokumen</span>
        </a>


        <a
            href="{{ route('admin.trainings.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.trainings.*') ? 'active' : '' }}"
        >
            <span class="sidebar-icon">📚</span>
            <span>Pelatihan</span>
        </a>


        <a
            href="{{ route('admin.awards.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.awards.*') ? 'active' : '' }}"
        >
            <span class="sidebar-icon">🏆</span>
            <span>Penghargaan</span>
        </a>


        <a
            href="{{ route('admin.salary-slips.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.salary-slips.*') ? 'active' : '' }}"
        >
            <span class="sidebar-icon">💰</span>
            <span>Slip Gaji</span>
        </a>

    </div>


    <div class="sidebar-bottom">

        <form
            action="{{ route('logout') }}"
            method="POST"
        >
            @csrf

            <button
                type="submit"
                class="sidebar-logout"
            >
                <span>↪</span>
                Keluar
            </button>

        </form>

    </div>

</aside>