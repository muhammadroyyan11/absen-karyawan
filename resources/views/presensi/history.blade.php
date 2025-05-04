@extends('layout.presensi')
@section('header')
    @pushonce('css')
        <!-- FullCalendar CSS -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet"/>
    @endpushonce
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

    <!-- Kalender -->
        <div class="row mt-4">
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Kalender Presensi
                    </div>
                    <div class="card-body p-2">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk Detail Presensi -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail Presensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Data detail akan dimuat di sini -->
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('custom')
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        {{--$(function () {--}}
        {{--    $('#cari').click(function (e) {--}}
        {{--        let bulan = $('#bulan').val();--}}
        {{--        let tahun = $('#tahun').val();--}}
        {{--        $.ajax({--}}
        {{--            type: 'POST',--}}
        {{--            url: '/get-history',--}}
        {{--            data: {--}}
        {{--                _token: '{{ csrf_token() }}',--}}
        {{--                bulan: bulan,--}}
        {{--                tahun: tahun--}}
        {{--            },--}}
        {{--            cache: false,--}}
        {{--            success: function (respond) {--}}
        {{--                console.log(respond);--}}
        {{--                $('#showHistory').html(respond)--}}
        {{--            }--}}
        {{--        })--}}
        {{--    })--}}
        {{--});--}}

        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');

            // Inisialisasi kalender
            // let calendar = new FullCalendar.Calendar(calendarEl, {
            //     initialView: 'dayGridMonth',
            //     headerToolbar: {
            //         left: 'prev,next today',
            //         center: 'title',
            //         right: ''
            //     },
            //     eventDidMount: function(info) {
            //         // Gunakan HTML biar newline tampil rapi
            //         info.el.querySelector('.fc-event-title').innerHTML = info.event.title.replace(/\n/g, '<br>');
            //     }
            // });

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                events: [], // Data event akan dimuat di sini
                eventClick: function(info) {
                    // Mendapatkan tanggal yang diklik
                    let eventDate = info.event.start.toISOString().split('T')[0]; // Format 'YYYY-MM-DD'

                    // Mengambil data presensi dari server berdasarkan tanggal
                    $.ajax({
                        type: 'POST',
                        url: '/get-presensi-detail',  // Ganti dengan URL yang sesuai untuk mengambil detail
                        data: {
                            _token: '{{ csrf_token() }}',
                            date: eventDate  // Mengirimkan tanggal yang diklik
                        },
                        success: function(response) {
                            // Menampilkan data dalam modal atau div lain
                            $('#detailModal .modal-body').html(response);  // Misal menampilkan detail di modal
                            $('#detailModal').modal('show');  // Menampilkan modal
                        },
                        error: function() {
                            alert('Gagal memuat data presensi');
                        }
                    });
                }
            });

            calendar.render();

            // Fungsi ambil data berdasarkan bulan & tahun
            $('#cari').click(function () {
                let bulan = $('#bulan').val();
                let tahun = $('#tahun').val();

                if (bulan && tahun) {
                    $.ajax({
                        type: 'POST',
                        url: '/get-history-calendar',
                        data: {
                            _token: '{{ csrf_token() }}',
                            bulan: bulan,
                            tahun: tahun
                        },
                        success: function (response) {
                            calendar.removeAllEvents();
                            calendar.addEventSource(response);
                        },
                        error: function () {
                            alert('Gagal memuat data history');
                        }
                    });
                } else {
                    alert("Pilih bulan dan tahun terlebih dahulu.");
                }
            });
        });
    </script>
@endpush
