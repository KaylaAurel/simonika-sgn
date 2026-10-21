@props([
    'employee'
])

<article class="employee-card">

    {{-- FOTO --}}
    <div class="employee-card-photo-wrapper">

        <img
            src="{{ $employee->photo_url }}"
            alt="Foto {{ $employee->nama }}"
            class="employee-card-photo"
            loading="lazy"
        >

        <div class="employee-card-status">
            Aktif
        </div>

    </div>


    {{-- INFORMASI --}}
    <div class="employee-card-body">

        <span class="employee-card-label">
            {{ $employee->nopeg }}
        </span>

        <h3 class="employee-card-name">
            {{ $employee->nama }}
        </h3>

        <p class="employee-card-position">

            <span class="position-icon">
                ◆
            </span>

            {{ $employee->jabatan }}

        </p>

        <p class="employee-card-division">
            {{ $employee->sub_bagian }}
        </p>


        {{-- BUTTON --}}
        <a
            href="{{ route('public.employee.show', $employee->id) }}"
            class="employee-card-button"
        >

            Lihat Profil

            <span>→</span>

        </a>

    </div>

</article>