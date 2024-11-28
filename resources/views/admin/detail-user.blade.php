@extends('layouts.master')

@section('title')
    Detail User - Admin
@endsection

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Profile</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Informasi User</div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Profile Details -->
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <!-- Foto User -->
                            <div class="me-4">
                                <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('assets/img/default.png') }}"
                                    alt="User Photo" class="rounded-circle"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            </div>

                            <!-- Informasi Dasar -->
                            <div>
                                <h4 class="mb-1">{{ $user->name }}</h4>
                                <p class="mb-0 text-muted">{{ $user->email ?? 'Email tidak tersedia' }}</p>
                                <p class="mb-0 text-muted">Username: {{ $user->username }}</p>
                                <p class="mb-0 text-muted">Gender: {{ $user->gender ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="fw-bold">WhatsApp</h6>
                                    <p>{{ $user->whatsapp }}</p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold">NIK</h6>
                                    <p>{{ $user->nik ?? '-' }}</p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold">Tanggal Lahir</h6>
                                    <p>{{ $user->ttl ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="fw-bold">Pendidikan</h6>
                                    <p>{{ $user->pendidikan ?? '-' }}</p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold">Jenis Pekerjaan</h6>
                                    <p>{{ $user->jenis_pekerjaan ?? '-' }}</p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold">Penghasilan</h6>
                                    <p>{{ $user->penghasilan ? 'Rp ' . number_format($user->penghasilan, 0, ',', '.') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card History Penyewaan Rusun -->
    <div class="col-md-12 mt-4">
        <div class="card card-round">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">History Penyewaan Rusun</div>
                </div>
            </div>
            <div class="card-body">
                <table id="HistoryRusunTable" class="display table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Rusun</th>
                            <th>Tanggal Awal Sewa</th>
                            <th>Tanggal Akhir Sewa</th>
                            <th>Status Penyewaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sewa_rusun as $no => $sewa)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ 'Tower ' . $sewa->rusun->tower . ' Lt.' . $sewa->rusun->lantai . ' No. ' . $sewa->rusun->nomor_rusun }}</td>
                                <td>{{ \Carbon\Carbon::parse($sewa->tanggal_awal_sewa)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($sewa->tanggal_akhir_sewa)->format('d-m-Y') }}</td>
                                <td>
                                    @if ($sewa->status == 'active')
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Expired</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Card History Penyewaan Kios -->
    <div class="col-md-12 mt-4">
        <div class="card card-round">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">History Penyewaan Kios</div>
                </div>
            </div>
            <div class="card-body">
                <table id="HistoryKiosTable" class="display table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kios</th>
                            <th>Tanggal Awal Sewa</th>
                            <th>Tanggal Akhir Sewa</th>
                            <th>Status Penyewaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sewa_kios as $no => $sewa)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $sewa->kios->nama_kios }}</td>
                                <td>{{ \Carbon\Carbon::parse($sewa->tanggal_awal_sewa)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($sewa->tanggal_akhir_sewa)->format('d-m-Y') }}</td>
                                <td>
                                    @if ($sewa->status == 'active')
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Expired</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
            $('#HistoryRusunTable').DataTable();
            $('#HistoryKiosTable').DataTable();
        });
    </script>
@endpush
