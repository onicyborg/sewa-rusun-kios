<?php

namespace App\Http\Controllers;

use App\Models\Rusun;
use App\Models\SewaKios;
use App\Models\SewaRusun;
use App\Models\User;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    public function index()
    {
        // Penghuni aktif: penyewaan rusun atau kios yang statusnya "aktif"
        $penghuni_active = User::where('role', 'user')->whereHas('sewa_rusun', function ($query) {
            $query->where('status', 'active');
        })
            ->orWhereHas('sewa_kios', function ($query) {
                $query->where('status', 'active');
            })
            ->get();


        // Penghuni non-aktif: penyewaan rusun atau kios yang tidak aktif
        $penghuni_non_active = User::where('role', 'user')->where(function ($query) {
            // Cek pengguna yang tidak memiliki sewa rusun atau sewa kios sama sekali
            $query->whereDoesntHave('sewa_rusun')
                ->whereDoesntHave('sewa_kios');
        })
            ->orWhere(function ($query) {
                // Cek pengguna yang memiliki sewa rusun atau sewa kios, tetapi seluruh penyewaan memiliki status 'expired'
                $query->whereHas('sewa_rusun', function ($query) {
                    $query->where('status', 'expired');
                })
                    ->orWhereHas('sewa_kios', function ($query) {
                        $query->where('status', 'expired');
                    });
            })
            ->get();


        // dd($penghuni_active);

        return view('admin.data-penghuni', compact('penghuni_active', 'penghuni_non_active'));
    }

    public function detail_user($id)
    {
        $user = User::find($id);

        $sewa_rusun = SewaRusun::where('user_id', $id)->get();
        $sewa_kios = SewaKios::where('user_id', $id)->get();

        return view('admin.detail-user', ['user' => $user, 'sewa_rusun' => $sewa_rusun, 'sewa_kios' => $sewa_kios]);
    }
}
