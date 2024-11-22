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
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
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
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editModal');
            const editForm = document.getElementById('editForm');

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('editButton')) {
                    const id = e.target.getAttribute('data-id');
                    const nomorRusun = e.target.getAttribute('data-nomor_rusun');
                    const lantai = e.target.getAttribute('data-lantai');
                    const tower = e.target.getAttribute('data-tower');
                    const hargaSewa = e.target.getAttribute('data-harga_sewa');

                    // Isi data ke dalam form
                    editForm.querySelector('#editId').value = id;
                    editForm.querySelector('#editNomorRusun').value = nomorRusun;
                    editForm.querySelector('#editLantai').value = lantai;
                    editForm.querySelector('#editTower').value = tower;
                    editForm.querySelector('#editHargaSewa').value = hargaSewa;
                }
            });

            const deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Tombol yang memicu modal
                const id = button.getAttribute('data-id'); // Ambil data-id
                const nomorRusun = button.getAttribute('data-nomor_rusun'); // Ambil data-nomor_rusun

                // Masukkan ID ke dalam input hidden
                const deleteIdInput = deleteModal.querySelector('#deleteId');
                deleteIdInput.value = id;

                // Perbarui teks konfirmasi dengan nomor rusun
                const confirmationText = deleteModal.querySelector('#deleteConfirmationText');
                confirmationText.textContent =
                    `Apakah Anda yakin ingin menghapus data rusun ${nomorRusun}?`;
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
