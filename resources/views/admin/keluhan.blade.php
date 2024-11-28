@extends('layouts.master')

@section('title')
    Manage Keluhan Rusun - Admin
@endsection

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Kelola Keluhan Rusun</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Data Keluhan Rusun</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="KeluhanRusunTable" class="display table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penyewa</th>
                                    <th>Nomor Rusun</th>
                                    <th>Keluhan</th>
                                    <th>Mekanik</th>
                                    <th>Wa</th>
                                    <th>Dibuat</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penyewa</th>
                                    <th>Nomor Rusun</th>
                                    <th>Keluhan</th>
                                    <th>Mekanik</th>
                                    <th>Wa</th>
                                    <th>Dibuat</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($keluhans as $no => $item)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $item->sewaRusun->penyewa->name }}</td>
                                        <td>{{ 'Tower ' . $item->sewaRusun->rusun->tower . ' Lt.' . $item->sewaRusun->rusun->lantai . ' No. ' . $item->sewaRusun->rusun->nomor_rusun }}
                                        </td>

                                        <td>{{ $item->deskripsi }}</td>
                                        <td>{{ $item->mekanik->name ?? 'Belum Ditugaskan' }}</td>
                                        <td>{!! $item->mekanik ? "<a href='https://wa.me/".$item->mekanik->no_hp."' class='btn btn-info btn-sm' target='_blank'><i class='fab fa-whatsapp'></i></a>" : "-" !!}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                        <td class="text-center">
                                            @if ($item->status == 'Pending')
                                                <span class="badge badge-danger">Pending</span>
                                            @elseif ($item->status == 'Proses')
                                                <span class="badge badge-warning">Proses</span>
                                            @else
                                                <span class="badge badge-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- Button to trigger modal -->
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#assignMekanikModal" data-id="{{ $item->id }}"
                                                data-status="{{ $item->status }}" data-mekanik="{{ $item->mekanik_id }}">
                                                Assign Mekanik
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

    <div class="modal fade" id="assignMekanikModal" tabindex="-1" aria-labelledby="assignMekanikModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignMekanikModalLabel">Tugaskan Mekanik dan Update Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="assignMekanikForm" method="POST" action="{{ route('update-keluhan') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="keluhan_id" id="keluhan_id">
                        <div class="mb-3">
                            <label for="mekanik" class="form-label">Pilih Mekanik</label>
                            <select class="form-select" name="mekanik_id" id="mekanik" required style="width: 100%;">
                                <option selected disabled>Pilih Mekanik</option>
                                @foreach ($mekanikals as $mekanik)
                                    <option value="{{ $mekanik->id }}">{{ $mekanik->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status Keluhan</label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="Pending">Pending</option>
                                <option value="Proses">Proses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
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
        document.addEventListener('DOMContentLoaded', function() {
            $('#mekanik').select2({
                placeholder: 'Pilih Mekanik',
                allowClear: true,
                dropdownParent: $('#assignMekanikModal')
            });

            $('#KeluhanRusunTable').DataTable();
        });

        document.querySelectorAll('[data-bs-target="#assignMekanikModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const keluhanId = this.getAttribute('data-id');
                const mekanikId = this.getAttribute('data-mekanik');
                const status = this.getAttribute('data-status');

                // Set the keluhan_id in the form
                document.getElementById('keluhan_id').value = keluhanId;

                // Set the selected mekanik
                document.getElementById('mekanik').value = mekanikId;

                // Set the status select value
                document.getElementById('status').value = status;
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
