@extends('layouts.master')

@section('title')
    Data Penghuni - Admin
@endsection

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Data Penghuni</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Data Penghuni Aktif</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="PenghuniAktifTable" class="display table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penyewa</th>
                                    <th>Email</th>
                                    <th>Whatsapp</th>
                                    <th>Rusun</th> <!-- Kolom untuk menampilkan rusun -->
                                    <th>Kios</th> <!-- Kolom untuk menampilkan kios -->
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penyewa</th>
                                    <th>Email</th>
                                    <th>Whatsapp</th>
                                    <th>Rusun</th>
                                    <th>Kios</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($penghuni_active as $no => $item)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->whatsapp }}</td>

                                        <!-- Menampilkan rusun yang sedang disewa -->
                                        <td>{{ $item->sewa_rusun->first()->rusun->name ?? 'Belum Sewa' }}</td>

                                        <!-- Menampilkan kios yang sedang disewa -->
                                        <td>{{ $item->sewa_kios->first()->kios->nama_kios ?? 'Belum Sewa' }}</td>

                                        <td class="text-center">
                                            <a href="{{ route('profile.show', $item->id) }}" class="btn btn-info btn-sm"><i class="fab fa-telegram-plane"></i>&nbsp; Detail</a>
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
                        <div class="card-title">Data Penghuni Non-Aktif</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="PenghuniNonAktifTable" class="display table table-striped table-hover"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penyewa</th>
                                    <th>Email</th>
                                    <th>Whatsapp</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penyewa</th>
                                    <th>Email</th>
                                    <th>Whatsapp</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($penghuni_non_active as $no => $item)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->whatsapp }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('profile.show', $item->id) }}" class="btn btn-info btn-sm"><i class="fab fa-telegram-plane"></i>&nbsp; Detail</a>
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
        document.addEventListener('DOMContentLoaded', function() {
            $('#PenghuniAktifTable').DataTable();
            $('#PenghuniNonAktifTable').DataTable();
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
