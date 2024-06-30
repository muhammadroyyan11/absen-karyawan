@extends('layout.presensi')
@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <style>
        .datepicker-modal {
            max-height: 430px !important;
        }

        .datepicker-date-display {
            background-color: #3373d2 !important;
        }
    </style>
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
    <form method="POST" action="/presensi/cuti/store" id="form-cuti"  style="margin-top: 60px">
        @csrf
        <div class="col">
            <div class="form-group">
                <div class="input-wrapper">
                    <label for="">Tanggal</label>
                    <input type=text name="tanggal" id="tanggal" class="datepicker form-control" autocomplete="off">
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
                    <button class="btn btn-primary btn-block">
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

            $('#form-cuti').submit(function (){
                var tgl_izin = $('#tanggal').val()
                var status = $('#status').val()
                var keterangan = $('#keterangan').val()

                if (tgl_izin == ''){
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Tanggal Harus Di Isi',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                } else if(status == ''){
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Status Harus Di Pilih',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                } else if(keterangan == ''){
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Keterangan Harus Di Isi',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }
                {{--else {--}}
                {{--    $.ajax({--}}
                {{--        type: 'POST',--}}
                {{--        url: '/presensi/cuti/store',--}}
                {{--        data: {--}}
                {{--            _token: '{{ csrf_token() }}',--}}
                {{--            tanggal: tgl_izin,--}}
                {{--            status: status,--}}
                {{--            keterangan: keterangan,--}}

                {{--        },--}}
                {{--        cache: false,--}}
                {{--        success: function (respond) {--}}
                {{--            console.log(respond);--}}
                {{--            $('#showHistory').html(respond)--}}
                {{--        }--}}
                {{--    });--}}
                {{--}--}}
            });


        });


    </script>
@endpush

