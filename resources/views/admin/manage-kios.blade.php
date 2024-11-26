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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kios</th>
                                    <th>Harga</th>
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
                    `;
                        },
                    },
                ],
            });
        });

        // Event listener untuk tombol Edit
        document.addEventListener('click', function(e) {
            if (e.target.closest('.editButton')) {
                const id = e.target.getAttribute('data-id');
                const namaKios = e.target.getAttribute('data-nama_kios');
                const hargaKios = e.target.getAttribute('data-harga_kios');

                // Isi data ke dalam form
                editForm.querySelector('#editId').value = id;
                editForm.querySelector('#editNamaKios').value = namaKios;
                editForm.querySelector('#editHargaKios').value = hargaKios;
            }
        });

        // Event listener untuk tombol Delete
        document.addEventListener('click', function(e) {
            if (e.target.closest('.deleteButton')) {
                const button = event.relatedTarget; // Tombol yang memicu modal
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
