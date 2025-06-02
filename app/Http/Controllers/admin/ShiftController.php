<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DayShift;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Presensi;
use App\Models\WorkSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\WorkScheduleTemplateExport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WorkScheduleImport;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class ShiftController extends Controller
{
    public function index()
    {
        return view('admin.shift.shift');
    }

    public function getDatatables(Request $request)
    {
        $data = DB::table('shifts')
            ->select('shifts.id as id_shift', 'shifts.name_shift','employment_types.name as type_name')
            ->leftJoin('employment_types', 'employment_types.id', '=', 'shifts.employment_type_id')
           ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-info btn-detail-shifts" data-shift-id="' . $row->id_shift . '">Detail</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getDetail(Request $request)
    {
        $shiftId = $request->shift_id;
        $shift = DB::table('shifts')
            ->leftJoin('employment_types', 'employment_types.id', '=', 'shifts.employment_type_id')
            ->leftJoin('day_shifts', 'day_shifts.shift_id', '=', 'shifts.id')
            ->where('shifts.id', $shiftId)->first();

        if (!$shift) {
            return response()->json(['error' => 'Shift not found'], 404);
        }

        $data = [
            'id' => $shift->id,
            'name_shift' => $shift->name_shift,
        ];

//        return view('admin.shift.detail', compact('data'));
    }

    public function detailView($id)
    {
        $shift = DB::table('shifts')
            ->leftJoin('employment_types', 'employment_types.id', '=', 'shifts.employment_type_id')
            ->leftJoin('day_shifts', 'day_shifts.shift_id', '=', 'shifts.id')
            ->where('shifts.id', $id)
//            ->select('shifts.*', 'employment_types.name as employment_type', 'day_shifts.day', 'day_shifts.start_time', 'day_shifts.end_time')
            ->first();

        $dayShifts = DB::table('day_shifts')
            ->where('shift_id', $id)
            ->get();

        if (!$shift) {
            abort(404, 'Shift tidak ditemukan');
        }

        return view('admin.shift.detail', compact('shift', 'dayShifts'));
    }

    public function daysSave(Request $request)
    {
        $validated = $request->validate([
            'shift_id' => 'nullable|integer|exists:shifts,id',
            'name_day_shift' => 'required|string',
            'time_start' => 'nullable|date_format:H:i',
            'time_end' => 'nullable|date_format:H:i',
        ]);

        if ($validated['shift_id']) {
            // update existing
            $shift = DayShift::find($validated['shift_id']);
            if (!$shift) return response()->json(['error' => 'Shift tidak ditemukan'], 404);

            $shift->update([
                'name_day_shift' => $validated['name_day_shift'],
                'time_start' => $validated['time_start'],
                'time_end' => $validated['time_end'],
            ]);
        } else {
            // create new
            $shift = DayShift::create([
                'name_day_shift' => $validated['name_day_shift'],
                'time_start' => $validated['time_start'],
                'time_end' => $validated['time_end'],
                'shift_id' => 1,
            ]);
        }

        return response()->json([
            'success' => true,
            'shift_id' => $shift->id,
        ]);
    }

    public function daysDelete(Request $request)
    {
        $validated = $request->validate([
            'shift_id' => 'required|integer|exists:shifts,id',
        ]);

        $shift = Shift::find($validated['shift_id']);
        if (!$shift) return response()->json(['error' => 'Shift tidak ditemukan'], 404);

        $shift->delete();

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
