@extends('layouts.master')

@section('title')
    Profile - Admin
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
                                <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('assets/img/default.png') }}"
                                    alt="User Photo" class="rounded-circle"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            </div>

                            <!-- Informasi Dasar -->
                            <div>
                                <h4 class="mb-1">{{ Auth::user()->name }}</h4>
                                <p class="mb-0 text-muted">{{ Auth::user()->email ?? 'Email tidak tersedia' }}</p>
                                <p class="mb-0 text-muted">Username: {{ Auth::user()->username }}</p>
                                <p class="mb-0 text-muted">Gender: {{ Auth::user()->gender ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="fw-bold">WhatsApp</h6>
                                    <p>{{ Auth::user()->whatsapp }}</p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold">NIK</h6>
                                    <p>{{ Auth::user()->nik ?? '-' }}</p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold">Tanggal Lahir</h6>
                                    <p>{{ Auth::user()->ttl ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="fw-bold">Pendidikan</h6>
                                    <p>{{ Auth::user()->pendidikan ?? '-' }}</p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold">Jenis Pekerjaan</h6>
                                    <p>{{ Auth::user()->jenis_pekerjaan ?? '-' }}</p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold">Penghasilan</h6>
                                    <p>{{ Auth::user()->penghasilan ? 'Rp ' . number_format(Auth::user()->penghasilan, 0, ',', '.') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateUserModal">
                                Update Profile
                            </button>
                            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                Change Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Profile Modal -->
    <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateUserModalLabel">Update Data User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <!-- Nama Lengkap -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', Auth::user()->name) }}">
                            </div>
                            <!-- Email Address -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', Auth::user()->email) }}">
                            </div>
                        </div>
                        <div class="row">
                            <!-- No WhatsApp -->
                            <div class="col-md-6 mb-3">
                                <label for="whatsapp" class="form-label">No WhatsApp <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                        value="{{ old('whatsapp', str_replace('+62', '', Auth::user()->whatsapp)) }}"
                                        pattern="[1-9][0-9]*" inputmode="numeric" placeholder="8123456789">
                                </div>
                            </div>
                            <!-- Username -->
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ old('username', Auth::user()->username) }}">
                            </div>
                        </div>
                        <div class="row">
                            <!-- NIK -->
                            <div class="col-md-6 mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik"
                                    value="{{ old('nik', Auth::user()->nik) }}">
                            </div>
                            <!-- Tanggal Lahir -->
                            <div class="col-md-6 mb-3">
                                <label for="ttl" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="ttl" name="ttl"
                                    value="{{ old('ttl', Auth::user()->ttl) }}">
                            </div>
                        </div>
                        <div class="row">
                            <!-- Pendidikan -->
                            <div class="col-md-6 mb-3">
                                <label for="pendidikan" class="form-label">Pendidikan</label>
                                <input type="text" class="form-control" id="pendidikan" name="pendidikan"
                                    value="{{ old('pendidikan', Auth::user()->pendidikan) }}">
                            </div>
                            <!-- Jenis Pekerjaan -->
                            <div class="col-md-6 mb-3">
                                <label for="jenis_pekerjaan" class="form-label">Jenis Pekerjaan</label>
                                <input type="text" class="form-control" id="jenis_pekerjaan" name="jenis_pekerjaan"
                                    value="{{ old('jenis_pekerjaan', Auth::user()->jenis_pekerjaan) }}">
                            </div>
                        </div>
                        <div class="row">
                            <!-- Penghasilan -->
                            <div class="col-md-6 mb-3">
                                <label for="penghasilan" class="form-label">Penghasilan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text" class="form-control" id="penghasilan" name="penghasilan"
                                        value="{{ old('penghasilan', Auth::user()->penghasilan) }}" pattern="[1-9][0-9]*"
                                        inputmode="numeric">
                                </div>
                            </div>
                            <!-- Gender -->
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="" selected>Pilih Gender</option>
                                    <option value="Pria"
                                        {{ old('gender', Auth::user()->gender) == 'Pria' ? 'selected' : '' }}>
                                        Pria</option>
                                    <option value="Wanita"
                                        {{ old('gender', Auth::user()->gender) == 'Wanita' ? 'selected' : '' }}>Wanita
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Foto -->
                            <div class="col-md-12 mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto"
                                    accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('profile.changePassword') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation"
                                name="new_password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script>
        document.getElementById('whatsapp').addEventListener('input', function(event) {
            // Menghapus semua karakter yang bukan angka
            this.value = this.value.replace(/[^0-9]/g, '');

            // Mencegah angka 0 di awal
            if (this.value.startsWith('0')) {
                this.value = this.value.slice(1); // Hapus karakter pertama jika 0
            }
        });
        document.getElementById('penghasilan').addEventListener('input', function(event) {
            // Menghapus semua karakter yang bukan angka
            this.value = this.value.replace(/[^0-9]/g, '');
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
