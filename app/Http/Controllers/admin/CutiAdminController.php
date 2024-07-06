<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CutiAdminController extends Controller
{
    public function index()
    {
        $bulan      = date('m');
        $tahun      = date('Y');

        $dataizin = DB::table('pengajuan_cuti as t1')
            ->select('t2.name', 't1.tgl_izin', 't1.status', 't1.keterangan', 't1.status_approved', 't1.created_at as tgl_request')
            ->join('users as t2', 't2.id', '=', 't1.u_id')
            ->where('status_approved', '=', '0')
            ->whereRaw('MONTH(t1.created_at)="'. $bulan .'"')
            ->whereRaw('YEAR(t1.created_at)="'. $tahun .'"')
            ->orderBy('tgl_izin', 'asc')
            ->get();


        $data = [
            'title'     => 'Data Cuti',
            'cuti'   => $dataizin
        ];

//        dd($dataizin);
        return view('admin.reqCuti', compact('data'));
    }

    public function history()
    {
        $dataizin = DB::table('pengajuan_cuti as t1')
            ->select('t2.name', 't1.tgl_izin', 't1.status', 't1.keterangan', 't1.status_approved', 't1.created_at as tgl_request')
            ->join('users as t2', 't2.id', '=', 't1.u_id')
            ->orderBy('t1.tgl_izin', 'asc')
            ->get();

        $data = [
            'title'     => 'Data Cuti',
            'cuti'      => $dataizin
        ];

//        dd($dataizin);
        return view('admin.reqCuti', compact('data'));
    }
}
