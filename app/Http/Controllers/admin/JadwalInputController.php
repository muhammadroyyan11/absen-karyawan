<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Presensi;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\WorkScheduleTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WorkScheduleImport;
use Yajra\DataTables\DataTables;

class JadwalInputController extends Controller
{
    public function index()
    {
        $bulan = date('m');
        $tahun = date('Y');

        $history = DB::table('presensi')
            ->join('users', 'users.id', '=', 'presensi.u_id')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->orderBy('tgl_presensi', 'DESC')
            ->get();

        $department = Department::all();

        $data = [
            'title' => 'Dashboard',
            'history' => $history,
            'department' => $department,
        ];

//        dd($history);
        return view('admin.jadwal.index', compact('data'));
    }

    public function getDatatables(Request $request)
    {
//        $data = WorkSchedule::with(['user', 'shifts'])
//            ->orderBy('date', 'desc');
//
//        $data = DB::table("work_schedules")
//            ->join('users', 'users.id', '=', 'work_schedules.user_id')
//            ->

        $data = DB::table('work_schedules')
            ->leftJoin('users', 'users.id', '=', 'work_schedules.user_id')
            ->leftJoin('shifts', 'shifts.id', '=', 'work_schedules.shift_id')
            ->leftJoin('departments', 'departments.id', '=', 'users.department_id')
            ->leftJoin('presensi', function ($join) {
                $join->on('presensi.u_id', '=', 'work_schedules.user_id')
                    ->whereRaw('DATE(presensi.tgl_presensi) = work_schedules.date');
            })
            ->select(
                'work_schedules.id',
                'users.name as nama',
                'work_schedules.date as tanggal_absen',
                'shifts.name_shift as shift_input',
                'presensi.jam_in as absen_datang',
                'presensi.jam_out as absen_pulang',
                'departments.name as departments_name',
            )
            ->orderBy('work_schedules.date', 'desc');

//        dd($data->get());

        // Filter Divisi
        if ($request->filled('divisi')) {
            $data->where('departments.id', $request->divisi);
        }

        // Filter Date Range (format: "YYYY-MM-DD - YYYY-MM-DD")
        if ($request->filled('date_range')) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) == 2) {
                $startDate = $dates[0];
                $endDate = $dates[1];
                $data->whereBetween('work_schedules.date', [$startDate, $endDate]);
            }
        }


        return DataTables::of($data)
            ->addIndexColumn()
//            ->addColumn('absen_datang', function ($row) {
//                return ($row->jam_in === null || $row->jam_in === '') ? '-' : $row->jam_in;
//            })
            ->addColumn('aksi', function ($row) {
                return '<button class="btn btn-sm btn-info">Detail</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function exportTemplate(Request $request)
    {
        $week = $request->query('week');

        if (!$week || $week < 1 || $week > 5) {
            abort(400, 'Minggu tidak valid');
        }

        return Excel::download(new WorkScheduleTemplateExport($week), 'template_jadwal_minggu_' . $week . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'week' => 'required|integer|min:1|max:5',
            'file' => 'required|file|mimes:xls,xlsx'
        ]);

        Excel::import(new WorkScheduleImport($request->week), $request->file('file'));

        return response()->json(['success' => true]);
    }
}
