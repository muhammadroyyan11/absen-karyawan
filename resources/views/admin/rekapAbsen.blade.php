@extends('layout.admin.admin')

@section('admin-contents')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Data Tables
                <small>advanced tables</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Tables</a></li>
                <li class="active">Data tables</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Table With Full Features</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal Absen</th>
                                    <th>Absen Datang</th>
                                    <th>Absen Pulang</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($data['history'] as $data)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->tgl_presensi }}</td>
                                        <td>{{ $data->jam_in }}</td>
                                        <td>{{ $data->jam_out }}</td>
                                        <td>
                                            @if($data->jam_in > '08:00:00')
                                                <p class="text-red">Terlambat</p>
                                            @else
                                                <p class="text-green">Tepat Waktu</p>
                                            @endif
                                        </td>
                                        <td><button class="btn btn-primary btn-sm">Detail</button></td>
                                    </tr>
                                @endforeach


                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
    </div>

@endsection
