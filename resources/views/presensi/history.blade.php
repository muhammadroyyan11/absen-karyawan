@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{Redirect::back()}}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">History</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">-- Pilih Bulan --</option>
                            @for($i=1; $i<=12; $i++)
                                <option
                                    value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>{{ $namabulan[$i] }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">-- Pilih Tahun --</option>
                            @php
                                $tahunmulai = 2023;
                                $tahunskrg  = date('Y');
                            @endphp
                            @for($tahun=$tahunmulai; $tahun <= $tahunskrg; $tahun++)
                                <option
                                    value="{{ $tahun }}" {{ date('Y') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" id="cari">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col" id="showHistory"></div>
    </div>
@endsection

@push('custom')
    <script>
        $(function () {
            $('#cari').click(function (e) {
                let bulan = $('#bulan').val();
                let tahun = $('#tahun').val();
                $.ajax({
                    type: 'POST',
                    url: '/get-history',
                    data: {
                        _token: '{{ csrf_token() }}',
                        bulan: bulan,
                        tahun: tahun
                    },
                    cache: false,
                    success: function (respond) {
                        console.log(respond);
                        $('#showHistory').html(respond)
                    }
                })
            })
        })
    </script>
@endpush
