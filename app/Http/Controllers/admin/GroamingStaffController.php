<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GroamingStaffController extends Controller
{
    public function index()
    {
        $presensis = DB::table('presensi')
            ->select('tgl_presensi', 'foto_out')
            ->whereNotNull('foto_out')
            ->orderBy('tgl_presensi', 'desc')
            ->get();

        $folders = [];

        foreach ($presensis as $item) {
            $tanggal = Carbon::parse($item->tgl_presensi);
            $year = $tanggal->format('Y');
            $month = $tanggal->format('m');
            $monthName = $tanggal->format('F');
            $day = $tanggal->format('d');

            $folders[$year]['label'] = $year;
            $folders[$year]['children'][$month]['label'] = $monthName;
            $folders[$year]['children'][$month]['children'][$day]['label'] = $day;
            $folders[$year]['children'][$month]['children'][$day]['photos'][] = asset('storage/' . $item->foto_out);
        }


        return view('admin.groaming.index', compact('folders'));
    }

    public function driveYears()
    {
        $years = DB::table('presensi')
            ->whereNotNull('foto_out')
            ->selectRaw('YEAR(tgl_presensi) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.groaming.drive_grid', [
            'folders' => $years,
            'level' => 'year',
            'path' => []
        ]);
    }

    public function driveMonths($year)
    {
        $months = DB::table('presensi')
            ->whereYear('tgl_presensi', $year)
            ->whereNotNull('foto_out')
            ->selectRaw('MONTH(tgl_presensi) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('month');

//        dd($months);

        return view('admin.groaming.drive_grid', [
            'folders' => $months,
            'level' => 'month',
            'year' => $year,
            'path' => [$year]
        ]);
    }

    public function driveDates($year, $month)
    {
        $days = DB::table('presensi')
            ->whereYear('tgl_presensi', $year)
            ->whereMonth('tgl_presensi', $month)
            ->whereNotNull('foto_out')
            ->selectRaw('DAY(tgl_presensi) as day')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('day');

        return view('admin.groaming.drive_grid', [
            'folders' => $days,
            'level' => 'day',
            'year' => $year,
            'month' => $month,
            'path' => [$year, $month]
        ]);
    }

    public function driveStaff($year, $month, $day)
    {
        $staffs = DB::table('presensi')
            ->join('users', 'presensi.u_id', '=', 'users.id')
            ->whereYear('tgl_presensi', $year)
            ->whereMonth('tgl_presensi', $month)
            ->whereDay('tgl_presensi', $day)
            ->whereNotNull('foto_out')
            ->select('users.name as user_name')
            ->groupBy('user_name')
            ->orderBy('user_name')
            ->get();

        return view('admin.groaming.drive_grid_user', [
            'folders' => $staffs,
            'level' => 'staff',
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'path' => [$year, $month, $day]
        ]);
    }

    public function drivePhotos($year, $month, $day, $user)
    {
        $photos = DB::table('presensi')
            ->join('users', 'presensi.u_id', '=', 'users.id')
            ->whereDate('tgl_presensi', "$year-$month-$day")
            ->where('users.name', $user)
            ->whereNotNull('foto_out')
            ->pluck('foto_out');

        return view('admin.groaming.drive_photo', [
            'photos' => $photos,
            'path' => [$year, $month, $day, $user]
        ]);
    }
}
