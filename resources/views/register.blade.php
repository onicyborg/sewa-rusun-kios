<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Page</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('asset/images/logos/seodashlogo.png') }}" />
    <link rel="stylesheet" href="{{ asset('asset/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" />
</head>

<body>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ asset('asset/images/logos/logo-light.svg') }}" alt="">
                                </a>
                                <p class="text-center">Your Social Campaigns</p>
                                <form method="POST" action="{{ route('register.process') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <!-- Nama Lengkap -->
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">
                                                Nama Lengkap <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name') }}">
                                        </div>
                                        <!-- Email Address -->
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">
                                                Email Address <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!-- No WhatsApp -->
                                        <div class="col-md-6 mb-3">
                                            <label for="whatsapp" class="form-label">
                                                No WhatsApp <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">+62</span>
                                                <input type="text" class="form-control" id="whatsapp"
                                                    name="whatsapp" value="{{ old('whatsapp') }}" pattern="[1-9][0-9]*"
                                                    inputmode="numeric" placeholder="8123456789">
                                            </div>
                                            <small class="form-text text-muted">Masukkan nomor tanpa 0 di awal. Contoh:
                                                8123456789</small>
                                        </div>
                                        <!-- Username -->
                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">
                                                Username <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                value="{{ old('username') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!-- NIK -->
                                        <div class="col-md-6 mb-3">
                                            <label for="nik" class="form-label">
                                                NIK <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="nik" name="nik"
                                                value="{{ old('nik') }}">
                                        </div>
                                        <!-- Tanggal Lahir -->
                                        <div class="col-md-6 mb-3">
                                            <label for="ttl" class="form-label">
                                                Tanggal Lahir <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" class="form-control" id="ttl" name="ttl"
                                                value="{{ old('ttl') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!-- Pendidikan -->
                                        <div class="col-md-6 mb-3">
                                            <label for="pendidikan" class="form-label">
                                                Pendidikan <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="pendidikan"
                                                name="pendidikan" value="{{ old('pendidikan') }}">
                                        </div>
                                        <!-- Jenis Pekerjaan -->
                                        <div class="col-md-6 mb-3">
                                            <label for="jenis_pekerjaan" class="form-label">
                                                Jenis Pekerjaan <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="jenis_pekerjaan"
                                                name="jenis_pekerjaan" value="{{ old('jenis_pekerjaan') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!-- Penghasilan -->
                                        <div class="col-md-6 mb-3">
                                            <label for="penghasilan" class="form-label">
                                                Penghasilan <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="text" class="form-control" id="penghasilan"
                                                    name="penghasilan" value="{{ old('penghasilan') }}"
                                                    pattern="[1-9][0-9]*" inputmode="numeric">
                                            </div>
                                        </div>
                                        <!-- Gender -->
                                        <div class="col-md-6 mb-3">
                                            <label for="gender" class="form-label">
                                                Gender <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control" id="gender" name="gender">
                                                <option value="" disabled selected>Pilih Gender</option>
                                                <option value="Pria"
                                                    {{ old('gender') == 'Pria' ? 'selected' : '' }}>Pria</option>
                                                <option value="Wanita"
                                                    {{ old('gender') == 'Wanita' ? 'selected' : '' }}>Wanita</option>
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
                                    <div class="row">
                                        <!-- Password -->
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">
                                                Password <span class="text-danger">*</span>
                                            </label>
                                            <input type="password" class="form-control" id="password"
                                                name="password">
                                        </div>
                                        <!-- Konfirmasi Password -->
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label">
                                                Konfirmasi Password <span class="text-danger">*</span>
                                            </label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <span class="text-danger">*</span> Wajib diisi
                                        </small>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4">Sign
                                        Up</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                                        <a class="text-primary fw-bold ms-2" href="/login">Sign In</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('asset/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script>
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

        document.getElementById('whatsapp').addEventListener('input', function(event) {
            // Menghapus semua karakter yang bukan angka
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        document.getElementById('penghasilan').addEventListener('input', function(event) {
            // Menghapus semua karakter yang bukan angka
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>

</html>
