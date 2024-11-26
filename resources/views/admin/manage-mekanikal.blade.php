@extends('layouts.master')

@section('title')
    Manage Mekanikal - Admin
@endsection

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Kelola Mekanikal</h3>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <!-- Tombol untuk memanggil modal -->
            <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#createModal">
                Tambahkan Mekanikal
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Data Mekanikal</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="MekanikTable" class="display table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mekanik</th>
                                    <th>Nomor HP / Whatsapp</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mekanik</th>
                                    <th>Nomor HP / Whatsapp</th>
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
                    <h5 class="modal-title" id="createModalLabel">Tambah Mekanik Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createMekanikForm" action="{{ route('mekanikal.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Mekanik</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor HP / Whatsapp</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input type="text" class="form-control" id="no_hp" name="no_hp"
                                    value="{{ old('no_hp') }}" pattern="[1-9][0-9]*" inputmode="numeric"
                                    placeholder="8123456789">
                            </div>
                            @error('no_hp')
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
                    <h5 class="modal-title" id="editModalLabel">Edit Mekanik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="{{ route('mekanikal.update') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_update" id="editId">

                        <div class="mb-3">
                            <label for="editNamaMekanik" class="form-label">Nama Mekanik</label>
                            <input type="text" class="form-control" id="editNamaMekanik" name="name_update"
                                value="{{ old('name_update') }}">
                        </div>

                        <div class="mb-3">
                            <label for="editNoHp" class="form-label">Nomor HP / Whatsapp</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input type="text" class="form-control" id="editNoHp" name="no_hp_update"
                                    value="{{ old('no_hp_update') }}" pattern="[1-9][0-9]*" inputmode="numeric"
                                    placeholder="8123456789">
                            </div>
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
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Mekanik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteForm" method="POST" action="{{ route('mekanikal.delete') }}">
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
            $('#MekanikTable').DataTable({
                processing: true,
                serverSide: true,
                deferRender: true, // Optimalisasi render
                ajax: '/mekanikal-data',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp',
                    },
                    {
                        data: null, // Tidak langsung mengambil dari database
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
                            data-name="${row.name}"
                            data-no_hp="${row.no_hp}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger deleteButton"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-id="${row.id}"
                            data-name="${row.name}">
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
                const button = e.target.closest('.editButton');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const noHp = button.getAttribute('data-no_hp');

                const formattedNoHp = noHp.startsWith('+62') ? noHp.replace('+62', '') : noHp;

                // Isi modal Edit
                const editModal = document.getElementById('editModal');
                editModal.querySelector('#editId').value = id;
                editModal.querySelector('#editNamaMekanik').value = name;
                editModal.querySelector('#editNoHp').value = formattedNoHp;
            }
        });

        // Event listener untuk tombol Delete
        document.addEventListener('click', function(e) {
            if (e.target.closest('.deleteButton')) {
                const button = e.target.closest('.deleteButton');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');

                // Isi modal Delete
                const deleteModal = document.getElementById('deleteModal');
                deleteModal.querySelector('#deleteId').value = id;
                deleteModal.querySelector('#deleteConfirmationText').textContent =
                    `Apakah Anda yakin ingin menghapus mekanik ${name}?`;
            }
        });

        document.getElementById('no_hp').addEventListener('input', function(event) {
            // Menghapus semua karakter yang bukan angka
            this.value = this.value.replace(/[^0-9]/g, '');

            // Mencegah angka 0 di awal
            if (this.value.startsWith('0')) {
                this.value = this.value.slice(1); // Hapus karakter pertama jika 0
            }
        });

        document.getElementById('editNoHp').addEventListener('input', function(event) {
            // Menghapus semua karakter yang bukan angka
            this.value = this.value.replace(/[^0-9]/g, '');

            // Mencegah angka 0 di awal
            if (this.value.startsWith('0')) {
                this.value = this.value.slice(1); // Hapus karakter pertama jika 0
            }
        });


        // SweetAlert untuk flash message
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: {!! json_encode(session('success')) !!},
                confirmButtonText: 'OK'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: {!! json_encode($errors->first()) !!},
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush
