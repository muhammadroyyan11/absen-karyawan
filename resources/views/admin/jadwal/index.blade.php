@extends('layout.admin.admin')

@section('admin-contents')

    <style>
        #date_range {
            background-color: #fff;
            cursor: pointer;
        }

        .daterangepicker td.active,
        .daterangepicker td.active:hover {
            background-color: #3c8dbc !important;
        }

        .daterangepicker .ranges li.active {
            background-color: #3c8dbc !important;
            color: white;
        }

        .daterangepicker .calendar-table th,
        .daterangepicker .calendar-table td {
            padding: 8px;
        }
    </style>

    <!-- Date Range Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $data['title'] }}
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">{{ $data['title'] }}</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-primary" id="openTemplateModal">
                                        <i class="fa fa-file-excel-o"></i> Generate Template Jadwal
                                    </button>
                                    <button class="btn btn-success" id="openImportModal">
                                        <i class="fa fa-upload"></i> Import Jadwal
                                    </button>
                                </div>
                            </div>
                            <hr>

                            <!-- Filter Divisi dan Date Range -->
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-3">
                                    <select id="filterDivisi" class="form-control select2" style="width: 100%;">
                                        <option value="">-- Pilih Divisi --</option>
                                        @foreach($data['department'] as $d)
                                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                                        @endforeach
                                        <!-- Tambahkan opsi divisi lain sesuai data -->
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="date_range" class="form-control"
                                           placeholder="Pilih Rentang Tanggal" readonly>
                                </div>
                            </div>

                        </div>

                        <div class="box-body table-responsive">
                            <table id="jadwalData" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th  style="min-width: 300px;">Nama</th>
                                    <th>Department</th>
                                    <th>Tanggal Shift</th>
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
