<?php

namespace App\Http\Controllers;

use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class PresensiController extends Controller
{
    public function create()
    {
        $today_date = date('Y-m-d');
        $u_id = Auth::guard('web')->user()->id;
        $check_absen = DB::table('presensi')->where('tgl_presensi', $today_date)->where('u_id', $u_id)->count();

        $data = [
            'check' => $check_absen
        ];
        return view('presensi.create', compact('data'));
    }

    public function store(Request $request)
    {
        $u_id = Auth::guard('web')->user()->id;
        $nik = Auth::guard('web')->user()->nik;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');
        $location = $request->lokasi;


//        dd($request);
        $check_absen = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('u_id', $u_id)->count();

        if ($check_absen > 0) {
            $ket = "out";
        } else {
            $ket = "in";
        }

        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = rand() . '-' . $ket . '-' . $nik . '-' . $tgl_presensi;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;


        if ($check_absen > 0) {
            $params = [
                'jam_out' => $jam,
                'foto_out' => $fileName,
                'location_out' => $location
            ];

            $action = DB::table('presensi')->where('u_id', $u_id)->where('tgl_presensi', $tgl_presensi)->update($params);
            echo 'success|Terima Kasih Buat Hari Ini, Hati Hati Di Jalan Ya Jez😁|out';

        } else {
            $jadwal = WorkSchedule::where('user_id', $u_id)
                ->where('date', $tgl_presensi)
                ->first();

//            dd($jadwal);

            if (!$jadwal) {
                return response()->json(['error' => 'Jadwal belum diatur untuk hari ini.'], 422);
            }

            $shift_id_user_days = $jadwal->shift_id;

            $params = [
                'u_id' => $u_id,
                'shift_id' => $shift_id_user_days,
                'tgl_presensi' => $tgl_presensi,
                'jam_in' => $jam,
                'foto_in' => $fileName,
                'location_in' => $location
            ];

            $action = DB::table('presensi')->insert($params);


            echo 'success|Terima Kasih, Selamat Bekerja|in';
        }

        if ($action) {
            Storage::put($file, $image_base64);
        }

    }

    public function editProfile()
    {
        return view('presensi.edit_profile');
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $nama = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);

        if (!empty($request->password)) {
            $params = [
                'name' => $nama,
                'no_hp' => $no_hp,
                'password' => $password
            ];
        } else {
            $params = [
                'name' => $nama,
                'no_hp' => $no_hp
            ];
        }

        $update = DB::table('users')->where('id', $id)->update($params);

        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['error' => 'Terjadi Keasalahan']);
        }
    }

    public function history()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.history', compact('namabulan'));
    }

    public function getHistory(Request $request)
    {
        $id = Auth::user()->id;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $history = DB::table('presensi')
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->where('u_id', $id)
            ->orderBy('tgl_presensi', 'ASC')
            ->get();

        return view('presensi.getHistory', compact('history'));
    }

    public function getHistoryCalendar(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $userId = auth()->user()->id;

        $data = DB::table('presensi')
            ->whereMonth('tgl_presensi', $bulan)
            ->whereYear('tgl_presensi', $tahun)
            ->where('u_id', $userId)
            ->get();

        $events = [];

        foreach ($data as $item) {
            // Event jam masuk
            $events[] = [
                'title' => 'In: ' . date('H:i', strtotime($item->jam_in)),
                'start' => $item->tgl_presensi,
                'color' => 'green',
            ];

            // Event jam keluar (jika ada)
            if ($item->jam_out) {
                $events[] = [
                    'title' => 'Out: ' . date('H:i', strtotime($item->jam_out)),
                    'start' => $item->tgl_presensi,
                    'color' => 'red',
                ];
            }
        }

        return response()->json($events);
    }

    public function getPresensiDetail(Request $request)
    {
        $tanggal = $request->date;

        // Ambil data presensi berdasarkan tanggal
        $presensi = DB::table('presensi')
            ->where('tgl_presensi', $tanggal)
            ->get();

        $output = '';
        $presensiData = [];

        foreach ($presensi as $item) {
            $tanggal = date('d F Y', strtotime($item->tgl_presensi));
            $hari = date('l', strtotime($item->tgl_presensi));

            $output .= '<div class="presensi-card">';

            $output .= '<h4>' . $hari . ', ' . $tanggal . '</h4>';

            $output .= '<table class="table table-borderless presensi-table">';
            $output .= '<tr><th>Jam Masuk</th><td>' . date('H:i', strtotime($item->jam_in)) . '</td></tr>';
            $output .= '<tr><th>Jam Keluar</th><td>' . ($item->jam_out ? date('H:i', strtotime($item->jam_out)) : '-') . '</td></tr>';
            $output .= '<tr><th>Foto Masuk</th><td><img class="foto-presensi" src="' . Storage::url('uploads/absensi/' . $item->foto_in) . '" width="100" data-bs-toggle="modal" data-bs-target="#modalFoto"></td></tr>';
            $output .= '<tr><th>Foto Keluar</th><td>' . ($item->foto_out ? '<img class="foto-presensi" src="' . Storage::url('uploads/absensi/' . $item->foto_out) . '" width="100" data-bs-toggle="modal" data-bs-target="#modalFoto">' : '-') . '</td></tr>';
            $output .= '</table>';

            $output .= '<div class="maps-container">';
//            $output .= '<h5>Lokasi Masuk</h5><div id="mapIn' . $item->id . '" class="map" style="height: 200px;"></div>';
//            $output .= '<h5>Lokasi Keluar</h5><div id="mapOut' . $item->id . '" class="map" style="height: 200px;"></div>';

            if (!empty($item->location_in)) {
                $output .= '<h5>Lokasi Masuk</h5><div id="mapIn' . $item->id . '" class="map" style="height: 200px;"></div>';
            }

            if (!empty($item->location_out)) {
                $output .= '<h5>Lokasi Keluar</h5><div id="mapOut' . $item->id . '" class="map" style="height: 200px;"></div>';
            }
            $output .= '</div>';

            $output .= '</div>';

            $presensiData[] = [
                'id' => $item->id,
                'location_in' => $item->location_in,
                'location_out' => $item->location_out
            ];
        }

        return response()->json([
            'html' => $output,
            'presensi' => $presensiData
        ]);
    }

    public function cuti(User $user)
    {
        $id = Auth::user()->id;
        $dataizin = DB::table('pengajuan_cuti')->where('u_id', $id)->orderBy('tgl_izin', 'asc')->get();
        $leaveQuota = $user->getLeaveQuota();


        return view('presensi.cuti', compact('dataizin', 'leaveQuota'));
    }

    public function checkLeaveEligibility(User $user)
    {
        $leaveQuota = $user->getLeaveQuota();

        $leaveTaken = Leave::where('user_id', $user->id)
            ->whereBetween('leave_start', [now()->subMonths(6), now()])
            ->sum('days_taken');

        if ($leaveTaken >= $leaveQuota) {
            return response()->json(['message' => 'Leave quota exceeded.']);
        }

        return response()->json(['message' => 'You are eligible for leave.']);
    }

    public function create_cuti()
    {

        return view('presensi.create_cuti');
    }

    public function store_cuti(Request $request)
    {
        $id = Auth::user()->id;
        $tanggal = $request->tanggal;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $params = [
            'u_id' => $id,
            'tgl_izin' => $tanggal,
            'keterangan' => $keterangan,
            'status' => $status,
            'status_approved' => 0
        ];

        $action = DB::table('pengajuan_cuti')->insert($params);

        if ($action) {
            return redirect('/presensi/cuti')->with(['success' => 'Data Berhasil Diajukan']);
        } else {
            return redirect('/presensi/cuti')->with(['error' => 'Terjadi kesalahan!']);
        }

//        echo $tanggal;
    }
}
