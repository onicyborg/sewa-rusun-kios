<?php

namespace App\Http\Controllers;

use App\Models\Rusun;
use App\Models\SewaRusun;
use App\Models\TagihanRusun;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SewaRusunController extends Controller
{
    public function index()
    {
        $sewas = SewaRusun::all();
        $users = User::where('role', 'user')
            ->whereDoesntHave('sewa_rusun')
            ->orWhereHas('sewa_rusun', function ($query) {
                $query->where('status', 'expired');
            })
            ->get();

        $rusuns = Rusun::doesntHave('sewa_rusun')
            ->orWhereHas('sewa_rusun', function ($query) {
                $query->where('status', 'expired');
            })
            ->get();


        return view('admin.sewa-rusun', ['sewas' => $sewas, 'users' => $users, 'rusuns' => $rusuns]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'penyewa' => 'required|exists:users,id',
            'rusun' => 'required|exists:rusuns,id',
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

        $sewa_rusun = new SewaRusun();
        $sewa_rusun->user_id = $request->penyewa;
        $sewa_rusun->rusun_id = $request->rusun;
        $sewa_rusun->tanggal_mulai_kontrak = $tanggalMulai;
        $sewa_rusun->tanggal_selesai_kontrak = $tanggalSelesai;
        $sewa_rusun->save();

        $currentDate = Carbon::now();
        if ($currentDate->between($tanggalMulai, $tanggalSelesai)) {
            // Cek apakah tagihan untuk bulan dan tahun saat ini sudah ada
            $existingTagihan = TagihanRusun::where('bulan', $currentDate->month)
                ->where('tahun', $currentDate->year)
                ->exists();
            // Jika tagihan belum ada, lakukan penyimpanan tagihan baru
            if ($existingTagihan) {
                // Lakukan penyimpanan tagihan
                $tagihan = new TagihanRusun();
                $tagihan->bulan = $currentDate->month; // Set bulan
                $tagihan->tahun = $currentDate->year; // Set tahun
                $tagihan->sewa = $sewa_rusun->rusun->harga_sewa; // Ambil harga sewa dari data rusun terkait
                $tagihan->denda = 0; // Jika denda kosong, bisa diubah sesuai kebutuhan
                $tagihan->air = 0; // Jika biaya air kosong, bisa diubah sesuai kebutuhan
                $tagihan->status_post = 'Draft'; // Status default, bisa diubah
                $tagihan->status_pembayaran = 'Belum Dibayar'; // Status pembayaran default
                $tagihan->sewa_rusun_id = $sewa_rusun->id; // Set id sewa_rusun yang sesuai
                $tagihan->save(); // Simpan data tagihan
            }
        }

        return redirect()->back()->with('success', 'Data Penyewaan Berhasil Disimpan');
    }



    public function update() {}

    public function delete() {}
}
