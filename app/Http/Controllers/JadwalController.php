<?php

namespace App\Http\Controllers;

use App\Models\jadwals;
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
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $userId = auth()->user()->id;

        // Ambil data jadwal berdasarkan bulan, tahun, dan user_id yang sedang login
        $data = DB::table('jadwals')
            ->whereMonth('date', $bulan)
            ->whereYear('date', $tahun)
            ->where('user_id', $userId)
            ->get();

        $events = [];

        foreach ($data as $item) {
            // Ambil informasi shift
            $shiftName = $item->shift->name_shift ?? 'N/A';
            $description = $item->shift->description ?? '';

            // Jika nama shift adalah "Libur", warnai merah
            $color = stripos($shiftName, 'Libur') !== false ? '#ff0000' : '#3788d8';

            // Event untuk jadwal kerja
            $events[] = [
                'title' => $shiftName,
                'start' => $item->date,
                'end' => $item->date,
                'description' => $description,
                'color' => $color,
            ];
        }

        return response()->json($events);
    }
}
