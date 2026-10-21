@props([
    'document',
    'title' => null,
    'description' => null,
    'url' => null
])

@php

    $documentTitle = $title ?? $document->type_name;

    $documentDescription = $description
        ?? 'Dokumen resmi karyawan';

@endphp


<div class="document-card">

    <div class="document-card-icon">

        <svg viewBox="0 0 24 24">

            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6Zm0 2 4 4h-4V4Zm-1 12H8v-2h5v2Zm3-4H8v-2h8v2Z"/>

        </svg>

    </div>


    <div class="document-card-content">

        <span class="document-card-type">
            DOKUMEN
        </span>

        <h3>
            {{ $documentTitle }}
        </h3>

        <p>
            {{ $documentDescription }}
        </p>

    </div>


    @if($url)

        <a
            href="{{ $url }}"
            class="document-card-button"
            target="_blank"
            rel="noopener"
        >

            <span>
                Lihat
            </span>

            <span>
                →
            </span>

        </a>

    @endif

</div>