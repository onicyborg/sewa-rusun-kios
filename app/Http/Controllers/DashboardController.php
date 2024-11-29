<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use App\Models\Kios;
use App\Models\Rusun;
use App\Models\SewaGedung;
use App\Models\SewaKios;
use App\Models\SewaRusun;
use App\Models\TagihanKios;
use App\Models\TagihanRusun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $jumlahRusunTerisi = Rusun::whereHas('sewa_rusun', function ($query) {
                $query->where('status', 'active');
            })->count();

            $jumlahRusunKosong = Rusun::doesntHave('sewa_rusun') // Rusun yang tidak memiliki sewa
                ->orWhereDoesntHave('sewa_rusun', function ($query) {
                    $query->where('status', '!=', 'expired'); // Menghapus rusun yang masih aktif
                })
                ->count();

            $totalPembayaranRusunLunas = TagihanRusun::where('status_pembayaran', 'Dibayar')
                ->where('bulan', date('m')) // Bulan saat ini
                ->where('tahun', date('Y')) // Tahun saat ini
                ->select(DB::raw('SUM(sewa + air + denda) as total'))
                ->value('total');

            $totalPembayaranRusunTunggak = TagihanRusun::where('status_pembayaran', 'Belum Dibayar')
                ->where('bulan', date('m')) // Bulan saat ini
                ->where('tahun', date('Y')) // Tahun saat ini
                ->select(DB::raw('SUM(sewa + air + denda) as total'))
                ->value('total');

            $jumlahKiosTerisi = Kios::whereHas('sewa_kios', function ($query) {
                $query->where('status', 'active');
            })->count();

            $jumlahKiosKosong = Kios::doesntHave('sewa_kios') // Rusun yang tidak memiliki sewa
                ->orWhereDoesntHave('sewa_kios', function ($query) {
                    $query->where('status', '!=', 'expired'); // Menghapus rusun yang masih aktif
                })
                ->count();

            $totalPembayaranKiosLunas = TagihanKios::where('status_pembayaran', 'Dibayar')
                ->where('bulan', date('m')) // Bulan saat ini
                ->where('tahun', date('Y')) // Tahun saat ini
                ->select(DB::raw('SUM(sewa) as total'))
                ->value('total');

            $totalPembayaranKiosTunggak = TagihanKios::where('status_pembayaran', 'Belum Dibayar')
                ->where('bulan', date('m')) // Bulan saat ini
                ->where('tahun', date('Y')) // Tahun saat ini
                ->select(DB::raw('SUM(sewa) as total'))
                ->value('total');

            $calendar = SewaGedung::all();

            $keluhans = Keluhan::orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return view('admin.dashboard', [
                'jumlahRusunTerisi' => $jumlahRusunTerisi,
                'jumlahRusunKosong' => $jumlahRusunKosong,
                'totalPembayaranRusunLunas' => $totalPembayaranRusunLunas,
                'totalPembayaranRusunTunggak' => $totalPembayaranRusunTunggak,
                'jumlahKiosTerisi' => $jumlahKiosTerisi,
                'jumlahKiosKosong' => $jumlahKiosKosong,
                'totalPembayaranKiosLunas' => $totalPembayaranKiosLunas,
                'totalPembayaranKiosTunggak' => $totalPembayaranKiosTunggak,
                'calendar' => $calendar,
                'keluhans' => $keluhans
            ]);
        } else {
            $jumlahRusunTerisi = Rusun::whereHas('sewa_rusun', function ($query) {
                $query->where('status', 'active');
            })->count();

            $jumlahRusunKosong = Rusun::doesntHave('sewa_rusun') // Rusun yang tidak memiliki sewa
                ->orWhereDoesntHave('sewa_rusun', function ($query) {
                    $query->where('status', '!=', 'expired'); // Menghapus rusun yang masih aktif
                })
                ->count();

            $totalPembayaranRusunLunas = TagihanRusun::where('status_pembayaran', 'Dibayar')
                ->where('bulan', date('m')) // Bulan saat ini
                ->where('tahun', date('Y')) // Tahun saat ini
                ->select(DB::raw('SUM(sewa + air + denda) as total'))
                ->value('total');

            $totalPembayaranRusunTunggak = TagihanRusun::where('status_pembayaran', 'Belum Dibayar')
                ->where('bulan', date('m')) // Bulan saat ini
                ->where('tahun', date('Y')) // Tahun saat ini
                ->select(DB::raw('SUM(sewa + air + denda) as total'))
                ->value('total');

            $jumlahKiosTerisi = Kios::whereHas('sewa_kios', function ($query) {
                $query->where('status', 'active');
            })->count();

            $jumlahKiosKosong = Kios::doesntHave('sewa_kios') // Rusun yang tidak memiliki sewa
                ->orWhereDoesntHave('sewa_kios', function ($query) {
                    $query->where('status', '!=', 'expired'); // Menghapus rusun yang masih aktif
                })
                ->count();

            $totalPembayaranKiosLunas = TagihanKios::where('status_pembayaran', 'Dibayar')
                ->where('bulan', date('m')) // Bulan saat ini
                ->where('tahun', date('Y')) // Tahun saat ini
                ->select(DB::raw('SUM(sewa) as total'))
                ->value('total');

            $totalPembayaranKiosTunggak = TagihanKios::where('status_pembayaran', 'Belum Dibayar')
                ->where('bulan', date('m')) // Bulan saat ini
                ->where('tahun', date('Y')) // Tahun saat ini
                ->select(DB::raw('SUM(sewa) as total'))
                ->value('total');

            $calendar = SewaGedung::all();

            $keluhans = Keluhan::orderBy('created_at', 'desc')
                ->whereHas('sewaRusun', function ($query) {
                    $query->whereHas('penyewa', function ($subQuery) {
                        $subQuery->where('id', Auth::id()); // Filter berdasarkan user yang sedang login
                    });
                })
                ->limit(5)
                ->get();


            $rusun = SewaRusun::where('user_id', Auth::id())
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->first();

            $kios = SewaKios::where('user_id', Auth::id())
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->first();

            // Total Tunggakan Rusun
            $totalPembayaranRusunTunggak = TagihanRusun::where('status_pembayaran', 'Belum Dibayar')
                ->where('bulan', date('m')) // Bulan saat ini
                ->where('tahun', date('Y')) // Tahun saat ini
                ->whereHas('sewa_rusun', function ($query) {
                    $query->whereHas('penyewa', function ($subQuery) {
                        $subQuery->where('id', Auth::id()); // Filter berdasarkan user login
                    });
                })
                ->select(DB::raw('SUM(sewa + air + denda) as total'))
                ->value('total');

            // Total Tunggakan Kios
            $totalPembayaranKiosTunggak = TagihanKios::where('status_pembayaran', 'Belum Dibayar')
                ->where('bulan', date('m')) // Bulan saat ini
                ->where('tahun', date('Y')) // Tahun saat ini
                ->whereHas('sewa_kios', function ($query) {
                    $query->whereHas('penyewa', function ($subQuery) {
                        $subQuery->where('id', Auth::id()); // Filter berdasarkan user login
                    });
                })
                ->select(DB::raw('SUM(sewa) as total'))
                ->value('total');

            // Total Gabungan Tunggakan
            $totalTunggakan = $totalPembayaranRusunTunggak + $totalPembayaranKiosTunggak;


            return view('users.dashboard', [
                'jumlahRusunTerisi' => $jumlahRusunTerisi,
                'jumlahRusunKosong' => $jumlahRusunKosong,
                'totalPembayaranRusunLunas' => $totalPembayaranRusunLunas,
                'totalPembayaranRusunTunggak' => $totalPembayaranRusunTunggak,
                'jumlahKiosTerisi' => $jumlahKiosTerisi,
                'jumlahKiosKosong' => $jumlahKiosKosong,
                'totalPembayaranKiosLunas' => $totalPembayaranKiosLunas,
                'totalPembayaranKiosTunggak' => $totalPembayaranKiosTunggak,

                'keluhans' => $keluhans,
                'calendar' => $calendar,
                'rusun' => $rusun,
                'kios' => $kios,
                'totalTunggakan' => $totalTunggakan
            ]);
        }
    }
}
