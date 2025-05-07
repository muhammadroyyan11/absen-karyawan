<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JadwalInputController extends Controller
{
    public function index()
    {
        $bulan      = date('m');
        $tahun      = date('Y');

        $history    = DB::table('presensi')
            ->join('users', 'users.id', '=', 'presensi.u_id')
            ->whereRaw('MONTH(tgl_presensi)="'. $bulan .'"')
            ->whereRaw('YEAR(tgl_presensi)="'. $tahun .'"')
            ->orderBy('tgl_presensi', 'DESC')
            ->get();

        $data = [
            'title'     => 'Dashboard',
            'history'   => $history
        ];

//        dd($history);
        return view('admin.rekapAbsen', compact('data'));
    }

    public function getDatatables(Request $request)
    {

    }
}
