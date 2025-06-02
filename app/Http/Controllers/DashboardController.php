<?php

namespace App\Http\Controllers;

use DateTime;
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

        $history = DB::table('presensi')
            ->where('u_id', $id_user)
            ->whereRaw('MONTH(tgl_presensi) = ?', [$month])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$year])
            ->orderBy('tgl_presensi', 'asc')
            ->get();

        $hadir = DB::table('presensi')
            ->selectRaw('COUNT(u_id) as jmlhadir, SUM(IF(jam_in > "08:00",1,0)) as jmltelat')
            ->where('u_id', $id_user)
            ->whereRaw('MONTH(tgl_presensi) = ?', [$month])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$year])
            ->first();

        $cuti      = DB::table('pengajuan_cuti')
            ->selectRaw('COUNT(u_id) as jmlcuti')
            ->where('u_id', $id_user)
            ->where('status', 'i')
            ->whereRaw('MONTH(tgl_izin) = ?', [$month])
            ->whereRaw('YEAR(tgl_izin) = ?', [$year])
            ->first();

        $sakit      = DB::table('pengajuan_cuti')
            ->selectRaw('COUNT(u_id) as jmlsakit')
            ->where('u_id', $id_user)
            ->where('status', 's')
            ->whereRaw('MONTH(tgl_izin) = ?', [$month])
            ->whereRaw('YEAR(tgl_izin) = ?', [$year])
            ->first();

        $terlambat   = DB::table('presensi')
            ->where('u_id', $id_user)
            ->whereRaw('TIME(jam_in) > ?', ['08:00:00'])
            ->whereRaw('MONTH(tgl_presensi) = ?', [$month])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$year])
            ->get();

        $date_tommorow = new DateTime('tomorrow');

        $format_date_tommorow = $date_tommorow->format('Y-m-d');
//        dd($format_date_tommorow);


        $shift_tommorow = DB::table('work_schedules')
            ->join('shifts', 'work_schedules.shift_id', '=', 'shifts.id')
            ->select('work_schedules.*', 'shifts.name_shift')
            ->where('user_id', $id_user)->where('date', $format_date_tommorow)
            ->first()->name_shift;

//        dd($shift_tommorow);

//        echo $datetime->format('Y-m-d H:i:s');
        $data = [
            'title'             => 'dashboard',
            'presensiHarian'    => DB::table('presensi')->where('u_id', $id_user)->where('tgl_presensi', $today)->first(),
            'history'           => $history,
            'terlambat'         => $terlambat,
            'hadir'             => $hadir,
            'cuti'              => $cuti,
            'sakit'              => $sakit,
            'shift'             => $shift_tommorow
        ];

//        dd($terlambat);

        return view('dashboard.dashboard', compact('data'));
    }
}
