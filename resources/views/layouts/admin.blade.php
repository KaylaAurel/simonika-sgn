@extends('layouts.app')

@section('body_class', 'admin-page')

@section('content')

<div class="admin-layout">

    {{-- SIDEBAR --}}
    @include('components.sidebar')


    {{-- MAIN CONTENT --}}
    <div class="admin-main">

        {{-- TOPBAR --}}
        <header class="admin-topbar">

            <div class="admin-topbar-left">

                <span class="admin-topbar-label">
                    SISTEM MONITORING KARYAWAN
                </span>

                <h1>
                    @yield('page_title', 'Dashboard')
                </h1>

            </div>


            {{-- ADMIN USER --}}
            <div class="admin-user">

                <div class="admin-user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>

                <div class="admin-user-info">

                    <strong>
                        {{ auth()->user()->name ?? 'Admin SDM' }}
                    </strong>

                    <span>
                        Administrator
                    </span>

                </div>

            </div>

        </header>


        {{-- CONTENT --}}
        <main class="admin-content">

            @include('components.alert')

            @yield('admin-content')

        </main>

    </div>

</div>

@endsection