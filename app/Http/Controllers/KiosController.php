<?php

namespace App\Http\Controllers;

use App\Models\Kios;
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
            $data = Kios::query(); // Ganti dengan query untuk mendapatkan data kios
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
