<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\WorkScheduleTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WorkScheduleImport;

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

        $data = [
            'title' => 'Dashboard',
            'history' => $history
        ];

//        dd($history);
        return view('admin.jadwal.index', compact('data'));
    }

    public function getDatatables(Request $request)
    {

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
