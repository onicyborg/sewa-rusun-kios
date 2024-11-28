<?php

namespace App\Http\Controllers;

use App\Models\SewaRusun;
use App\Models\TagihanRusun;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagihanRusunController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Ambil data tagihan_rusun dengan filter bulan dan tahun
        $query = TagihanRusun::query();

        if ($bulan) {
            $query->where('bulan', $bulan);
        }

        if ($tahun) {
            $query->where('tahun', $tahun);
        }

        // Mengelompokkan berdasarkan bulan dan tahun
        $tagihanRusuns = $query->selectRaw('
            bulan,
            tahun,
            MAX(status_post) AS status,  -- Ambil status yang ada (apakah Draft atau Release)
            COUNT(CASE WHEN status_pembayaran = "Dibayar" THEN 1 END) AS tagihan_dibayar,
            COUNT(CASE WHEN status_pembayaran = "Belum Dibayar" THEN 1 END) AS tagihan_belum_dibayar
        ')
        ->groupBy('bulan', 'tahun')
        ->orderByRaw('tahun DESC, bulan DESC')  // Urutkan berdasarkan tahun dan bulan secara menurun
        ->get();

        return datatables()->of($tagihanRusuns)
            ->addIndexColumn()
            ->make(true);
    }

    public function tagihan_bulanan(Request $request)
    {
        // Validasi input bulanTahun dalam format YYYY-MM
        $request->validate([
            'bulanTahun' => 'required|date_format:Y-m', // Validasi untuk format YYYY-MM
        ]);

        $namaBulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];


        // Ambil bulan dan tahun dari input bulanTahun
        $bulanTahun = $request->bulanTahun;
        [$tahun, $bulan] = explode('-', $bulanTahun); // Pisahkan tahun dan bulan

        $firstDayOfMonth = Carbon::createFromDate($tahun, $bulan, 1);
        $lastDayOfMonth = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();
        // Cari semua data sewa_rusun yang kontraknya masih berlaku (tanggal_selesai_kontrak >= bulan dan tahun yang diberikan)
        $sewaRusuns = SewaRusun::where('tanggal_selesai_kontrak', '>=', $lastDayOfMonth)
            ->where('tanggal_mulai_kontrak', '<=', $firstDayOfMonth)
            ->whereDoesntHave('tagihan', function ($query) use ($bulan, $tahun) {
                // Pastikan tidak ada tagihan pada bulan dan tahun yang diminta
                $query->where('bulan', $bulan)
                    ->where('tahun', $tahun);
            })
            ->get();

        // dd($sewaRusuns);
        // Jika tidak ada data sewa_rusun yang memenuhi kondisi, return response error atau notifikasi
        if ($sewaRusuns->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada kontrak yang aktif untuk bulan ' . $namaBulan[$bulan] . ' dan tahun ' . $tahun . '.');
        }

        // Proses perulangan pada data sewa_rusun
        foreach ($sewaRusuns as $sewaRusun) {
            // Data tagihan untuk bulan dan tahun yang dipilih
            $tagihan = new TagihanRusun();
            $tagihan->bulan = $bulan; // Set bulan
            $tagihan->tahun = $tahun; // Set tahun
            $tagihan->sewa = $sewaRusun->rusun->harga_sewa; // Ambil harga sewa dari data rusun terkait
            $tagihan->denda = 0; // Jika denda kosong, bisa diubah sesuai kebutuhan
            $tagihan->air = 0; // Jika biaya air kosong, bisa diubah sesuai kebutuhan
            $tagihan->status_post = 'Draft'; // Status default, bisa diubah
            $tagihan->status_pembayaran = 'Belum Dibayar'; // Status pembayaran default
            $tagihan->sewa_rusun_id = $sewaRusun->id; // Set id sewa_rusun yang sesuai
            $tagihan->save(); // Simpan data tagihan

            // Anda dapat menambahkan logika untuk menghitung denda dan biaya air, jika diperlukan
        }

        // Redirect dengan pesan sukses setelah berhasil menyimpan tagihan
        return redirect()->back()->with('success', 'Tagihan bulanan untuk bulan ' . $namaBulan[$bulan] . ' berhasil ditambahkan.');
    }

    public function detail_tagihan($bulan, $tahun)
    {
        $tagihans = TagihanRusun::where('bulan', $bulan)->where('tahun', $tahun)->get();

        $status = $tagihans->first()->status_post;

        return view('admin.detail-tagihan', ['tagihans' => $tagihans, 'bulan' => $bulan, 'tahun' => $tahun, 'status' => $status]);
    }

    public function update_tagihan(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'sewa' => 'required|numeric|min:0',
            'denda' => 'required|numeric|min:0',
            'air' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:Dibayar,Belum Dibayar',
        ]);

        // Ambil data tagihan berdasarkan ID
        $tagihan = TagihanRusun::findOrFail($id);

        // Update data tagihan
        $tagihan->sewa = $request->input('sewa');
        $tagihan->denda = $request->input('denda');
        $tagihan->air = $request->input('air');
        $tagihan->status_pembayaran = $request->input('status_pembayaran');

        // Simpan perubahan
        $tagihan->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Tagihan berhasil diperbarui.');
    }

    public function release_tagihan($bulan, $tahun)
    {
        $tagihans = TagihanRusun::where('bulan', $bulan)->where('tahun', $tahun)->get();

        foreach ($tagihans as $tagihan) {
            $tagihan->status_post = 'Release';
            $tagihan->save();
        }

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return redirect()->back()->with('success', 'Seluruh Tagihan Pada Bulan ' . $namaBulan[$bulan] . ' ' . $tahun . ' Berhasil di Release');
    }
}
