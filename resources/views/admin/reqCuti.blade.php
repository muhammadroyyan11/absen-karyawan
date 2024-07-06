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
                                    <th>Tanggal Request</th>
                                    <th>Tanggal Izin</th>
                                    <th>Jenis Izin</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($data['cuti'] as $data)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->tgl_request }}</td>
                                        <td>{{ $data->tgl_izin }}</td>
                                        <td>
                                            @if($data->status == 'i')
                                                <span class="badge badge-success">Cuti</span>
                                            @else
                                                <span class="badge badge-warning">Sakit</span>
                                            @endif
                                        </td>
                                        <td>{{ $data->keterangan }}</td>
                                        <td>
                                            <center>
                                                @if($data->status_approved == 0)
                                                    <a class="btn btn-warning btn-flat btn-xs">Menunggu Approval</a>
                                                @elseif($data->status_approved == 1)
                                                    <a class="btn btn-success btn-flat btn-xs">Disetujui</a>
                                                @else
                                                    <a class="btn btn-danger btn-flat btn-xs">Ditolak</a>
                                                @endif
                                            </center>
                                        </td>

                                        <td>
                                            <button class="btn btn-primary btn-sm">Detail</button>
                                        </td>
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
