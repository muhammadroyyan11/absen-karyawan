<?php

namespace App\Http\Controllers;

use App\Models\Jadwals;
use Illuminate\Http\Request;

class JadwalController extends Controller
{

    public function index()
    {
        $params = [
            'title' => 'Jadwal',
        ];

        return view('jadwal.index', $params);
    }

    public function getJadwalCalendar(Request $request)
    {
        $userId = auth()->user()->id;

        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $schedules = jadwals::where('user_id', $userId)
            ->get();

        $events = $schedules->map(function ($schedule) {
            $shiftName = $schedule->shift->name_shift ?? 'N/A';
            $description = $schedule->shift->description ?? '';

            $color = stripos($shiftName, 'Libur') !== false ? '#ff0000' : '#3788d8';

            return [
                'title' => $shiftName,
                'start' => $schedule->date->toDateString(),
                'end' => $schedule->date->toDateString(),
                'description' => $description,
                'color' => $color,
            ];
        });


        return response()->json($events);
    }
}
