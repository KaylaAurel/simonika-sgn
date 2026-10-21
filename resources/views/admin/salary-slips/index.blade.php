@extends('layouts.admin')

@section('title', 'Slip Gaji - SIMONIKA SGN')

@section('page_title', 'Slip Gaji')

@section('admin-content')

<div class="content-page salary-page">

    {{-- HEADER --}}
    <div class="content-header salary-page-header">

        <div>
            <span class="content-eyebrow">
                PAYROLL
            </span>

            <h2>
                Slip Gaji
            </h2>

            <p>
                Kelola slip gaji dan pengiriman melalui WhatsApp.
            </p>
        </div>

        <a
            href="{{ route('admin.salary-slips.upload') }}"
            class="btn btn-primary"
        >
            + Upload Slip Gaji
        </a>

    </div>


    {{-- TABLE CARD --}}
    <div class="salary-table-card">

        <div class="salary-table-top">

            <div>
                <h3>
                    Daftar Slip Gaji
                </h3>

                <p>
                    Data slip gaji yang telah diunggah ke SIMONIKA.
                </p>
            </div>

        </div>


        <div class="table-responsive">

            <table class="data-table salary-table">

                <thead>

                    <tr>

                        <th>Karyawan</th>

                        <th>Periode</th>

                        <th>Status</th>

                        <th>Tanggal Kirim</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($salarySlips as $slip)

                        <tr>

                            {{-- KARYAWAN --}}
                            <td>

                                <div class="table-employee salary-employee">

                                    <img
                                        src="{{ $slip->employee->photo_url }}"
                                        alt="{{ $slip->employee->nama }}"
                                    >

                                    <div>

                                        <strong>
                                            {{ $slip->employee->nama }}
                                        </strong>

                                        <span>
                                            {{ $slip->employee->nopeg }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            {{-- PERIODE --}}
                            <td>

                                <span class="salary-period">
                                    {{ $slip->periode }}
                                </span>

                            </td>


                            {{-- STATUS --}}
                            <td>

                                @php

                                    $statusClass = match($slip->status) {

                                        'sent' => 'badge-green',

                                        'failed' => 'badge-red',

                                        'processing' => 'badge-yellow',

                                        default => 'badge-blue',

                                    };

                                @endphp

                                <span class="badge {{ $statusClass }}">

                                    {{ $slip->status_name }}

                                </span>

                            </td>


                            {{-- TANGGAL KIRIM --}}
                            <td>

                                <span class="salary-date">

                                    {{ $slip->sent_at?->format('d M Y H:i') ?? '-' }}

                                </span>

                            </td>


                            {{-- AKSI --}}
                            <td>

                                <a
                                    href="{{ route('admin.salary-slips.show', $slip->id) }}"
                                    class="salary-detail-button"
                                >
                                    Detail
                                    <span>→</span>
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5">

                                <div class="salary-empty-state">

                                    <div class="salary-empty-icon">
                                        💳
                                    </div>

                                    <h3>
                                        Belum Ada Slip Gaji
                                    </h3>

                                    <p>
                                        Belum ada slip gaji yang diunggah.
                                    </p>

                                    <a
                                        href="{{ route('admin.salary-slips.upload') }}"
                                        class="btn btn-primary"
                                    >
                                        + Upload Slip Gaji
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if(method_exists($salarySlips, 'links'))

            <div class="salary-pagination">

                {{ $salarySlips->links() }}

            </div>

        @endif

    </div>

</div>

@endsection