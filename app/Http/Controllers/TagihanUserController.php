<?php

namespace App\Http\Controllers;

use App\Models\SewaKios;
use App\Models\SewaRusun;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanUserController extends Controller
{
    public function index()
    {
        // Ambil data Sewa Rusun
        $sewaRusun = SewaRusun::where('user_id', Auth::id())
            ->where('status', 'active')
            ->orderBy('created_at', 'DESC')
            ->first();

        $tagihan_rusuns = $sewaRusun ? $sewaRusun->tagihan->where('status_post', 'Release') : collect();

        // Ambil data Sewa Kios
        $sewaKios = SewaKios::where('user_id', Auth::id())
            ->where('status', 'active')
            ->orderBy('created_at', 'DESC')
            ->first();

        $tagihan_kioss = $sewaKios ? $sewaKios->tagihan->where('status_post', 'Release') : collect();

        // Ambil kontak admin
        $kontak = optional(User::where('role', 'admin')->first())->whatsapp;

        // Inisialisasi total tagihan dan jumlah bulan belum dibayar
        $total_tagihan_rusun_belum_dibayar = 0;
        $total_bulan_rusun_belum_dibayar = 0;
        $total_tagihan_kios_belum_dibayar = 0;
        $total_bulan_kios_belum_dibayar = 0;

        // Hitung total tagihan rusun yang belum dibayar
        foreach ($tagihan_rusuns as $item) {
            if ($item->status_pembayaran != 'Dibayar') {
                $total = ($item->sewa ?? 0) + ($item->denda ?? 0) + ($item->air ?? 0);
                $total_tagihan_rusun_belum_dibayar += $total;
                $total_bulan_rusun_belum_dibayar++;
            }
        }

        // Hitung total tagihan kios yang belum dibayar
        foreach ($tagihan_kioss as $item) {
            if ($item->status_pembayaran != 'Dibayar') {
                $total = $item->sewa ?? 0;
                $total_tagihan_kios_belum_dibayar += $total;
                $total_bulan_kios_belum_dibayar++;
            }
        }

        return view('users.tagihan', [
            'tagihan_rusuns' => $tagihan_rusuns,
            'tagihan_kioss' => $tagihan_kioss,
            'kontak' => $kontak,
            'total_tagihan_rusun_belum_dibayar' => $total_tagihan_rusun_belum_dibayar,
            'total_bulan_rusun_belum_dibayar' => $total_bulan_rusun_belum_dibayar,
            'total_tagihan_kios_belum_dibayar' => $total_tagihan_kios_belum_dibayar,
            'total_bulan_kios_belum_dibayar' => $total_bulan_kios_belum_dibayar,
        ]);
    }
}
