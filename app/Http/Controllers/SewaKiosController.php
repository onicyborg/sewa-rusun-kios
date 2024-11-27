<?php

namespace App\Http\Controllers;

use App\Models\Kios;
use App\Models\SewaKios;
use App\Models\TagihanKios;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SewaKiosController extends Controller
{
    public function index()
    {
        $sewas = SewaKios::all();
        $users = User::where('role', 'user')
            ->whereDoesntHave('sewa_kios')
            ->orWhereHas('sewa_kios', function ($query) {
                $query->where('status', 'expired');
            })
            ->get();

        $kioss = Kios::doesntHave('sewa_kios')
            ->orWhereHas('sewa_kios', function ($query) {
                $query->where('status', 'expired');
            })
            ->get();


        return view('admin.sewa-kios', ['sewas' => $sewas, 'users' => $users, 'kioss' => $kioss]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'penyewa' => 'required|exists:users,id',
            'kios' => 'required|exists:kios,id',
            'tanggal_mulai' => 'required|date_format:Y-m',
            'tanggal_selesai' => 'required|date_format:Y-m',
        ]);

        // Ambil bulan dan tahun dari input tanggal_mulai
        [$year_mulai, $month_mulai] = explode('-', $request->tanggal_mulai);

        // Tanggal mulai diatur menjadi hari pertama pada bulan dan tahun yang dipilih
        $tanggalMulai = Carbon::createFromDate($year_mulai, $month_mulai, 1);

        // Ambil bulan dan tahun dari input tanggal_selesai
        [$year_selesai, $month_selesai] = explode('-', $request->tanggal_selesai);

        // Tanggal selesai diatur menjadi hari terakhir pada bulan dan tahun yang dipilih
        $tanggalSelesai = Carbon::createFromDate($year_selesai, $month_selesai, 1)->endOfMonth();

        $sewa_kios = new SewaKios();
        $sewa_kios->user_id = $request->penyewa;
        $sewa_kios->kios_id = $request->kios;
        $sewa_kios->tanggal_mulai_kontrak = $tanggalMulai;
        $sewa_kios->tanggal_selesai_kontrak = $tanggalSelesai;
        $sewa_kios->save();

        $currentDate = Carbon::now();
        if ($currentDate->between($tanggalMulai, $tanggalSelesai)) {
            // Cek apakah tagihan untuk bulan dan tahun saat ini sudah ada
            $existingTagihan = TagihanKios::where('bulan', $currentDate->month)
                ->where('tahun', $currentDate->year)
                ->exists();
            // Jika tagihan belum ada, lakukan penyimpanan tagihan baru
            if ($existingTagihan) {
                // Lakukan penyimpanan tagihan
                $tagihan = new TagihanKios();
                $tagihan->bulan = $currentDate->month; // Set bulan
                $tagihan->tahun = $currentDate->year; // Set tahun
                $tagihan->sewa = $sewa_kios->kios->harga_sewa; // Ambil harga sewa dari data kios terkait
                $tagihan->status_post = 'Draft'; // Status default, bisa diubah
                $tagihan->status_pembayaran = 'Belum Dibayar'; // Status pembayaran default
                $tagihan->sewa_kios_id = $sewa_kios->id; // Set id sewa_kios yang sesuai
                $tagihan->save(); // Simpan data tagihan
            }
        }

        return redirect()->back()->with('success', 'Data Penyewaan Berhasil Disimpan');
    }
}
