@extends('layout.admin.admin')

@section('admin-contents')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Detail Shift
                <small>edit detail shift</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Shift</a></li>
                <li class="active">Detail Shift</li>
            </ol>
        </section>

        <style>
            .days-shifts {
                margin-top: 15px;
            }
        </style>


        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="kantor">Name Shift</label>
                                <input type="text" id="kantor" class="form-control" value="{{ $shift->name_shift }}"
                                       disabled>
                                <input type="hidden" id="shift_id" name="shift_id" class="form-control" value="{{ $shift->shift_id }}"disabled>

                            </div>


                            <div class="form-group">
                                <label for="kantor">Type Shift</label>
                                <input type="text" id="kantor" class="form-control" value="{{ $shift->name }}" disabled>
                            </div>

                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <label class="box-title">Jam Kerja</label>
                                </div>
                                @php
                                    $allDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                @endphp

                                <div class="box-body">
                                    @foreach ($allDays as $day)
                                        @php
                                            $shift = $dayShifts->firstWhere('name_day_shift', $day);
                                        @endphp
                                        <div class="row align-items-center mb-2 days-shifts" data-shift-id="{{ $shift ? $shift->id : '' }}" data-day="{{ $day }}">

                                            <div class="col-xs-3">
                                                <select class="form-control day-select" disabled>
                                                    <option selected>{{ $day }}</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-3">
                                                <input type="time" class="form-control time-start" value="{{ $shift ? \Carbon\Carbon::parse($shift->time_start)->format('H:i') : '' }}" >
                                            </div>
                                            <div class="col-xs-3">
                                                <input type="time" class="form-control time-end" value="{{ $shift ? \Carbon\Carbon::parse($shift->time_end)->format('H:i') : '' }}" >
                                            </div>
                                            <div class="col-xs-3">
                                                @if ($shift)
                                                    <button type="button" class="btn btn-danger btn-remove">X</button>
                                                @else
                                                    <button type="button" class="btn btn-secondary btn-remove" disabled>X</button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
    </div>

    @include('admin.shift.modal')

@endsection

@include('admin.shift.js')

