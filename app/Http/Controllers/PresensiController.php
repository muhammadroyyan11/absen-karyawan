<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {
        $today_date = date('Y-m-d');
        $u_id = Auth::guard('web')->user()->id;
        $check_absen = DB::table('presensi')->where('tgl_presensi', $today_date)->where('u_id', $u_id)->count();

        $data = [
            'check'     => $check_absen
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

        $check_absen = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('u_id', $u_id)->count();

        if ($check_absen > 0){
            $ket = "out";
        } else {
            $ket = "in";
        }

        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $ket . '-' . $nik . '-' . $tgl_presensi;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName.".png";
        $file = $folderPath . $fileName;


        if ($check_absen > 0){
            $params = [
                'jam_out'       => $jam,
                'foto_out'      => $fileName,
                'location_out'   => $location
            ];

            $action = DB::table('presensi')->where('u_id', $u_id)->where('tgl_presensi', $tgl_presensi)->update($params);
            echo 'success|Terima Kasih, Hati Hati Di Jalan|out';

        } else {
            $params = [
                'u_id'          => $u_id,
                'tgl_presensi'  => $tgl_presensi,
                'jam_in'        => $jam,
                'foto_in'       => $fileName,
                'location_in'   => $location
            ];

            $action = DB::table('presensi')->insert($params);


            echo 'success|Terima Kasih, Selamat Bekerja|in';
        }

        if ($action){
            Storage::put($file,$image_base64);
        }

    }

    public function editProfile()
    {
        return view('presensi.edit_profile');
    }

    public function updateProfile(Request $request)
    {
        $id         = Auth::user()->id;
        $nama       = $request->nama_lengkap;
        $no_hp      = $request->no_hp;
        $password      = Hash::make($request->password);

        if (!empty($request->password)){
            $params = [
                'name'      => $nama,
                'no_hp'     => $no_hp,
                'password'  => $password
            ];
        } else {
            $params = [
                'name'      => $nama,
                'no_hp'     => $no_hp
            ];
        }

        $update = DB::table('users')->where('id', $id)->update($params);

        if ($update){
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
        $id         = Auth::user()->id;
        $bulan      = $request->bulan;
        $tahun      = $request->tahun;

        $history    = DB::table('presensi')
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
        $tanggal = $request->date;  // Tanggal yang dikirimkan dari AJAX

        // Ambil data presensi berdasarkan tanggal
        $presensi = DB::table('presensi')
            ->where('tgl_presensi', $tanggal)
            ->get();

        $output = '';

        foreach ($presensi as $item) {
            $output .= "<p><strong>Jam Masuk:</strong> " . date('H:i', strtotime($item->jam_in)) . "</p>";
            $output .= "<p><strong>Jam Keluar:</strong> " . ($item->jam_out ? date('H:i', strtotime($item->jam_out)) : '-') . "</p>";
            $output .= "<p><strong>Foto Masuk:</strong> <img src='" . asset('storage/' . $item->foto_in) . "' width='100'></p>";
            $output .= "<p><strong>Foto Keluar:</strong> <img src='" . ($item->foto_out ? asset('storage/' . $item->foto_out) : '') . "' width='100'></p>";
            $output .= "<p><strong>Lokasi Masuk:</strong> " . ($item->location_in ?? '-') . "</p>";
            $output .= "<p><strong>Lokasi Keluar:</strong> " . ($item->location_out ?? '-') . "</p>";
        }

        return response()->json($output);
    }

    public function cuti()
    {
        $id         = Auth::user()->id;
        $dataizin = DB::table('pengajuan_cuti')->where('u_id', $id)->orderBy('tgl_izin', 'asc')->get();
        return view('presensi.cuti', compact('dataizin'));
    }

    public function create_cuti()
    {

        return view('presensi.create_cuti');
    }

    public function store_cuti(Request $request)
    {
        $id         = Auth::user()->id;
        $tanggal    = $request->tanggal;
        $status     = $request->status;
        $keterangan = $request->keterangan;

        $params = [
            'u_id'              => $id,
            'tgl_izin'          => $tanggal,
            'keterangan'        => $keterangan,
            'status'            => $status,
            'status_approved'   => 0
        ];

        $action = DB::table('pengajuan_cuti')->insert($params);

        if ($action){
            return redirect('/presensi/cuti')->with(['success' => 'Data Berhasil Diajukan']);
        } else {
            return redirect('/presensi/cuti')->with(['error' => 'Terjadi kesalahan!']);
        }

//        echo $tanggal;
    }
}
