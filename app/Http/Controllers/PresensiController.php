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
            ->whereRaw('MONTH(tgl_presensi)="'. $bulan .'"')
            ->whereRaw('YEAR(tgl_presensi)="'. $tahun .'"')
            ->where('u_id', $id)
            ->orderBy('tgl_presensi', 'ASC')
            ->get();

        return view('presensi.getHistory', compact('history'));
    }

    public function cuti()
    {
        return view('presensi.cuti');
    }

    public function create_cuti()
    {
        return view('presensi.create_cuti');
    }
}
