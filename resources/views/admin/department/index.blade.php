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
                            <button id="add-button" class="btn btn-success">Add Divisi</button>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered table-striped" id="departments-table">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Leader</th>
                                    <th>Action</th>
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

    <!-- Modal -->
    <div class="modal fade" id="departmentModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="form">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Department</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id">
                        <label>Nama</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        <label>Leader</label>
                        <select name="leader_id" id="leader_id" class="form-control">
                            <option value="">-- None --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="saveBtn">Simpan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection
@include('admin.department.modal')
@include('admin.department.js')
