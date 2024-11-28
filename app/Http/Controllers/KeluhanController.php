<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use App\Models\Mekanikal;
use App\Models\SewaKios;
use App\Models\SewaRusun;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeluhanController extends Controller
{
    public function index()
    {
        $data_rusun = SewaRusun::where('user_id', Auth::id())->get();

        // dd($data_kios, $data_rusun);

        return view('users.keluhan', ['data_rusun' => $data_rusun]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'deskripsi' => 'required|string|max:500',
            'sewa_rusun_id' => 'required|exists:sewa_rusun,id', // Validasi bahwa ID rusun ada
        ]);

        // dd($request);

        // Simpan keluhan
        Keluhan::create([
            'deskripsi' => $request->deskripsi,
            'status' => 'Pending', // Status default
            'sewa_rusun_id' => $request->sewa_rusun_id,
            'mekanik_id' => null, // Awalnya mekanik belum ditugaskan
        ]);

        return redirect()->back()->with('success', 'Keluhan berhasil ditambahkan.');
    }

    public function listKeluhan($id)
    {
        // Ambil data keluhan berdasarkan sewa_rusun_id dan sertakan relasi mekanikal
        $keluhans = Keluhan::with('mekanik') // Mengambil relasi mekanikal
            ->where('sewa_rusun_id', $id)
            ->get();

        // Format waktu 'created_at' menjadi waktu relatif menggunakan Carbon dan menambahkan informasi mekanikal
        $keluhans->map(function ($keluhan) {
            // Gunakan Carbon untuk menghitung waktu relatif
            $keluhan->created_at_formatted = Carbon::parse($keluhan->created_at)->diffForHumans();

            // Menambahkan data mekanikal ke dalam data keluhan
            if ($keluhan->mekanik) {
                $keluhan->mekanikal_name = $keluhan->mekanik->name;
                $keluhan->mekanikal_no_hp = $keluhan->mekanik->no_hp;
            }

            return $keluhan;
        });

        // Return data dalam format JSON
        return response()->json($keluhans);
    }

    public function index_admin()
    {
        // Ambil semua data keluhan dan urutkan berdasarkan 'created_at' dari yang terbaru
        $keluhans = Keluhan::orderBy('created_at', 'desc')->get();
        $mekanikals = Mekanikal::all();

        return view('admin.keluhan', ['keluhans' => $keluhans, 'mekanikals' => $mekanikals]);
    }

    public function update_keluhan(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'keluhan_id' => 'required|exists:keluhan,id', // Pastikan keluhan_id ada di database
            'mekanik_id' => 'required|exists:mekanikals,id', // Pastikan mekanik_id ada di database
            'status' => 'required|in:Pending,Proses,Selesai', // Status yang diizinkan
        ]);

        // Ambil data keluhan berdasarkan ID
        $keluhan = Keluhan::find($request->keluhan_id);

        // Update data keluhan
        $keluhan->mekanik_id = $request->mekanik_id;  // Assign mekanik
        $keluhan->status = $request->status;  // Update status keluhan
        $keluhan->save();  // Simpan perubahan

        // Redirect ke halaman keluhan dengan pesan sukses
        return redirect()->back()->with('success', 'Keluhan berhasil diperbarui.');
    }
}
