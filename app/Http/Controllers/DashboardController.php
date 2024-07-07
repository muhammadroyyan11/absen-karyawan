<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today      = date('Y-m-d');
        $month      = date('m');
        $year       = date('Y');
        $id_user    = Auth::guard('web')->user()->id;

        $history    = DB::table('presensi')
            ->where('u_id', $id_user)
            ->whereRaw('MONTH(tgl_presensi)="' . $month . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $year . '"')
            ->orderBy('tgl_presensi', 'asc')
            ->get();

        $hadir      = DB::table('presensi')
            ->selectRaw('COUNT(u_id) as jmlhadir, SUM(IF(jam_in > "08:00",1,0)) as jmltelat')
            ->where('u_id', $id_user)
            ->whereRaw('MONTH(tgl_presensi)="' . $month . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $year . '"')
            ->orderBy('tgl_presensi', 'asc')
            ->first();

        $cuti      = DB::table('pengajuan_cuti')
            ->selectRaw('COUNT(u_id) as jmlcuti')
            ->where('u_id', $id_user)
            ->where('status', 'i')
            ->whereRaw('MONTH(tgl_izin)="' . $month . '"')
            ->whereRaw('YEAR(tgl_izin)="' . $year . '"')
            ->orderBy('tgl_izin', 'asc')
            ->first();

        $sakit      = DB::table('pengajuan_cuti')
            ->selectRaw('COUNT(u_id) as jmlsakit')
            ->where('u_id', $id_user)
            ->where('status', 's')
            ->whereRaw('MONTH(tgl_izin)="' . $month . '"')
            ->whereRaw('YEAR(tgl_izin)="' . $year . '"')
            ->orderBy('tgl_izin', 'asc')
            ->first();

        $terlambat   = DB::table('presensi')
            ->where('u_id', $id_user)
            ->whereRaw('TIME(jam_in) > ?', ['08:00:00'])
            ->whereRaw('MONTH(tgl_presensi)="' . $month . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $year . '"')
            ->orderBy('tgl_presensi', 'asc')
            ->get();
        $data = [
            'title'             => 'dashboard',
            'presensiHarian'    => DB::table('presensi')->where('u_id', $id_user)->where('tgl_presensi', $today)->first(),
            'history'           => $history,
            'terlambat'         => $terlambat,
            'hadir'             => $hadir,
            'cuti'              => $cuti,
            'sakit'              => $sakit
        ];

//        dd($terlambat);

        return view('dashboard.dashboard', compact('data'));
    }
}
