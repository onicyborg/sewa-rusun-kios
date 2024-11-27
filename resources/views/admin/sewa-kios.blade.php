@extends('layouts.master')

@section('title')
    Manage Penyewaan Kios - Admin
@endsection

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Kelola Penyewaan Kios</h3>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <!-- Tombol untuk memanggil modal -->
            <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#createModal">
                Tambahkan Penyewaan Kios
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Data Penyewaan Kios</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="PenyewaanKiosTable" class="display table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penyewa</th>
                                    <th>Nama Kios</th>
                                    <th>Tanggal Mulai Sewa</th>
                                    <th>Tanggal Selesai Sewa</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Detail</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penyewa</th>
                                    <th>Nama Kios</th>
                                    <th>Tanggal Mulai Sewa</th>
                                    <th>Tanggal Selesai Sewa</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Detail</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($sewas as $no => $sewa)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $sewa->penyewa->name }}</td>
                                        <td>{{ $sewa->kios->nama_kios }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sewa->tanggal_mulai_kontrak)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sewa->tanggal_selesai_kontrak)->format('d-m-Y') }}
                                        </td>
                                        <td class="text-center">
                                            @if ($sewa->status == 'active')
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Non-Active</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- Tombol Detail -->
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $sewa->id }}">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="detailModal{{ $sewa->id }}" tabindex="-1"
                                        aria-labelledby="detailModalLabel{{ $sewa->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel{{ $sewa->id }}">Detail
                                                        Penyewaan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <!-- Detail Penyewa -->
                                                        <div class="col-md-8">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <div class="me-3">
                                                                    <img src="{{ $sewa->penyewa->foto ? asset('storage/' . $sewa->penyewa->foto) : asset('assets/img/default.png') }}"
                                                                        alt="Foto Penyewa" class="img-thumbnail"
                                                                        style="width: 150px; height: 150px; object-fit: cover;">
                                                                </div>
                                                                <div>
                                                                    <h5>Detail Penyewa</h5>
                                                                    <p><strong>Nama:</strong> {{ $sewa->penyewa->name }}
                                                                    </p>
                                                                    <p><strong>Email:</strong>
                                                                        {{ $sewa->penyewa->email ?? '-' }}</p>
                                                                    <p><strong>WhatsApp:</strong>
                                                                        {{ $sewa->penyewa->whatsapp }}</p>
                                                                    <p><strong>Gender:</strong>
                                                                        {{ $sewa->penyewa->gender }}</p>
                                                                    <p><strong>Pekerjaan:</strong>
                                                                        {{ $sewa->penyewa->jenis_pekerjaan ?? '-' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Detail Kios -->
                                                        <div class="col-md-4">
                                                            <h5>Detail Kios</h5>
                                                            <div>
                                                                <p><strong>Nama Kios:</strong>
                                                                    {{ $sewa->kios->nama_kios }}</p>
                                                                <p><strong>Harga Sewa:</strong>
                                                                    Rp{{ number_format($sewa->kios->harga_kios, 0, ',', '.') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
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

    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Data Tagihan Kios</div>
                        <div class="card-tools">
                            <button class="btn btn-primary btn-sm float-right" data-bs-toggle="modal"
                                data-bs-target="#addTagihanModal">
                                <i class="fa fa-plus"></i> Tambah Tagihan Bulanan
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="filter-container mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="filterBulan">Bulan:</label>
                                <select id="filterBulan" class="form-control">
                                    <option value="">All</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="filterTahun">Tahun:</label>
                                <select id="filterTahun" class="form-control">
                                    <option value="">All</option>
                                    @foreach (range(2024, date('Y')) as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Filter Section for Year and Month -->

                        <table id="TagihanKiosTable" class="display table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Status</th>
                                    <th>Tagihan Dibayar</th>
                                    <th>Tagihan Belum Dibayar</th>
                                    <th class="text-center">Detail</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Status</th>
                                    <th>Tagihan Dibayar</th>
                                    <th>Tagihan Belum Dibayar</th>
                                    <th class="text-center">Detail</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <!-- Data will be loaded via DataTables server-side -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create Data -->
    <div class="modal fade" id="createModal" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Penyewaan Kios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createKiosForm" action="{{ route('sewa-kios.store') }}" method="POST">
                        @csrf
                        <!-- Field untuk Memilih Penyewa -->
                        <div class="mb-3">
                            <label for="penyewa" class="form-label">Penyewa</label>
                            <select id="penyewa" name="penyewa"
                                class="form-control @error('penyewa') is-invalid @enderror" style="width: 100%;">
                                <option value="" disabled {{ old('penyewa') == '' ? 'selected' : '' }}>Pilih Penyewa
                                </option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('penyewa') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('penyewa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Field untuk Memilih Kios -->
                        <div class="mb-3">
                            <label for="kios" class="form-label">Kios</label>
                            <select id="kios" name="kios"
                                class="form-control @error('kios') is-invalid @enderror" style="width: 100%;">
                                <option value="" disabled {{ old('kios') == '' ? 'selected' : '' }}>Pilih Kios
                                </option>
                                @foreach ($kioss as $kios)
                                    <option value="{{ $kios->id }}"
                                        {{ old('kios') == $kios->id ? 'selected' : '' }}>
                                        {{ $kios->nama_kios }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kios')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Field untuk Memilih Tanggal Mulai Penyewaan -->
                        <!-- Field untuk Tanggal Mulai Penyewaan -->
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Bulan dan Tahun Mulai Penyewaan</label>
                            <input type="month" id="tanggal_mulai" name="tanggal_mulai"
                                class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                value="{{ old('tanggal_mulai') }}">
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Field untuk Tanggal Selesai Kontrak -->
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Bulan dan Tahun Selesai Kontrak</label>
                            <input type="month" id="tanggal_selesai" name="tanggal_selesai"
                                class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                value="{{ old('tanggal_selesai') }}" readonly>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal untuk menambahkan tagihan bulanan -->
    <div class="modal fade" id="addTagihanModal" tabindex="-1" aria-labelledby="addTagihanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addTagihanForm" method="POST" action="/tagihan-kios/add">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTagihanModalLabel">Tambah Tagihan Bulanan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bulanTahun" class="form-label">Pilih Bulan dan Tahun</label>
                            <input type="month" id="bulanTahun" name="bulanTahun" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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
            $('#penyewa').select2({
                placeholder: 'Pilih Penyewa',
                allowClear: true,
                dropdownParent: $('#createModal')
            });
            $('#kios').select2({
                placeholder: 'Pilih Kios',
                allowClear: true,
                dropdownParent: $('#createModal')
            });
            $('#PenyewaanKiosTable').DataTable();
            var table = $('#TagihanKiosTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('tagihanKios.index') }}", // URL untuk mengambil data dari server
                    data: function(d) {
                        // Mengirim data filter (bulan dan tahun)
                        d.bulan = $('#filterBulan').val();
                        d.tahun = $('#filterTahun').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'bulan',
                        name: 'bulan',
                        render: function(data, type, row) {
                            const bulanArray = [
                                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                'Juli', 'Agustus', 'September', 'Oktober', 'November',
                                'Desember'
                            ];
                            return bulanArray[data -
                                1]; // Mengonversi angka bulan (1-12) ke nama bulan
                        }
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            // Kondisi untuk menampilkan badge sesuai status
                            if (data === 'Release') {
                                return `<span class="badge badge-success">Release</span>`;
                            } else if (data === 'Draft') {
                                return `<span class="badge badge-danger">Draft</span>`;
                            } else {
                                return `<span class="badge badge-secondary">Unknown</span>`;
                            }
                        }
                    }, // Menampilkan status: Release/Draft
                    {
                        data: 'tagihan_dibayar',
                        name: 'tagihan_dibayar'
                    },
                    {
                        data: 'tagihan_belum_dibayar',
                        name: 'tagihan_belum_dibayar'
                    },
                    {
                        data: null,
                        name: 'detail',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // Tombol langsung di-render di sini
                            return `
                        <div style="text-align: center;">
                            <a href="/detail-tagihan-bulanan-kios/${row.bulan}/${row.tahun}" class="btn btn-sm btn-primary">
                                <i class="fas fa-database"></i>
                            </a>
                        </div>
                    `;
                        },
                    },
                ]
            });

            // Filter by Bulan
            $('#filterBulan').change(function() {
                table.draw();
            });

            // Filter by Tahun
            $('#filterTahun').change(function() {
                table.draw();
            });

            // Inisialisasi Select2

            // Logika Otomatis Mengisi Tanggal Selesai Kontrak
            document.getElementById('tanggal_mulai').addEventListener('change', function() {
                // Ambil nilai bulan dan tahun dari input
                const [year, month] = this.value.split('-').map(Number);

                if (!isNaN(year) && !isNaN(month)) {
                    // Buat objek tanggal dari bulan dan tahun yang dipilih
                    const tanggalMulai = new Date(year, month - 1);

                    // Tambahkan 24 bulan (2 tahun)
                    tanggalMulai.setMonth(tanggalMulai.getMonth() + 12);

                    // Format hasil menjadi YYYY-MM
                    const formattedDate = tanggalMulai.toISOString().slice(0, 7);

                    // Set nilai pada input tanggal selesai
                    document.getElementById('tanggal_selesai').value = formattedDate;
                } else {
                    // Jika tanggal mulai tidak valid, kosongkan tanggal selesai
                    document.getElementById('tanggal_selesai').value = '';
                }
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
