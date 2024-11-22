<?php

namespace App\Http\Controllers;

use App\Models\Rusun;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RusunController extends Controller
{
    public function index()
    {
        $rusuns = Rusun::all();

        return view('admin.manage-rusun', ['rusuns' => $rusuns]);
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nomor_rusun' => 'required|string|max:255|unique:rusuns,nomor_rusun',
            'lantai' => 'required|string|max:10',
            'tower' => 'required|string|max:50',
            'harga_sewa' => 'required|numeric|min:0',
        ]);

        // Simpan data ke database
        Rusun::create([
            'nomor_rusun' => $request->nomor_rusun,
            'lantai' => $request->lantai,
            'tower' => $request->tower,
            'harga_sewa' => $request->harga_sewa,
        ]);

        // Redirect dengan pesan sukses
        return redirect('/manage-rusun')->with('success', 'Data rusun berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        // Validasi data
        $request->validate([
            'id_update' => 'required|exists:rusuns,id',
            'nomor_rusun_update' => 'required|string|max:255|unique:rusuns,nomor_rusun,' . $request->id_update,
            'lantai_update' => 'required|string|max:10',
            'tower_update' => 'required|string|max:50',
            'harga_sewa_update' => 'required|numeric|min:0',
        ]);

        // Simpan data ke database
        $rusun = Rusun::find($request->id_update);
        $rusun->update([
            'nomor_rusun' => $request->nomor_rusun_update,
            'lantai' => $request->lantai_update,
            'tower' => $request->tower_update,
            'harga_sewa' => $request->harga_sewa_update,
        ]);

        // Redirect dengan pesan sukses
        return redirect('/manage-rusun')->with('success', 'Data rusun berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $rusun = Rusun::find($request->id);
        $rusun->delete();

        return redirect('/manage-rusun')->with('success', 'Data rusun berhasil dihapus.');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Rusun::query(); // Ganti dengan query untuk mendapatkan data rusun
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return '
                        <button type="button" class="btn btn-sm btn-warning editButton"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal"
                            data-id="' . $row->id . '"
                            data-nomor_rusun="' . $row->nomor_rusun . '"
                            data-lantai="' . $row->lantai . '"
                            data-tower="' . $row->tower . '"
                            data-harga_sewa="' . $row->harga_sewa . '">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger deleteButton"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-id="' . $row->id . '"
                            data-nomor_rusun="' . $row->nomor_rusun . '">
                            <i class="fas fa-trash"></i>
                        </button>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }
}
