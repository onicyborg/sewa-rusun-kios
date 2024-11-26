<?php

namespace App\Http\Controllers;

use App\Models\Mekanikal;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MekanikalController extends Controller
{
    public function index()
    {
        return view('admin.manage-mekanikal');
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255|unique:mekanikals,name',
            'no_hp' => 'required|numeric|min:0',
        ]);

        // Simpan data ke database
        Mekanikal::create([
            'name' => $request->name,
            'no_hp' => '+62' . $request->no_hp,
        ]);

        // Redirect dengan pesan sukses
        return redirect('/manage-mekanikal')->with('success', 'Data mekanikal berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        // Validasi data
        $request->validate([
            'id_update' => 'required|exists:mekanikals,id',
            'name_update' => 'required|string|max:255|unique:mekanikals,name,' . $request->id_update,
            'no_hp_update' => 'required|string|min:0',
        ]);

        // Simpan data ke database
        $mekanikal = Mekanikal::find($request->id_update);
        $mekanikal->update([
            'name' => $request->name_update,
            'no_hp' => $request->no_hp_update,
        ]);

        // Redirect dengan pesan sukses
        return redirect('/manage-mekanikal')->with('success', 'Data mekanikal berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $mekanikal = Mekanikal::find($request->id);
        $mekanikal->delete();

        return redirect('/manage-mekanikal')->with('success', 'Data mekanikal berhasil dihapus.');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Mekanikal::query(); // Query data dari tabel Mekanikal

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
