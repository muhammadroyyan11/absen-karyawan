@extends('layout.presensi')
@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{Redirect::back()}}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Cuti</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <form action="#" method="POST" enctype="multipart/form-data" style="margin-top: 60px">
        @csrf
        <div class="col">
            <div class="form-group">
                <div class="input-wrapper">
                    <label for="">Tanggal</label>
                    <input type=text name="bdate" id="bdate" class="datepicker form-control" autocomplete="off" required>
                </div>
            </div>

            <div class="form-group">
                <div class="input-wrapper">
                    <label for="">Jenis Cuti</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">-- Silahkan Pilih --</option>
                        <option value="i">Cuti</option>
                        <option value="s">Sakit</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="input-wrapper">
                    <label for="">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="10" placeholder="Keterangan"></textarea>
                </div>
            </div>

            <div class="form-group boxed">
                <div class="input-wrapper">
                    <button type="submit" class="btn btn-primary btn-block">
                        Ajukan
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('custom')
    <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd"
            });
        });

    </script>
@endpush

