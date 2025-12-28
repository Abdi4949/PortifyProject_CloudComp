<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visit;
use Carbon\Carbon;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil IP Pengunjung
        $ip = $request->ip();
        $today = Carbon::today();

        // Cek apakah IP ini sudah tercatat hari ini?
        // Jika BELUM, maka catat sebagai kunjungan baru
        if (!Visit::where('ip_address', $ip)->where('visit_date', $today)->exists()) {
            Visit::create([
                'ip_address' => $ip,
                'visit_date' => $today,
            ]);
        }

        return $next($request);
    }
}