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
                                <div class="col-md-6">
                                    <button class="btn btn-primary" id="openTemplateModal">
                                        <i class="fa fa-file-excel-o"></i> Generate Template Jadwal
                                    </button>
                                    <button class="btn btn-success" id="openImportModal">
                                        <i class="fa fa-upload"></i> Import Jadwal
                                    </button>
                                </div>

                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="jadwalData" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal Absen</th>
                                    <th>Shift Input</th>
                                    <th>Absen Datang</th>
                                    <th>Absen Pulang</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
    </div>

    @include('admin.jadwal.modal')
    @include('admin.jadwal.js')

@endsection
