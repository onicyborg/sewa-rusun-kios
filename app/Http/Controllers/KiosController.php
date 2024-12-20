<?php

namespace App\Http\Controllers;

use App\Models\Kios;
use App\Models\SewaKios;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KiosController extends Controller
{
    public function index()
    {
        $kioss = Kios::all();

        return view('admin.manage-kios', ['kioss' => $kioss]);
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama_kios' => 'required|string|max:255|unique:kios,nama_kios',
            'harga_kios' => 'required|numeric|min:0',
        ]);

        // Simpan data ke database
        Kios::create([
            'nama_kios' => $request->nama_kios,
            'harga_kios' => $request->harga_kios,
        ]);

        // Redirect dengan pesan sukses
        return redirect('/manage-kios')->with('success', 'Data kios berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        // Validasi data
        $request->validate([
            'id_update' => 'required|exists:kios,id',
            'nama_kios_update' => 'required|string|max:255|unique:kios,nama_kios,' . $request->id_update,
            'harga_kios_update' => 'required|string|min:0',
        ]);

        // Simpan data ke database
        $kios = Kios::find($request->id_update);
        $kios->update([
            'nama_kios' => $request->nama_kios_update,
            'harga_kios' => $request->harga_kios_update,
        ]);

        // Redirect dengan pesan sukses
        return redirect('/manage-kios')->with('success', 'Data kios berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $kios = Kios::find($request->id);
        $kios->delete();

        return redirect('/manage-kios')->with('success', 'Data kios berhasil dihapus.');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Kios::with(['sewa_kios' => function ($query) {
                $query->where('status', 'active');
            }]); // Memuat relasi sewa_kios dengan kondisi status 'active'

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status_penyewaan', function ($row) {
                    // Memeriksa apakah ada relasi ke sewa_kios dengan status 'active'
                    return $row->sewa_kios->isNotEmpty() ? 'Disewa' : 'Kosong';
                })
                ->make(true);
        }
    }

    public function getHistory($id)
    {
        $history = SewaKios::where('kios_id', $id)
            ->with('penyewa') // Memuat data nama penyewa
            ->select('id', 'user_id', 'tanggal_mulai_kontrak', 'tanggal_selesai_kontrak')
            ->get()
            ->map(function ($sewa) {
                return [
                    'nama_penyewa' => $sewa->penyewa->name ?? 'Tidak Diketahui', // Ambil nama penyewa
                    'periode_awal' => $sewa->tanggal_mulai_kontrak,
                    'periode_akhir' => $sewa->tanggal_selesai_kontrak,
                    'user_id' => $sewa->penyewa->id
                ];
            });

        return response()->json($history);
    }
}
