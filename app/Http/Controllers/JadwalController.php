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
        // Mendapatkan user yang sedang login
        $userId = auth()->id(); // Menggunakan Laravel's auth helper untuk mendapatkan ID pengguna yang sedang login

        // Ambil bulan dan tahun dari request, jika tidak ada gunakan bulan dan tahun sekarang
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        // Ambil data jadwal berdasarkan bulan, tahun, dan user_id yang sedang login
        $schedules = jadwals::where('user_id', $userId) // Filter berdasarkan user_id yang login
            ->get();

//        dd($schedules);
        // Format data untuk FullCalendar
//        $events = $schedules->map(function ($schedule) {
//            return [
//                'title' => $schedule->shift->name_shift, // Nama shift atau keterangan lainnya
//                'start' => $schedule->date->toDateString(), // Format start date
//                'end' => $schedule->date->toDateString(), // Format end date (jika ada)
//                'description' => $schedule->shift->description, // Deskripsi jika diperlukan
//            ];
//        });

        $events = $schedules->map(function ($schedule) {
            $shiftName = $schedule->shift->name_shift ?? 'N/A';
            $description = $schedule->shift->description ?? '';

            // Jika nama shift adalah "Libur", warnai merah
            $color = stripos($shiftName, 'Libur') !== false ? '#ff0000' : '#3788d8';

            return [
                'title' => $shiftName,
                'start' => $schedule->date->toDateString(), // Format start date
                'end' => $schedule->date->toDateString(),
                'description' => $description,
                'color' => $color,
            ];
        });


        return response()->json($events); // Mengirimkan data ke frontend dalam format JSON
    }
}
