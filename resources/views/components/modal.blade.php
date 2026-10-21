@props([
    'id' => 'modal',
    'title' => 'Konfirmasi',
    'size' => 'medium'
])

<div
    class="modal-overlay"
    id="{{ $id }}"
    aria-hidden="true"
>

    <div
        class="modal-container modal-{{ $size }}"
        role="dialog"
        aria-modal="true"
        aria-labelledby="{{ $id }}Title"
    >

        {{-- Header --}}
        <div class="modal-header">

            <div>

                <span class="modal-label">
                    SIMONIKA SGN
                </span>

                <h2 id="{{ $id }}Title">
                    {{ $title }}
                </h2>

            </div>

            <button
                type="button"
                class="modal-close"
                data-modal-close="{{ $id }}"
                aria-label="Tutup"
            >
                ×
            </button>

        </div>


        {{-- Body --}}
        <div class="modal-body">

            {{ $slot }}

        </div>


        {{-- Footer --}}
        @isset($footer)

            <div class="modal-footer">

                {{ $footer }}

            </div>

        @endisset

    </div>

</div>