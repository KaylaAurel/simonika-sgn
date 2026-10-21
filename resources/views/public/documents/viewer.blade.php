@extends('layouts.public')

@section('title', 'Dokumen - SIMONIKA SGN')

@section('public_content')

<section class="document-viewer-page">

    <div class="container">

        <div class="document-viewer-header">

            <div>

                <span>
                    DOKUMEN KARYAWAN
                </span>

                <h1>
                    {{ $document->type_name }}
                </h1>

                <p>
                    {{ $document->employee->nama }}
                </p>

            </div>

            <a
                href="{{ route('public.employees.show', $document->employee->id) }}"
                class="btn btn-secondary"
            >
                ← Kembali
            </a>

        </div>


        <div class="document-viewer-notice">

            <span>
                🔒
            </span>

            <p>
                Dokumen ditampilkan dalam mode baca.
                Fitur unduh tidak disediakan pada halaman publik.
            </p>

        </div>


        <div class="document-viewer-frame">

            <iframe
                src="{{ route('public.documents.file', $document->id) }}"
                title="{{ $document->type_name }}"
                loading="lazy"
            ></iframe>

        </div>

    </div>

</section>

@endsection