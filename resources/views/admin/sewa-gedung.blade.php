@extends('layouts.master')

@section('title')
    Penyewaan Gedung - Admin
@endsection

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">List Penyewaan Gedung</h3>
        </div>
    </div>
    <div class="row">
        <!-- Card untuk Tabel -->
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Data Penyewaan Gedung</div>
                        <div class="card-tools">
                            <button class="btn btn-primary btn-sm float-right" data-bs-toggle="modal"
                                data-bs-target="#addPenyewaanGedung">
                                <i class="fa fa-plus"></i> Tambah Penyewaan Gedung
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="PenyewaanGedung" class="display table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penyewa</th>
                                    <th>Tanggal Penyewaan</th>
                                    <th>Durasi Sewa</th>
                                    <th>Keperluan</th>
                                    <th>Status Pembayaran</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_future as $index => $penyewaan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $penyewaan->nama_penyewa }}</td>
                                        <td>{{ $penyewaan->tanggal_sewa }}</td>
                                        <td>{{ $penyewaan->durasi_sewa }} Hari</td>
                                        <td>{{ $penyewaan->keperluan }}</td>
                                        <td>{{ $penyewaan->status_pembayaran }}</td>
                                        <td class="text-center">
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editPenyewaanModal" data-id="{{ $penyewaan->id }}"
                                                data-nama="{{ $penyewaan->nama_penyewa }}"
                                                data-kontak="{{ $penyewaan->kontak_penyewa }}"
                                                data-tanggal="{{ $penyewaan->tanggal_sewa }}"
                                                data-akhir="{{ $penyewaan->tanggal_akhir_sewa }}"
                                                data-durasi="{{ $penyewaan->durasi_sewa }}"
                                                data-keperluan="{{ $penyewaan->keperluan }}"
                                                data-status="{{ $penyewaan->status_pembayaran }}">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <!-- Tombol Delete -->
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deletePenyewaanModal" data-id="{{ $penyewaan->id }}">
                                                <i class="fa fa-trash"></i>
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
        <!-- Card untuk Kalender -->
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Kalender Penyewaan Gedung</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Kalender -->
                        <div class="col-md-8">
                            <div id="calendar"></div>
                        </div>

                        <!-- Kegiatan yang akan datang -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <h5 class="fw-bold text-primary text-center">Kegiatan yang akan datang</h5>
                            </div>
                            <div class="card-body" id="todo-list">
                                <!-- Daftar tugas akan diisi secara dinamis -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Riwayat Penyewaan Gedung</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="HistoryPenyewaanGedung" class="display table table-striped table-hover"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penyewa</th>
                                    <th>Tanggal Penyewaan</th>
                                    <th>Durasi Sewa</th>
                                    <th>Keperluan</th>
                                    <th>Status Pembayaran</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_past as $index => $penyewaan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $penyewaan->nama_penyewa }}</td>
                                        <td>{{ $penyewaan->tanggal_sewa }}</td>
                                        <td>{{ $penyewaan->durasi_sewa }} Hari</td>
                                        <td>{{ $penyewaan->keperluan }}</td>
                                        <td>{{ $penyewaan->status_pembayaran }}</td>
                                        <td class="text-center">
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-sm btn-info" id="detailHistoryButton"
                                                data-id="{{ $penyewaan->id }}" data-nama="{{ $penyewaan->nama_penyewa }}"
                                                data-kontak="{{ $penyewaan->kontak_penyewa }}"
                                                data-tanggal="{{ $penyewaan->tanggal_sewa }}"
                                                data-akhir="{{ $penyewaan->tanggal_akhir_sewa }}"
                                                data-durasi="{{ $penyewaan->durasi_sewa }}"
                                                data-keperluan="{{ $penyewaan->keperluan }}"
                                                data-status="{{ $penyewaan->status_pembayaran }}">
                                                <i class="fa fa-info"></i>
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

    <div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDetailModalLabel">Detail Penyewaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Penyewa:</strong> <span id="modalNamaPenyewa"></span></p>
                    <p><strong>Kontak Penyewa:</strong> <span id="modalKontakPenyewa"></span></p>
                    <p><strong>Keperluan Sewa:</strong> <span id="modalKeperluanSewa"></span></p>
                    <p><strong>Tanggal Penyewaan:</strong> <span id="modalTanggalPenyewaan"></span></p>
                    <p><strong>Durasi Penyewaan:</strong> <span id="modalDurasiPenyewaan"></span></p>
                    <p><strong>Status Pembayaran:</strong> <span id="modalStatusPembayaran"></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Tambah Penyewaan Gedung -->
    <div class="modal fade" id="addPenyewaanGedung" tabindex="-1" aria-labelledby="addPenyewaanGedungLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPenyewaanGedungLabel">Tambah Penyewaan Gedung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('sewa-gedung.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_penyewa" class="form-label">Nama Penyewa</label>
                            <input type="text" class="form-control" id="nama_penyewa" name="nama_penyewa" required>
                        </div>
                        <div class="mb-3">
                            <label for="kontak_penyewa" class="form-label">Kontak Penyewa</label>
                            <input type="text" class="form-control" id="kontak_penyewa" name="kontak_penyewa">
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
                            <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_akhir_sewa" class="form-label">Tanggal Akhir Sewa</label>
                            <input type="date" class="form-control" id="tanggal_akhir_sewa"
                                name="tanggal_akhir_sewa">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="sewa_satu_hari" name="sewa_satu_hari">
                            <label class="form-check-label" for="sewa_satu_hari">Penyewaan 1 Hari</label>
                        </div>
                        <div class="mb-3">
                            <label for="durasi_sewa" class="form-label">Durasi Sewa (Hari)</label>
                            <input type="text" class="form-control" id="durasi_sewa" name="durasi_sewa" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <input type="text" class="form-control" id="keperluan" name="keperluan" required>
                        </div>
                        <div class="mb-3">
                            <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                            <select class="form-select" id="status_pembayaran" name="status_pembayaran">
                                <option value="Belum Dibayar">Belum Dibayar</option>
                                <option value="Sudah DP">Sudah DP</option>
                                <option value="Lunas">Lunas</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Penyewaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPenyewaanModal" tabindex="-1" aria-labelledby="editPenyewaanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPenyewaanModalLabel">Update Penyewaan Gedung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPenyewaanForm" method="POST" action="{{ route('sewa-gedung.update') }}">
                        @csrf
                        @method('PUT')
                        <!-- Hidden Input ID -->
                        <input type="hidden" name="id" id="edit-id">

                        <!-- Nama Penyewa -->
                        <div class="mb-3">
                            <label for="edit-nama" class="form-label">Nama Penyewa</label>
                            <input type="text" class="form-control" id="edit-nama" name="nama_penyewa" required>
                        </div>

                        <!-- Kontak Penyewa -->
                        <div class="mb-3">
                            <label for="edit-kontak" class="form-label">Kontak Penyewa</label>
                            <input type="text" class="form-control" id="edit-kontak" name="kontak_penyewa" required>
                        </div>

                        <!-- Tanggal Penyewaan -->
                        <div class="mb-3">
                            <label for="edit-tanggal-sewa" class="form-label">Tanggal Mulai Sewa</label>
                            <input type="date" class="form-control" id="edit-tanggal-sewa" name="tanggal_sewa"
                                required>
                        </div>

                        <!-- Tanggal Akhir Sewa -->
                        <div class="mb-3">
                            <label for="edit-tanggal-akhir-sewa" class="form-label">Tanggal Akhir Sewa</label>
                            <input type="date" class="form-control" id="edit-tanggal-akhir-sewa"
                                name="tanggal_akhir_sewa">
                        </div>

                        <!-- Durasi Sewa -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="edit-durasi-otomatis"
                                name="durasi_otomatis">
                            <label class="form-check-label" for="edit-durasi-otomatis">
                                Durasi 1 Hari (tanpa tanggal akhir)
                            </label>
                        </div>

                        <!-- Keperluan -->
                        <div class="mb-3">
                            <label for="edit-keperluan" class="form-label">Keperluan</label>
                            <input type="text" class="form-control" id="edit-keperluan" name="keperluan" required>
                        </div>

                        <!-- Status Pembayaran -->
                        <div class="mb-3">
                            <label for="edit-status" class="form-label">Status Pembayaran</label>
                            <select class="form-select" id="edit-status" name="status_pembayaran" required>
                                <option value="Lunas">Lunas</option>
                                <option value="Sudah DP">Sudah DP</option>
                                <option value="Belum Dibayar">Belum Dibayar</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletePenyewaanModal" tabindex="-1" aria-labelledby="deletePenyewaanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePenyewaanModalLabel">Hapus Penyewaan Gedung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus penyewaan ini?
                    <form id="deletePenyewaanForm" method="POST" action="{{ route('sewa-gedung.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" id="delete-id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="deletePenyewaanForm" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />

    <style>
        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }

        .fc-toolbar {
            background-color: #1a2035;
            /* Warna latar belakang toolbar */
            border-radius: 5px;
            /* Tambahkan sudut melengkung */
            padding: 5px;
            /* Ruang di sekitar tombol */
        }

        .fc-button {
            background-color: #007bff !important;
            /* Warna biru untuk tombol */
            border: none !important;
            /* Hilangkan border */
            color: #fff !important;
            /* Warna teks putih */
            padding: 5px 10px;
            /* Ukuran tombol */
            border-radius: 4px !important;
            /* Sudut melengkung */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Bayangan */
        }

        .fc-button:hover {
            background-color: #0056b3 !important;
            /* Warna lebih gelap saat hover */
        }

        .fc-button-group>.fc-button {
            margin-right: 5px;
            /* Jarak antar tombol */
        }

        .fc-toolbar-title {
            font-size: 1.2rem;
            /* Perbesar ukuran judul */
            font-weight: bold;
            color: #ffffff;
            /* Warna teks judul */
        }

        .fc-daygrid-event {
            font-size: 0.9rem;
            /* Ukuran teks event */
            padding: 2px 4px;
            /* Ruang dalam event */
        }

        #todo-list .border {
            border-color: #dee2e6 !important;
            background-color: #f8f9fa;
        }

        #todo-list .btn-view-details {
            width: 100%;
            margin-top: 10px;
        }

        #todo-list h6 {
            color: #007bff;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#PenyewaanGedung').DataTable();
            $('#HistoryPenyewaanGedung').DataTable();
            // Ambil elemen kalender
            const calendarEl = document.getElementById('calendar');

            // Data kalender dari controller
            const calendarData = @json($calendar);

            // Inisialisasi FullCalendar
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Tampilan awal bulan
                locale: 'id', // Bahasa Indonesia
                headerToolbar: {
                    start: 'prev,next today', // Tombol navigasi
                    center: 'title', // Judul di tengah
                    end: 'dayGridMonth,timeGridWeek' // Tombol untuk mengubah tampilan
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                },
                events: calendarData.map(event => ({
                    title: event.keperluan + ' (' + event.nama_penyewa + ')',
                    start: event.tanggal_sewa,
                    end: event.tanggal_akhir_sewa ? event.tanggal_akhir_sewa : event
                        .tanggal_sewa, // Jika tanggal akhir tidak ada, gunakan tanggal sewa
                    backgroundColor: '#007bff', // Warna biru untuk bar
                    textColor: '#ffffff', // Warna teks putih
                    extendedProps: {
                        penyewa: event.nama_penyewa,
                        kontak: event.kontak_penyewa,
                        keperluan: event.keperluan,
                        tanggal: event.tanggal_sewa + (event.tanggal_akhir_sewa ? ' - ' + event
                            .tanggal_akhir_sewa : ''),
                        durasi: event.tanggal_akhir_sewa ?
                            Math.ceil(
                                (new Date(event.tanggal_akhir_sewa) - new Date(event
                                    .tanggal_sewa)) / (1000 * 60 * 60 * 24) + 1
                            ) + ' Hari' : '1 Hari',
                        statusPembayaran: event.status_pembayaran
                    }
                })),
                eventClick: function(info) {
                    Swal.fire({
                        title: `<strong>Detail Penyewaan</strong>`,
                        html: `
                <p><strong>Nama Penyewa:</strong> ${info.event.extendedProps.penyewa}</p>
                <p><strong>Kontak Penyewa:</strong> ${info.event.extendedProps.kontak}</p>
                <p><strong>Keperluan Sewa:</strong> ${info.event.extendedProps.keperluan}</p>
                <p><strong>Tanggal Penyewaan:</strong> ${info.event.extendedProps.tanggal}</p>
                <p><strong>Durasi Penyewaan:</strong> ${info.event.extendedProps.durasi}</p>
                <p><strong>Status Pembayaran:</strong> ${info.event.extendedProps.statusPembayaran}</p>
            `,
                        icon: 'info',
                        confirmButtonText: 'Tutup'
                    });
                }
            });

            // Render kalender
            calendar.render();

            // Ambil data todo dari controller (data ini diubah sesuai dengan data yang dikirim dari controller)
            // Ambil data yang dikirim dari controller
            const events = @json($todo);

            // Filter event yang akan datang
            const upcomingEvents = events.filter(event => new Date(event.tanggal_sewa) > new Date());

            // Tampilkan To-Do List
            const todoListEl = document.getElementById('todo-list');
            upcomingEvents.forEach(event => {
                const eventEl = document.createElement('div');
                eventEl.className = 'mb-3 p-3 border rounded';
                eventEl.innerHTML = `
        <h6 class="fw-bold">${event.nama_penyewa}</h6>
        <p><strong>Tanggal:</strong> ${event.tanggal_sewa}</p>
        <p><strong>Keperluan:</strong> ${event.keperluan}</p>
        <button class="btn btn-sm btn-primary btn-view-details" data-event='${JSON.stringify(event)}'>
            Lihat Detail
        </button>
    `;
                todoListEl.appendChild(eventEl);
            });

            // Event listener untuk tombol "Lihat Detail"
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-view-details')) {
                    const event = JSON.parse(e.target.getAttribute('data-event'));
                    Swal.fire({
                        title: `<strong>${event.nama_penyewa}</strong>`,
                        html: `
                <p><strong>Nama Penyewa:</strong> ${event.nama_penyewa}</p>
                <p><strong>Kontak Penyewa:</strong> ${event.kontak_penyewa || 'Tidak ada kontak'}</p>
                <p><strong>Keperluan Sewa:</strong> ${event.keperluan}</p>
                <p><strong>Tanggal Penyewaan:</strong> ${event.tanggal_sewa} - ${event.tanggal_akhir_sewa || 'Selesai di hari yang sama'}</p>
                <p><strong>Durasi Penyewaan:</strong> ${event.durasi_sewa} Hari</p>
                <p><strong>Status Pembayaran:</strong> ${event.status_pembayaran}</p>
            `,
                        icon: 'info',
                        confirmButtonText: 'Tutup'
                    });
                }
            });



            const tanggalSewaInput = document.getElementById('tanggal_sewa');
            const tanggalAkhirSewaInput = document.getElementById('tanggal_akhir_sewa');
            const durasiSewaInput = document.getElementById('durasi_sewa');
            const sewaSatuHariToggle = document.getElementById('sewa_satu_hari');

            // Fungsi untuk menghitung durasi sewa
            function hitungDurasi() {
                const tanggalSewa = new Date(tanggalSewaInput.value);
                const tanggalAkhirSewa = new Date(tanggalAkhirSewaInput.value);
                if (tanggalSewa && tanggalAkhirSewa) {
                    const diffTime = tanggalAkhirSewa - tanggalSewa;
                    const diffDays = diffTime / (1000 * 3600 * 24);
                    if (diffDays < 0) {
                        durasiSewaInput.value = "Tanggal akhir sewa tidak valid.";
                    } else {
                        durasiSewaInput.value = diffDays + 1; // Menambahkan 1 hari
                    }
                }
            }

            // Event listener untuk toggle penyewaan 1 hari
            sewaSatuHariToggle.addEventListener('change', function() {
                if (sewaSatuHariToggle.checked) {
                    tanggalAkhirSewaInput.disabled = true;
                    tanggalAkhirSewaInput.value = tanggalSewaInput
                        .value; // Menyelaraskan tanggal akhir sewa dengan tanggal sewa
                    durasiSewaInput.value = 1; // Durasi 1 hari
                } else {
                    tanggalAkhirSewaInput.disabled = false;
                    hitungDurasi(); // Hitung ulang durasi jika toggle dimatikan
                }
            });

            // Event listener untuk tanggal sewa dan tanggal akhir sewa
            tanggalSewaInput.addEventListener('change', hitungDurasi);
            tanggalAkhirSewaInput.addEventListener('change', hitungDurasi);


            // Populate Edit Modal with data
            $('#editPenyewaanModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');
                const nama = button.data('nama');
                const kontak = button.data('kontak');
                const tanggalSewa = button.data('tanggal');
                const tanggalAkhir = button.data('akhir');
                const keperluan = button.data('keperluan');
                const status = button.data('status');

                // Populate form fields
                $('#edit-id').val(id);
                $('#edit-nama').val(nama);
                $('#edit-kontak').val(kontak);
                $('#edit-tanggal-sewa').val(tanggalSewa);
                $('#edit-tanggal-akhir-sewa').val(tanggalAkhir);
                $('#edit-keperluan').val(keperluan);
                $('#edit-status').val(status);

                // Check if tanggal akhir is empty
                if (!tanggalAkhir) {
                    $('#edit-durasi-otomatis').prop('checked', true);
                    $('#edit-tanggal-akhir-sewa').prop('disabled', true);
                } else {
                    $('#edit-durasi-otomatis').prop('checked', false);
                    $('#edit-tanggal-akhir-sewa').prop('disabled', false);
                }
            });

            $('#deletePenyewaanModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const id = button.data('id');

                // Update modal form field
                $('#delete-id').val(id);
            });

            // Toggle tanggal akhir input
            $('#edit-durasi-otomatis').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#edit-tanggal-akhir-sewa').val('').prop('disabled', true);
                } else {
                    $('#edit-tanggal-akhir-sewa').prop('disabled', false);
                }
            });

            document.getElementById('detailHistoryButton').addEventListener('click', function() {
                // Ambil data dari button menggunakan atribut data
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                const kontak = this.getAttribute('data-kontak');
                const tanggal = this.getAttribute('data-tanggal');
                const akhir = this.getAttribute('data-akhir');
                const durasi = this.getAttribute('data-durasi');
                const keperluan = this.getAttribute('data-keperluan');
                const status = this.getAttribute('data-status');

                // Tampilkan SweetAlert dengan detail pemesanan
                Swal.fire({
                    title: `Detail History Penyewaan #${id}`,
                    html: `
                <strong>Nama Penyewa:</strong> ${nama} <br>
                <strong>Kontak:</strong> ${kontak} <br>
                <strong>Tanggal Sewa:</strong> ${tanggal} <br>
                <strong>Tanggal Akhir Sewa:</strong> ${akhir} <br>
                <strong>Durasi Sewa:</strong> ${durasi} hari <br>
                <strong>Keperluan:</strong> ${keperluan} <br>
                <strong>Status Pembayaran:</strong> ${status}
            `,
                    icon: 'info',
                    confirmButtonText: 'Tutup'
                });
            });



            // SweetAlert Notifikasi
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
        });
    </script>
@endpush
