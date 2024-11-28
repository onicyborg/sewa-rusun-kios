@extends('layouts.master')

@section('title')
    Manage Rusun - Admin
@endsection

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Kelola Rusun</h3>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <!-- Tombol untuk memanggil modal -->
            <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#createModal">
                Tambahkan Rusun
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Data Rusun</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="rusunTable" class="display table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Rusun</th>
                                    <th>Lantai</th>
                                    <th>Tower</th>
                                    <th>Harga Sewa</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Rusun</th>
                                    <th>Lantai</th>
                                    <th>Tower</th>
                                    <th>Harga Sewa</th>
                                    <th>Status</th>
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
                    <h5 class="modal-title" id="createModalLabel">Tambah Rusun Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createRusunForm" action="{{ route('rusun.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nomor_rusun" class="form-label">Nomor Rusun</label>
                            <input type="text" class="form-control" id="nomor_rusun" name="nomor_rusun"
                                value="{{ old('nomor_rusun') }}">
                            @error('nomor_rusun')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="lantai" class="form-label">Lantai</label>
                            <input type="text" class="form-control" id="lantai" name="lantai"
                                value="{{ old('lantai') }}">
                            @error('lantai')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tower" class="form-label">Tower</label>
                            <input type="text" class="form-control" id="tower" name="tower"
                                value="{{ old('tower') }}">
                            @error('tower')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="harga_sewa" class="form-label">Harga Sewa</label>
                            <input type="number" class="form-control" id="harga_sewa" name="harga_sewa"
                                value="{{ old('harga_sewa') }}">
                            @error('harga_sewa')
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
                    <h5 class="modal-title" id="editModalLabel">Edit Rusun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="{{ route('rusun.update') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_update" id="editId">

                        <div class="mb-3">
                            <label for="editNomorRusun" class="form-label">Nomor Rusun</label>
                            <input type="text" class="form-control" id="editNomorRusun" name="nomor_rusun_update"
                                value="{{ old('nomor_rusun_update') }}">
                        </div>

                        <div class="mb-3">
                            <label for="editLantai" class="form-label">Lantai</label>
                            <input type="text" class="form-control" id="editLantai" name="lantai_update"
                                value="{{ old('lantai_update') }}">
                        </div>

                        <div class="mb-3">
                            <label for="editTower" class="form-label">Tower</label>
                            <input type="text" class="form-control" id="editTower" name="tower_update"
                                value="{{ old('tower_update') }}">
                        </div>

                        <div class="mb-3">
                            <label for="editHargaSewa" class="form-label">Harga Sewa</label>
                            <input type="number" class="form-control" id="editHargaSewa" name="harga_sewa_update"
                                value="{{ old('harga_sewa_update') }}">
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
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Rusun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteForm" method="POST" action="{{ route('rusun.delete') }}">
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
            document.addEventListener('click', function(e) {
                if (e.target.closest('.editButton')) {
                    const button = e.target.closest('.editButton'); // Pastikan elemen tombol yang dipilih
                    const id = button.getAttribute('data-id');
                    const nomorRusun = button.getAttribute('data-nomor_rusun');
                    const lantai = button.getAttribute('data-lantai');
                    const tower = button.getAttribute('data-tower');
                    const hargaSewa = button.getAttribute('data-harga_sewa');

                    // Isi data ke dalam form
                    editForm.querySelector('#editId').value = id;
                    editForm.querySelector('#editNomorRusun').value = nomorRusun;
                    editForm.querySelector('#editLantai').value = lantai;
                    editForm.querySelector('#editTower').value = tower;
                    editForm.querySelector('#editHargaSewa').value = hargaSewa;
                }
            });

            // Event listener untuk tombol Delete
            document.addEventListener('click', function(e) {
                if (e.target.closest('.deleteButton')) {
                    const button = e.target.closest('.deleteButton'); // Tombol yang memicu modal
                    const id = button.getAttribute('data-id'); // Ambil data-id
                    const nomorRusun = button.getAttribute('data-nomor_rusun'); // Ambil data-nomor_rusun

                    // Masukkan ID ke dalam input hidden
                    const deleteIdInput = deleteModal.querySelector('#deleteId');
                    deleteIdInput.value = id;

                    // Perbarui teks konfirmasi dengan nomor rusun
                    const confirmationText = deleteModal.querySelector('#deleteConfirmationText');
                    confirmationText.textContent =
                        `Apakah Anda yakin ingin menghapus data rusun ${nomorRusun}?`;
                }
            });

            $('#rusunTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/rusun-data',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nomor_rusun',
                        name: 'nomor_rusun'
                    },
                    {
                        data: 'lantai',
                        name: 'lantai'
                    },
                    {
                        data: 'tower',
                        name: 'tower'
                    },
                    {
                        data: 'harga_sewa',
                        name: 'harga_sewa'
                    },
                    {
                        data: 'status',
                        name: 'status',
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
                            data-nomor_rusun="${row.nomor_rusun}"
                            data-lantai="${row.lantai}"
                            data-tower="${row.tower}"
                            data-harga_sewa="${row.harga_sewa}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger deleteButton"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-id="${row.id}"
                            data-nomor_rusun="${row.nomor_rusun}">
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
                const rusunId = button.getAttribute('data-id');

                // Ambil data history penyewaan dari server
                fetch(`/rusun/${rusunId}/history`)
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
                                period.textContent = ` Periode Sewa: ${periodeAwal} s/d ${periodeAkhir}`;
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
