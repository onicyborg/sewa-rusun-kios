@extends('layouts.master')

@section('title')
    Keluhan - User
@endsection

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Keluhan</h3>
            <h6 class="op-7 mb-2">Data Keluhan Penghuni</h6>
        </div>
    </div>

    <div class="row">
        <!-- Penyewaan Aktif -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card card-round shadow">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Penyewaan Aktif</div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Profile Details -->
                    <div class="card-body">
                        @forelse ($data_rusun->where('status', 'active') as $item)
                            <div class="mb-3">
                                <h6 class="fw-bold">Rusun {{ $item->rusun->nomor_rusun }}</h6>
                                <p class="text-muted mb-2">
                                    <strong>Alamat:</strong>
                                    {{ 'Tower ' . $item->rusun->tower . ' Lt.' . $item->rusun->lantai . ' No. ' . $item->rusun->nomor_rusun }}
                                    <br>
                                    <strong>Durasi Sewa:</strong>
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai_kontrak)->format('d-m-Y') }} s/d
                                    {{ \Carbon\Carbon::parse($item->tanggal_selesai_kontrak)->format('d-m-Y') }}
                                </p>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalTambahKeluhan" data-id="{{ $item->id }}">
                                    Tambahkan Keluhan
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalListKeluhan" data-id="{{ $item->id }}">
                                    Lihat Riwayat Keluhan
                                </button>
                            </div>
                        @empty
                            <p class="text-center">Tidak ada penyewaan aktif saat ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card card-round shadow">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Penyewaan Tidak Aktif</div>
                    </div>
                </div>
                <div class="card-body">
                    @forelse ($data_rusun->where('status', 'expired') as $item)
                        <div class="mb-3">
                            <h6 class="fw-bold">Rusun {{ $item->rusun->nomor_rusun }}</h6>
                            <p class="text-muted mb-2">
                                <strong>Alamat:</strong>
                                {{ 'Tower ' . $item->rusun->tower . ' Lt.' . $item->rusun->lantai . ' No. ' . $item->rusun->nomor_rusun }}
                                <br>
                                <strong>Durasi Sewa:</strong>
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai_kontrak)->format('d-m-Y') }} s/d
                                {{ \Carbon\Carbon::parse($item->tanggal_selesai_kontrak)->format('d-m-Y') }}
                            </p>
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalListKeluhan" data-id="{{ $item->id }}">
                                Lihat Riwayat Keluhan
                            </button>
                        </div>
                        <hr>
                    @empty
                        <p class="text-center">Tidak ada penyewaan tidak aktif.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Keluhan -->
    <div class="modal fade" id="modalTambahKeluhan" tabindex="-1" aria-labelledby="modalTambahKeluhanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKeluhanLabel">Tambah Keluhan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('keluhan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="sewa_rusun_id" id="sewaRusunId">
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Keluhan</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required
                                placeholder="Deskripsikan Keluhan Anda Pada Rusun Ini"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal List Keluhan -->
    <div class="modal fade" id="modalListKeluhan" tabindex="-1" aria-labelledby="modalListKeluhanLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalListKeluhanLabel">Riwayat Keluhan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableKeluhan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Deskripsi</th>
                                    <th>Mekanik</th>
                                    <th>Kontak Mekanik</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi melalui JavaScript -->
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
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script>
        // Set data rusun id pada modal tambah keluhan
        document.querySelectorAll('[data-bs-target="#modalTambahKeluhan"]').forEach(button => {
            button.addEventListener('click', function() {
                const rusunId = this.getAttribute('data-id');
                document.getElementById('sewaRusunId').value = rusunId;
            });
        });

        // Load data riwayat keluhan pada modal
        document.querySelectorAll('[data-bs-target="#modalListKeluhan"]').forEach(button => {
            button.addEventListener('click', function() {
                const rusunId = this.getAttribute('data-id');
                fetch(`/keluhan/list/${rusunId}`)
                    .then(response => response.json())
                    .then(data => {
                        const tableBody = document.querySelector('#tableKeluhan tbody');
                        tableBody.innerHTML = ''; // Kosongkan isi tabel sebelum menambahkan data baru

                        data.forEach((keluhan, index) => {
                            // Buat link WhatsApp jika mekanik memiliki nomor kontak
                            const whatsappLink = keluhan.mekanikal_no_hp ?
                                `<a href="https://wa.me/${keluhan.mekanikal_no_hp}" target="_blank">${keluhan.mekanikal_no_hp}</a>` :
                                'Tidak ada kontak';

                            // Tentukan badge untuk status
                            let statusBadge;
                            if (keluhan.status === 'Pending') {
                                statusBadge = `<span class="badge badge-danger">Pending</span>`;
                            } else if (keluhan.status === 'Proses') {
                                statusBadge = `<span class="badge badge-warning">Proses</span>`;
                            } else {
                                statusBadge =
                                `<span class="badge badge-success">Selesai</span>`;
                            }

                            const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${keluhan.deskripsi}</td>
                            <td>${keluhan.mekanikal_name || 'Tidak ada mekanik'}</td>
                            <td>${whatsappLink}</td>
                            <td class="text-center">${statusBadge}</td>
                            <td>${keluhan.created_at_formatted}</td>
                        </tr>
                    `;
                            tableBody.innerHTML += row;
                        });

                        // Inisialisasi DataTables setelah data dimuat
                        $('#tableKeluhan')
                    .DataTable(); // Pastikan DataTables sudah terhubung dengan benar
                    })
                    .catch(error => {
                        console.error('Error fetching keluhan data:', error);
                    });
            });
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
