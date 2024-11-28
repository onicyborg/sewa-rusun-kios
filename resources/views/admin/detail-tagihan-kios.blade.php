@extends('layouts.master')

@section('title')
    Detail Tagihan Kios Bulan {{ $bulan . ' ' . $tahun }} - Admin
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
            <h3 class="fw-bold mb-3">List Tagihan Kios Bulan {{ $namaBulan[$bulan] . ' ' . $tahun }}
                @if ($status == 'Release')
                    <span class="badge badge-success">Release</span>
                @else
                    <span class="badge badge-danger">Draft</span>
                @endif
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Data Tagihan Kios</div>
                        <div class="card-tools">
                            @if ($status == 'Draft')
                                <button class="btn btn-primary btn-sm float-right" data-bs-toggle="modal"
                                    data-bs-target="#releaseModal">
                                    <i class="fas fa-rocket"></i>&nbsp; Release Tagihan Bulan
                                    {{ $namaBulan[$bulan] . ' ' . $tahun }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="PenyewaanKiosTable" class="display table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penghuni</th>
                                    <th>Kios</th>
                                    <th>Jumlah Tagihan</th>
                                    <th class="text-center">Status Transaksi</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tagihans as $no => $tagihan)
                                    <tr data-sewa="{{ $tagihan->sewa }}" data-denda="{{ $tagihan->denda }}"
                                        data-air="{{ $tagihan->air }}">
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $tagihan->sewa_kios->penyewa->name }}</td>
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
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editTagihanModal{{ $tagihan->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Update Tagihan -->
                                    <div class="modal fade" id="editTagihanModal{{ $tagihan->id }}" tabindex="-1"
                                        aria-labelledby="editTagihanLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form id="updateTagihanForm" method="POST"
                                                    action="{{ route('update.tagihan-kios', $tagihan->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editTagihanLabel">Update Tagihan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Detail Penghuni -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <h6>Detail Penghuni</h6>
                                                                <ul class="list-group">
                                                                    <li class="list-group-item"><strong>Nama
                                                                            Penghuni:</strong>
                                                                        <span
                                                                            id="namaPenghuni">&nbsp;{{ $tagihan->sewa_kios->penyewa->name }}</span>
                                                                    </li>
                                                                    <li class="list-group-item"><strong>No KTP:</strong>
                                                                        <span
                                                                            id="ktpPenghuni">&nbsp;{{ $tagihan->sewa_kios->penyewa->nik }}</span>
                                                                    </li>
                                                                    <li class="list-group-item"><strong>Kontak:</strong>
                                                                        <span
                                                                            id="kontakPenghuni">&nbsp;{{ $tagihan->sewa_kios->penyewa->whatsapp }}</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>Detail Kios</h6>
                                                                <ul class="list-group">
                                                                    <li class="list-group-item"><strong>Nama Kios:</strong>
                                                                        <span
                                                                            id="towerKios">&nbsp;{{ $tagihan->sewa_kios->kios->nama_kios }}</span>
                                                                    </li>
                                                                    <li class="list-group-item"><strong>Harga Kios:</strong>
                                                                        <span
                                                                            id="lantaiKios">&nbsp;Rp.{{ number_format($tagihan->sewa_kios->kios->harga_kios) }}</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <!-- Form Update Tagihan -->
                                                        <h6 class="mb-3">Update Tagihan</h6>
                                                        <div class="mb-3">
                                                            <label for="sewa" class="form-label">Biaya Sewa</label>
                                                            <input type="number" class="form-control" id="sewa"
                                                                name="sewa" value="{{ $tagihan->sewa }}" readonly>
                                                        </div>
                                                        <hr>
                                                        <h6 class="mb-3">Update Status Pembayaran</h6>
                                                        <div class="mb-3">
                                                            <label for="status_pembayaran" class="form-label">Status
                                                                Pembayaran</label>
                                                            <select id="status_pembayaran" name="status_pembayaran"
                                                                class="form-control"
                                                                {{ $status == 'Draft' ? 'disabled' : '' }}>
                                                                <option value="Dibayar"
                                                                    {{ $tagihan->status_pembayaran == 'Dibayar' ? 'selected' : '' }}>
                                                                    Dibayar</option>
                                                                <option value="Belum Dibayar"
                                                                    {{ $tagihan->status_pembayaran == 'Belum Dibayar' ? 'selected' : '' }}>
                                                                    Belum Dibayar</option>
                                                            </select>

                                                            @if ($status == 'Draft')
                                                                <input type="hidden" name="status_pembayaran"
                                                                    value="{{ $tagihan->status_pembayaran }}">
                                                                <small class="text-danger mt-1 d-block">
                                                                    Jika ingin mengubah status pembayaran, harap release
                                                                    terlebih dahulu seluruh tagihan pada data saat ini.
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Konfirmasi Perilisan Tagihan -->
    <div class="modal fade" id="releaseModal" tabindex="-1" aria-labelledby="releaseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="releaseModalLabel">Konfirmasi Perilisan Tagihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin merilis tagihan untuk bulan <strong>{{ $namaBulan[$bulan] }}
                            {{ $tahun }}</strong>? Setelah dirilis, tagihan tidak dapat diubah lagi.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('release.tagihan-kios', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                        method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-rocket"></i> Rilis Tagihan
                        </button>
                    </form>
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
            const table = $('#PenyewaanKiosTable').DataTable();

            // Event listener untuk tombol toggle details
            $('#PenyewaanKiosTable').on('click', '.toggle-details', function() {
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
