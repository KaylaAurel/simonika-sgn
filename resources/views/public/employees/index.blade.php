@extends('layouts.public')

@section('title', 'Data Karyawan - SIMONIKA SGN')

@section('public-content')

<section class="public-list-page">

    <div class="container">

        <div class="public-page-heading">
            <span>DIREKTORI KARYAWAN</span>

            <h1>Data Karyawan</h1>

            <p>
                Temukan informasi dasar karyawan
                PT Sinergi Gula Nusantara.
            </p>
        </div>


        {{-- SEARCH --}}
        <div class="public-search-card">

            <form action="{{ route('public.employees') }}" method="GET">

                <div class="public-search-input">

                    <span>⌕</span>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama, nomor pegawai, jabatan..."
                    >

                </div>

                <button type="submit" class="btn btn-primary">
                    Cari
                </button>

            </form>

        </div>


        {{-- DATA KARYAWAN --}}
        @if($employees->count())

            <div class="employee-card-grid">

                @foreach($employees as $employee)

                    <x-employee-card :employee="$employee" />

                @endforeach

            </div>


            {{-- PAGINATION --}}
            @if(method_exists($employees, 'links'))

                <div class="pagination-wrapper public-pagination">

                    {{ $employees->links() }}

                </div>

            @endif


        @else

            <div class="public-empty-state">

                <span>🔎</span>

                <h3>Karyawan tidak ditemukan</h3>

                <p>
                    Coba gunakan kata kunci pencarian yang berbeda.
                </p>

                <a
                    href="{{ route('public.employees') }}"
                    class="btn btn-secondary"
                >
                    Reset Pencarian
                </a>

            </div>

        @endif

    </div>

</section>

@endsection