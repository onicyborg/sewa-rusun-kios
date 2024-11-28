@extends('layouts.master')

@section('title')
    Tagihan - User
@endsection

@php
    $namaBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
@endphp

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">List Tagihan Rusun dan Kios</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Data Tagihan Rusun</div>
                        <div class="card-tools">
                            <a href="http://wa.me/{{ $kontak }}" class="btn btn-primary btn-sm float-right"
                                target="_blank"><i class="fas fa-rocket"></i>&nbsp; Hubungi Admin Untuk Konfirmasi
                                Pembayaran</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5>Total Tagihan yang Belum Dibayar: <span class="text-danger">Rp.
                                {{ number_format($total_tagihan_rusun_belum_dibayar) }}</span>
                            ({{ $total_bulan_rusun_belum_dibayar }} Bulan)</h5>
                    </div>
                    <div class="table-responsive">
                        <table id="TagihanRusunTable" class="display table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Rusun</th>
                                    <th>Jumlah Tagihan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Periode</th>
                                    <th>Rusun</th>
                                    <th>Jumlah Tagihan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($tagihan_rusuns as $no => $tagihan)
                                    <tr data-sewa="{{ $tagihan->sewa }}" data-denda="{{ $tagihan->denda }}"
                                        data-air="{{ $tagihan->air }}">
                                        <td>{{ $namaBulan[$tagihan->bulan] . ' ' . $tagihan->tahun }}</td>
                                        <td>{{ 'Tower ' . $tagihan->sewa_rusun->rusun->tower . ' Lt.' . $tagihan->sewa_rusun->rusun->lantai . ' No. ' . $tagihan->sewa_rusun->rusun->nomor_rusun }}
                                        </td>
                                        <td>Rp. {{ number_format($tagihan->sewa + $tagihan->denda + $tagihan->air) }}</td>
                                        <td class="text-center">
                                            @if ($tagihan->status_pembayaran == 'Dibayar')
                                                <span class="badge badge-success">Dibayar</span>
                                            @else
                                                <span class="badge badge-danger">Belum Dibayar</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-primary btn-sm toggle-details"
                                                data-id="{{ $tagihan->id }}">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Data Tagihan Kios</div>
                        <div class="card-tools">
                            <a href="http://wa.me/{{ $kontak }}" class="btn btn-primary btn-sm float-right"
                                target="_blank"><i class="fas fa-rocket"></i>&nbsp; Hubungi Admin Untuk Konfirmasi
                                Pembayaran</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5>Total Tagihan yang Belum Dibayar: <span class="text-danger">Rp.
                                {{ number_format($total_tagihan_kios_belum_dibayar) }}</span>
                            ({{ $total_bulan_kios_belum_dibayar }} Bulan)</h5>
                    </div>
                    <div class="table-responsive">
                        <table id="TagihanKiosTable" class="display table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Rusun</th>
                                    <th>Jumlah Tagihan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Periode</th>
                                    <th>Rusun</th>
                                    <th>Jumlah Tagihan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($tagihan_kioss as $no => $tagihan)
                                    <tr data-sewa="{{ $tagihan->sewa }}">
                                        <td>{{ $namaBulan[$tagihan->bulan] . ' ' . $tagihan->tahun }}</td>
                                        <td>{{ $tagihan->sewa_kios->kios->nama_kios }}
                                        </td>
                                        <td>Rp. {{ number_format($tagihan->sewa) }}</td>
                                        <td class="text-center">
                                            @if ($tagihan->status_pembayaran == 'Dibayar')
                                                <span class="badge badge-success">Dibayar</span>
                                            @else
                                                <span class="badge badge-danger">Belum Dibayar</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-primary btn-sm toggle-details"
                                                data-id="{{ $tagihan->id }}">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            const table = $('#TagihanRusunTable').DataTable();

            // Event listener untuk tombol toggle details
            $('#TagihanRusunTable').on('click', '.toggle-details', function() {
                const tr = $(this).closest('tr'); // Baris utama
                const row = table.row(tr);

                if (row.child.isShown()) {
                    // Tutup detail dengan animasi
                    $('div.slider', row.child()).slideUp(function() {
                        row.child.hide();
                    });
                    $(this).html('<i class="fas fa-chevron-down"></i>');
                } else {
                    // Buka detail dengan animasi
                    const tagihanId = $(this).data('id');
                    const detailContent = `
                <div class="slider" style="display: none;">
                    <strong>Biaya Sewa:</strong> Rp. ${formatCurrency(tr.data('sewa'))}<br>
                    <strong>Denda:</strong> Rp. ${formatCurrency(tr.data('denda'))}<br>
                    <strong>Air:</strong> Rp. ${formatCurrency(tr.data('air'))}
                </div>
            `;

                    row.child(detailContent).show(); // Buat konten detail tersedia
                    $('div.slider', row.child()).slideDown(); // Animasi slide membuka
                    $(this).html('<i class="fas fa-chevron-up"></i>');
                }
            });

            const table1 = $('#TagihanKiosTable').DataTable();

            // Event listener untuk tombol toggle details
            $('#TagihanKiosTable').on('click', '.toggle-details', function() {
                const tr = $(this).closest('tr'); // Baris utama
                const row = table1.row(tr);

                if (row.child.isShown()) {
                    // Tutup detail dengan animasi
                    $('div.slider', row.child()).slideUp(function() {
                        row.child.hide();
                    });
                    $(this).html('<i class="fas fa-chevron-down"></i>');
                } else {
                    // Buka detail dengan animasi
                    const tagihanId = $(this).data('id');
                    const detailContent = `
                <div class="slider" style="display: none;">
                    <strong>Biaya Sewa:</strong> Rp. ${formatCurrency(tr.data('sewa'))}<br>
                </div>
            `;

                    row.child(detailContent).show(); // Buat konten detail tersedia
                    $('div.slider', row.child()).slideDown(); // Animasi slide membuka
                    $(this).html('<i class="fas fa-chevron-up"></i>');
                }
            });

            // Helper untuk format angka
            function formatCurrency(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                }).format(number);
            }
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: '{{ $errors->first() }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush
