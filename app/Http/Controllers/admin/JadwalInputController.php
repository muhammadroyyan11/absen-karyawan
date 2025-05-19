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
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WorkScheduleImport;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

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
            'title' => 'Jadwal / Rekap Absensi',
            'history' => $history,
            'department' => $department,
        ];

//        dd($history);
        return view('admin.jadwal.index', compact('data'));
    }

    public function getDatatables(Request $request)
    {
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
                'users.id as user_id',
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
            ->editColumn('tanggal_absen', function ($row) {
                return Carbon::parse($row->tanggal_absen)->translatedFormat('l, d F Y');
            })
            ->addColumn('aksi', function ($row) {
                return '<button class="btn btn-sm btn-info" id="btn-detail-presensi" data-user-id="' . $row->user_id . '" data-date="' . $row->tanggal_absen . '">Detail</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function getPresensiDetail(Request $request)
    {
        $tanggal = $request->date;
        $user_id = $request->user_id;

//        dd($tanggal);

        $presensi = DB::table('users')
            ->leftJoin('departments', 'departments.id', '=', 'users.department_id')
            ->leftJoin('work_schedules', function ($join) use ($tanggal) {
                $join->on('work_schedules.user_id', '=', 'users.id')
                    ->whereDate('work_schedules.date', $tanggal);
            })
            ->leftJoin('shifts', 'shifts.id', '=', 'work_schedules.shift_id')
            ->leftJoin('presensi', function ($join) use ($tanggal) {
                $join->on('presensi.u_id', '=', 'users.id')
                    ->whereDate('presensi.tgl_presensi', $tanggal);
            })
            ->where('users.id', $user_id)
            ->select(
                'users.name',
                'users.nik',
                'departments.name as divisi',
                'presensi.*',
                'shifts.name_shift as shift_name',
                'work_schedules.date as shift_date'
            )
            ->first();

        if (!$presensi) {
            return response()->json(['html' => '<p>Data tidak ditemukan</p>']);
        }

        $output = '<div class="presensi-card">';
        $output .= '<table class="table table-bordered">';

        $output .= '<tr><th>Nama</th><td>' . $presensi->name . '</td></tr>';
        $output .= '<tr><th>NIK</th><td>' . $presensi->nik . '</td></tr>';
        $output .= '<tr><th>Divisi</th><td>' . $presensi->divisi . '</td></tr>';
        $output .= '<tr><th>Tanggal Shift</th><td>' . Carbon::parse($presensi->shift_date)->translatedFormat('l, d F Y') . '</td></tr>';
        $output .= '<tr><th>Shift</th><td>' . $presensi->shift_name . '</td></tr>';

        $output .= '<tr><th>Jam Masuk</th><td>' . ($presensi->jam_in ? date('H:i', strtotime($presensi->jam_in)) : '-') . '</td></tr>';
        $output .= '<tr><th>Jam Keluar</th><td>' . ($presensi->jam_out ? date('H:i', strtotime($presensi->jam_out)) : '-') . '</td></tr>';

        $output .= '<tr><th>Foto Masuk</th><td>' . ($presensi->foto_in ? '<img src="' . Storage::url('uploads/absensi/' . $presensi->foto_in) . '" width="120">' : '-') . '</td></tr>';
        $output .= '<tr><th>Foto Keluar</th><td>' . ($presensi->foto_out ? '<img src="' . Storage::url('uploads/absensi/' . $presensi->foto_out) . '" width="120">' : '-') . '</td></tr>';

        $output .= '</table>';

        // Peta lokasi
        $output .= '<div class="maps-container">';
//        $output .= '<h5>Lokasi Masuk</h5><div id="mapIn' . $presensi->id . '" class="map" style="height: 200px;"></div>';
//        $output .= '<h5>Lokasi Keluar</h5><div id="mapOut' . $presensi->id . '" class="map" style="height: 200px;"></div>';

        if (!empty($presensi->location_in)) {
            $output .= '<h5>Lokasi Masuk</h5><div id="mapIn' . $presensi->id . '" class="map" style="height: 200px;"></div>';
        }

        if (!empty($presensi->location_out)) {
            $output .= '<h5>Lokasi Keluar</h5><div id="mapOut' . $presensi->id . '" class="map" style="height: 200px;"></div>';
        }
        $output .= '</div>';

        $output .= '</div>';

        return response()->json([
            'html' => $output,
            'presensi' => [[
                'id' => $presensi->id,
                'location_in' => $presensi->location_in,
                'location_out' => $presensi->location_out
            ]]
        ]);
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
