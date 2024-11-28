<?php

namespace App\Http\Controllers;

use App\Models\SewaGedung;
use Illuminate\Http\Request;

class SewaGedungController extends Controller
{
    public function index()
    {
        // Tanggal hari ini
        $today = now();

        // Data penyewaan yang akan datang, diurutkan berdasarkan tanggal sewa terdekat
        $data_future = SewaGedung::where('tanggal_sewa', '>=', $today)
            ->orderBy('tanggal_sewa', 'asc')
            ->get();

        // Data penyewaan yang sudah lewat, diurutkan berdasarkan tanggal sewa terbaru
        $data_past = SewaGedung::where('tanggal_sewa', '<', $today)
            ->orderBy('tanggal_sewa', 'asc')
            ->get();

        // Data untuk kalender (menampilkan semua penyewaan)
        $calendar = SewaGedung::all();

        // Data untuk to-do list (3 penyewaan yang akan datang)
        $todo = SewaGedung::where('tanggal_sewa', '>=', $today)
            ->orderBy('tanggal_sewa', 'asc')
            ->take(3)
            ->get();
        // dd($todo);

        return view('admin.sewa-gedung', compact('data_future', 'data_past', 'calendar', 'todo'));
    }


    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama_penyewa' => 'required|string|max:255',
            'kontak_penyewa' => 'nullable|string|max:255',
            'tanggal_sewa' => 'required|date',
            'tanggal_akhir_sewa' => 'nullable|date|after_or_equal:tanggal_sewa',
            'keperluan' => 'required|string|max:255',
            'status_pembayaran' => 'required|in:Belum Dibayar,Sudah DP,Lunas',
        ]);

        // Ambil data dari input
        $tanggalSewa = $request->tanggal_sewa;
        $tanggalAkhirSewa = $request->tanggal_akhir_sewa ?? $tanggalSewa;

        // Cek apakah durasi bertabrakan dengan jadwal yang ada
        $conflictingBookings = SewaGedung::where(function ($query) use ($tanggalSewa, $tanggalAkhirSewa) {
            $query->whereBetween('tanggal_sewa', [$tanggalSewa, $tanggalAkhirSewa])
                ->orWhereBetween('tanggal_akhir_sewa', [$tanggalSewa, $tanggalAkhirSewa])
                ->orWhere(function ($subQuery) use ($tanggalSewa, $tanggalAkhirSewa) {
                    $subQuery->where('tanggal_sewa', '<=', $tanggalSewa)
                        ->where('tanggal_akhir_sewa', '>=', $tanggalAkhirSewa);
                });
        })->where('tanggal_sewa', '>=', now()->toDateString())
            ->exists();

        if ($conflictingBookings) {
            return back()->withErrors([
                'error' => 'Tanggal yang Anda pilih bertabrakan dengan jadwal penyewaan yang sudah ada. Mohon periksa kalender dan pilih tanggal yang tersedia.'
            ]);
        }

        // Simpan data baru
        SewaGedung::create([
            'nama_penyewa' => $request->nama_penyewa,
            'kontak_penyewa' => $request->kontak_penyewa,
            'tanggal_sewa' => $tanggalSewa,
            'tanggal_akhir_sewa' => $request->tanggal_akhir_sewa ?? null,
            'durasi_sewa' => (new \DateTime($tanggalAkhirSewa))->diff(new \DateTime($tanggalSewa))->days + 1,
            'keperluan' => $request->keperluan,
            'status_pembayaran' => $request->status_pembayaran,
        ]);

        return redirect()->back()->with('success', 'Penyewaan gedung berhasil disimpan.');
    }

    public function update(Request $request)
    {
        // Validasi data input
        $request->validate([
            'id' => 'required|exists:sewa_gedung,id', // Validasi ID penyewaan
            'nama_penyewa' => 'required|string|max:255',
            'kontak_penyewa' => 'nullable|string|max:255',
            'tanggal_sewa' => 'required|date',
            'tanggal_akhir_sewa' => 'nullable|date|after_or_equal:tanggal_sewa',
            'keperluan' => 'required|string|max:255',
            'status_pembayaran' => 'required|in:Belum Dibayar,Sudah DP,Lunas',
        ]);

        // Ambil data dari input
        $id = $request->id;
        $tanggalSewa = $request->tanggal_sewa;
        $tanggalAkhirSewa = $request->tanggal_akhir_sewa ?? $tanggalSewa;
        $durasiOtomatis = $request->has('durasi_otomatis');

        // Cek apakah durasi otomatis dipilih
        if ($durasiOtomatis) {
            // Set tanggal akhir sewa menjadi tanggal mulai sewa jika durasi otomatis dipilih
            $tanggalAkhirSewa = $tanggalSewa;
        }

        // Cek apakah durasi bertabrakan dengan jadwal yang ada
        $conflictingBookings = SewaGedung::where(function ($query) use ($tanggalSewa, $tanggalAkhirSewa, $id) {
            $query->whereBetween('tanggal_sewa', [$tanggalSewa, $tanggalAkhirSewa])
                ->orWhereBetween('tanggal_akhir_sewa', [$tanggalSewa, $tanggalAkhirSewa])
                ->orWhere(function ($subQuery) use ($tanggalSewa, $tanggalAkhirSewa) {
                    $subQuery->where('tanggal_sewa', '<=', $tanggalSewa)
                        ->where('tanggal_akhir_sewa', '>=', $tanggalAkhirSewa);
                });
        })
            ->where('tanggal_sewa', '>=', now()->toDateString())
            ->where('id', '!=', $id) // Jangan periksa penyewaan yang sedang diupdate
            ->exists();

        if ($conflictingBookings) {
            return back()->withErrors([
                'error' => 'Tanggal yang Anda pilih bertabrakan dengan jadwal penyewaan yang sudah ada. Mohon periksa kalender dan pilih tanggal yang tersedia.'
            ]);
        }

        // Cari data penyewaan berdasarkan ID
        $sewaGedung = SewaGedung::findOrFail($id);

        // Update data penyewaan
        $sewaGedung->update([
            'nama_penyewa' => $request->nama_penyewa,
            'kontak_penyewa' => $request->kontak_penyewa,
            'tanggal_sewa' => $tanggalSewa,
            'tanggal_akhir_sewa' => $request->tanggal_akhir_sewa ?? null,
            'durasi_sewa' => (new \DateTime($tanggalAkhirSewa))->diff(new \DateTime($tanggalSewa))->days + 1,
            'keperluan' => $request->keperluan,
            'status_pembayaran' => $request->status_pembayaran,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Penyewaan gedung berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $sewa_gedung = SewaGedung::findOrFail($request->id);
        $sewa_gedung->delete();

        return redirect()->back()->with('success', 'Data Penyewaan Gedung Berhasil Dihapus');
    }
}
