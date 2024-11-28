@extends('layouts.master')

@section('title')
    Manage Kios - Admin
@endsection

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Kelola Kios</h3>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <!-- Tombol untuk memanggil modal -->
            <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#createModal">
                Tambahkan Kios
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Data Kios</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="KiosTable" class="display table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kios</th>
                                    <th>Harga</th>
                                    <th>Status Penyewaan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kios</th>
                                    <th>Harga</th>
                                    <th>Status Penyewaan</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Create Data -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Kios Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createKiosForm" action="{{ route('kios.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_kios" class="form-label">Nama Kios</label>
                            <input type="text" class="form-control" id="nama_kios" name="nama_kios"
                                value="{{ old('nama_kios') }}">
                            @error('nama_kios')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="harga_kios" class="form-label">Harga Kios</label>
                            <input type="number" class="form-control" id="harga_kios" name="harga_kios"
                                value="{{ old('harga_kios') }}">
                            @error('harga_kios')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Kios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="{{ route('kios.update') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_update" id="editId">

                        <div class="mb-3">
                            <label for="editNamaKios" class="form-label">Nama Kios</label>
                            <input type="text" class="form-control" id="editNamaKios" name="nama_kios_update"
                                value="{{ old('nama_kios_update') }}">
                        </div>

                        <div class="mb-3">
                            <label for="editHargaKios" class="form-label">Harga Kios</label>
                            <input type="text" class="form-control" id="editHargaKios" name="harga_kios_update"
                                value="{{ old('harga_kios_update') }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Kios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteForm" method="POST" action="{{ route('kios.delete') }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p id="deleteConfirmationText">Apakah Anda yakin ingin menghapus data ini?</p>
                        <input type="hidden" name="id" id="deleteId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" form="deleteForm" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mt-4 d-none" id="historyContainer">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">History Penyewaan</div>
                    </div>
                </div>
                <div class="card-body">
                    <ul id="historyList" class="list-group"></ul>
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
        $(document).ready(function() {

            $('#KiosTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/kios-data',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_kios',
                        name: 'nama_kios'
                    },
                    {
                        data: 'harga_kios',
                        name: 'harga_kios'
                    },
                    {
                        data: 'status_penyewaan',
                        name: 'status_penyewaan',
                        render: function(data, type, row) {
                            if (data === 'Kosong') {
                                return '<span class="badge badge-success">Kosong / Belum Disewa</span>';
                            } else if (data === 'Disewa') {
                                return '<span class="badge badge-danger">Tidak Kosong / Disewa</span>';
                            }
                            return '<span class="badge badge-secondary">Status Tidak Diketahui</span>'; // Jika data tidak valid
                        }
                    },

                    {
                        data: null,
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // Tombol langsung di-render di sini
                            return `
                        <button type="button" class="btn btn-sm btn-warning editButton"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal"
                            data-id="${row.id}"
                            data-nama_kios="${row.nama_kios}"
                            data-harga_kios="${row.harga_kios}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger deleteButton"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-id="${row.id}"
                            data-nama_kios="${row.nama_kios}">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-info historyButton"
                            data-id="${row.id}">
                            <i class="fas fa-history"></i>
                        </button>
                    `;
                        },
                    },
                ],
            });
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.historyButton')) {
                const button = e.target.closest('.historyButton');
                const kiosId = button.getAttribute('data-id');

                // Ambil data history penyewaan dari server
                fetch(`/kios/${kiosId}/history`)
                    .then(response => response.json())
                    .then(data => {
                        const historyContainer = document.getElementById('historyContainer');
                        const historyList = document.getElementById('historyList');

                        // Kosongkan list sebelumnya
                        historyList.innerHTML = '';

                        // Tambahkan data ke dalam list
                        if (data.length > 0) {
                            data.forEach(item => {
                                const listItem = document.createElement('li');
                                listItem.className = 'list-group-item';

                                // Format tanggal
                                const periodeAwal = formatDate(item.periode_awal);
                                const periodeAkhir = formatDate(item.periode_akhir);

                                // Baris pertama: Nama penyewa sebagai tautan
                                const link = document.createElement('a');
                                link.href = `/profile-show/${item.user_id}`; // URL detail pengguna
                                link.textContent = `${item.nama_penyewa}`;
                                link.className = 'text-primary';

                                // Baris kedua: Periode kontrak
                                const period = document.createElement('div');
                                period.textContent =
                                ` Periode Sewa: ${periodeAwal} s/d ${periodeAkhir}`;
                                period.className = 'text-muted px-2';

                                // Gabungkan ke dalam list item
                                listItem.appendChild(link);
                                listItem.appendChild(period);

                                historyList.appendChild(listItem);
                            });
                        } else {
                            const emptyItem = document.createElement('li');
                            emptyItem.className = 'list-group-item text-muted';
                            emptyItem.textContent = 'Belum ada data history penyewaan.';
                            historyList.appendChild(emptyItem);
                        }

                        // Tampilkan container
                        historyContainer.classList.remove('d-none');
                    })
                    .catch(error => {
                        console.error('Error fetching history:', error);
                    });
            }
        });

        // Fungsi untuk format tanggal
        function formatDate(isoDate) {
            const date = new Date(isoDate);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }

        // Event listener untuk tombol Edit
        document.addEventListener('click', function(e) {
            if (e.target.closest('.editButton')) {
                const button = e.target.closest('.editButton');
                const id = button.getAttribute('.data-id');
                const namaKios = button.getAttribute('data-nama_kios');
                const hargaKios = button.getAttribute('data-harga_kios');

                // Isi data ke dalam form
                editForm.querySelector('#editId').value = id;
                editForm.querySelector('#editNamaKios').value = namaKios;
                editForm.querySelector('#editHargaKios').value = hargaKios;
            }
        });

        // Event listener untuk tombol Delete
        document.addEventListener('click', function(e) {
            if (e.target.closest('.deleteButton')) {
                const button = e.target.closest('.deleteButton'); // Tombol yang memicu modal
                const id = button.getAttribute('data-id'); // Ambil data-id
                const namaKios = button.getAttribute('data-nama_kios'); // Ambil data-nomor_kios

                // Masukkan ID ke dalam input hidden
                const deleteIdInput = deleteModal.querySelector('#deleteId');
                deleteIdInput.value = id;

                // Perbarui teks konfirmasi dengan nomor Kios
                const confirmationText = deleteModal.querySelector('#deleteConfirmationText');
                confirmationText.textContent =
                    `Apakah Anda yakin ingin menghapus data Kios ${namaKios}?`;
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
