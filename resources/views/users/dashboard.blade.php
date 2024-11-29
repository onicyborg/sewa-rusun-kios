@extends('layouts.master')

@section('title')
    Dashboard - Admin
@endsection

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Dashboard</h3>
        </div>
    </div>
    <h6 class="op-7 mb-2">Informasi Penyewaan</h6>
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-building"></i> <!-- Ikon untuk Rusun -->
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Rusun Disewa</p>
                                @if ($rusun != null)
                                    <h4 class="card-title">
                                        {{ 'Tower ' . $rusun->rusun->tower . ' Lt.' . $rusun->rusun->lantai . ' No. ' . $rusun->rusun->nomor_rusun }}
                                    </h4>
                                @else
                                    <h4 class="card-title">-</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-store"></i> <!-- Ikon untuk Kios -->
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Kios Disewa</p>
                                @if ($kios != null)
                                    <h4 class="card-title">
                                        {{ $kios->kios->nama_kios }}
                                    </h4>
                                @else
                                    <h4 class="card-title">-</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-dollar-sign"></i> <!-- Ikon untuk Pendapatan -->
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Taihan Belum Dibayar</p>
                                <h4 class="card-title">Rp. {{ number_format($totalTunggakan) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Kalender Penyewaan Gedung</div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Keluhan Anda</div>
                        <div class="card-tools">
                            <a href="/keluhan" class="btn btn-info btn-sm"><i class="fas fa-rocket"></i>&nbsp; Cek
                                Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Rusun</th>
                                    <th scope="col" class="text-end">Keluhan</th>
                                    <th scope="col" class="text-end">Waktu</th>
                                    <th scope="col" class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($keluhans->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">Anda Belum Membuat Keluhan</td>
                                    </tr>
                                @else
                                    @foreach ($keluhans as $item)
                                        <tr>
                                            <th scope="row">
                                                {{ 'Tower ' . $item->sewaRusun->rusun->tower . ' Lt.' . $item->sewaRusun->rusun->lantai . ' No. ' . $item->sewaRusun->rusun->nomor_rusun }}
                                            </th>
                                            <td class="text-end">{{ $item->deskripsi }}</td>
                                            <td class="text-end">
                                                {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                            <td class="text-end">
                                                @if ($item->status == 'Pending')
                                                    <span class="badge badge-danger">Pending</span>
                                                @elseif ($item->status == 'Proses')
                                                    <span class="badge badge-warning">Proses</span>
                                                @else
                                                    <span class="badge badge-success">Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

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
    <style>
        .fc-button {
            background-color: #007bff !important;
            /* Warna biru untuk tombol */
            border: none !important;
            /* Hilangkan border */
            color: #fff !important;
            /* Warna teks putih */
            padding: 5px 10px;
            /* Sudut melengkung */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Bayangan */
        }

        .fc-button:hover {
            background-color: #0056b3 !important;
            /* Warna lebih gelap saat hover */
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            // Data kalender dari controller
            const calendarData = @json($calendar);

            // Inisialisasi FullCalendar
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Tampilan awal bulan
                locale: 'id', // Bahasa Indonesia
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
        });

        var ctx = document.getElementById('StatistikPenyewaan').getContext('2d');

        var statisticsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                datasets: [{
                    label: "Subscribers",
                    borderColor: '#f3545d',
                    pointBackgroundColor: 'rgba(243, 84, 93, 0.6)',
                    pointRadius: 0,
                    backgroundColor: 'rgba(243, 84, 93, 0.4)',
                    legendColor: '#f3545d',
                    fill: true,
                    borderWidth: 2,
                    data: [154, 184, 175, 203, 210, 231]
                }, {
                    label: "New Visitors",
                    borderColor: '#fdaf4b',
                    pointBackgroundColor: 'rgba(253, 175, 75, 0.6)',
                    pointRadius: 0,
                    backgroundColor: 'rgba(253, 175, 75, 0.4)',
                    legendColor: '#fdaf4b',
                    fill: true,
                    borderWidth: 2,
                    data: [256, 230, 245, 287, 240, 250]
                }, {
                    label: "Active Users",
                    borderColor: '#177dff',
                    pointBackgroundColor: 'rgba(23, 125, 255, 0.6)',
                    pointRadius: 0,
                    backgroundColor: 'rgba(23, 125, 255, 0.4)',
                    legendColor: '#177dff',
                    fill: true,
                    borderWidth: 2,
                    data: [542, 480, 430, 550, 530, 453]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    bodySpacing: 4,
                    mode: "nearest",
                    intersect: 0,
                    position: "nearest",
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                layout: {
                    padding: {
                        left: 5,
                        right: 5,
                        top: 15,
                        bottom: 15
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontStyle: "500",
                            beginAtZero: false,
                            maxTicksLimit: 5,
                            padding: 10
                        },
                        gridLines: {
                            drawTicks: false,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            zeroLineColor: "transparent"
                        },
                        ticks: {
                            padding: 10,
                            fontStyle: "500"
                        }
                    }]
                },
                legendCallback: function(chart) {
                    var text = [];
                    text.push('<ul class="' + chart.id + '-legend html-legend">');
                    for (var i = 0; i < chart.data.datasets.length; i++) {
                        text.push('<li><span style="background-color:' + chart.data.datasets[i].legendColor +
                            '"></span>');
                        if (chart.data.datasets[i].label) {
                            text.push(chart.data.datasets[i].label);
                        }
                        text.push('</li>');
                    }
                    text.push('</ul>');
                    return text.join('');
                }
            }
        });

        var myLegendContainer = document.getElementById("myChartLegend");

        // generate HTML legend
        myLegendContainer.innerHTML = statisticsChart.generateLegend();
    </script>
@endpush
