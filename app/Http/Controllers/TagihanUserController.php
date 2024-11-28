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
        $tagihan_rusuns = SewaRusun::where('user_id', Auth::id())->where('status', 'active')->orderBy('created_at', 'DESC')->first()->tagihan->where('status_post', 'Release');
        $tagihan_kioss = SewaKios::where('user_id', Auth::id())->where('status', 'active')->orderBy('created_at', 'DESC')->first()->tagihan->where('status_post', 'Release');

        $kontak = User::where('role', 'admin')->first()->whatsapp;

        $total_tagihan_rusun_belum_dibayar = 0;
        $total_bulan_rusun_belum_dibayar = 0;
        $total_tagihan_kios_belum_dibayar = 0;
        $total_bulan_kios_belum_dibayar = 0;

        foreach($tagihan_rusuns as $item){
            if($item->status_pembayaran != 'Dibayar'){
                $total = $item->sewa + $item->denda + $item->air;
                $total_tagihan_rusun_belum_dibayar += $total;
                $total_bulan_rusun_belum_dibayar ++;
            }
        }
        foreach($tagihan_kioss as $item){
            if($item->status_pembayaran != 'Dibayar'){
                $total = $item->sewa;
                $total_tagihan_kios_belum_dibayar += $total;
                $total_bulan_kios_belum_dibayar ++;
            }
        }

        // dd($kontak);

        return view('users.tagihan', ['tagihan_rusuns' => $tagihan_rusuns, 'tagihan_kioss' => $tagihan_kioss, 'kontak' => $kontak, 'total_tagihan_rusun_belum_dibayar' => $total_tagihan_rusun_belum_dibayar, 'total_bulan_rusun_belum_dibayar' => $total_bulan_rusun_belum_dibayar, 'total_tagihan_kios_belum_dibayar' => $total_tagihan_kios_belum_dibayar, 'total_bulan_kios_belum_dibayar' => $total_bulan_kios_belum_dibayar]);
    }
}
