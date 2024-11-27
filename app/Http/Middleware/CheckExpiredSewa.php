<?php

namespace App\Http\Middleware;

use App\Models\SewaKios;
use App\Models\SewaRusun;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckExpiredSewa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Pengecekan untuk update status kontrak yang expired
        $today = now()->toDateString(); // Mendapatkan tanggal hari ini

        // Memperbarui status kontrak yang sudah lewat
        SewaRusun::where('tanggal_selesai_kontrak', '<', $today)
                ->where('status', 'active')
                ->update(['status' => 'expired']);

        SewaKios::where('tanggal_selesai_kontrak', '<', $today)
                ->where('status', 'active')
                ->update(['status' => 'expired']);

        // Melanjutkan request ke controller berikutnya
        return $next($request);
    }
}
