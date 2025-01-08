<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PegawaiMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $userId = Session::get('pegawai_id');  // Ambil id_pegawai dari session
        
        $pegawai = DB::table('pegawai')
            ->where('id_pegawai', $userId)
            ->where('status_pegawai', 0)
            ->first();
        
        if (!$pegawai) {
            return redirect('/')->with('error', 'Akses ditolak');
        }
        
        return $next($request);
    }
}
