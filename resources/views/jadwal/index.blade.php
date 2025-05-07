@extends('layout.presensi')
@section('header')
    @pushonce('css')
        <!-- FullCalendar CSS -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @endpushonce
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{Redirect::back()}}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Jadwal Kerja</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <style>
        /* Styling untuk card presensi */
        .presensi-card {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        /* Styling untuk tabel presensi */
        .presensi-table th {
            width: 150px;
            font-weight: bold;
            padding-right: 10px;
        }

        .presensi-table td {
            padding-left: 10px;
        }

        /* Styling untuk foto */
        .foto-presensi {
            cursor: pointer;
            border-radius: 5px;
        }

        /* Styling untuk container map */
        .maps-container {
            margin-top: 20px;
        }

        /* Styling untuk peta */
        .map {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Styling untuk heading peta */
        .maps-container h5 {
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }
    </style>
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <div class="row">

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
                    Kalender Kerja
                </div>
                <div class="card-body p-2">
                    <div id="calendar-jadwal"></div>

                    <!-- Hint Keterangan -->
                    <div class="mt-3">
                        <h6>Keterangan:</h6>
    {{--                        <ul class="list-unstyled mb-0">--}}
    {{--                            <li class="mb-1">--}}
    {{--                                <span class="badge bg-success d-inline-block me-2" style="width: 20px; height: 20px;">&nbsp;</span>--}}
    {{--                                Jam Masuk--}}
    {{--                            </li>--}}
    {{--                            <li class="mb-1">--}}
    {{--                                <span class="badge bg-danger d-inline-block me-2" style="width: 20px; height: 20px;">&nbsp;</span>--}}
    {{--                                Jam Keluar--}}
    {{--                            </li>--}}
    {{--                            <li class="mb-1">--}}
    {{--                                <span class="badge bg-warning d-inline-block me-2" style="width: 20px; height: 20px;">&nbsp;</span>--}}
    {{--                                Tidak Masuk--}}
    {{--                            </li>--}}
    {{--                        </ul>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Presensi -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Presensi</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>

                <!-- Modal Footer (opsional) -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('custom')
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar-jadwal');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                events: {
                    url: '/get-jadwal-calendar',
                    method: 'POST',
                    extraParams: {
                        _token: '{{ csrf_token() }}'
                    },
                    failure: function () {
                        alert('Gagal memuat jadwal');
                    }
                },
                eventDidMount: function (info) {
                    // Optional: tooltip
                    if (info.event.extendedProps.description) {
                        info.el.setAttribute('title', info.event.extendedProps.description);
                    }
                }
            });

            calendar.render();
        });

        $(document).on('click', '.foto-presensi', function () {
            let src = $(this).attr('src');
            $('#imgModal').attr('src', src);
            const modal = new bootstrap.Modal(document.getElementById('modalFoto'));
            modal.show();
        });

        function showLeafletMap(locationIn, locationOut, itemId) {
            if (locationIn) {
                let [lat, lng] = locationIn.split(',');
                let mapIn = L.map('mapIn' + itemId).setView([lat, lng], 18);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19
                }).addTo(mapIn);
                L.marker([lat, lng]).addTo(mapIn);
            }

            if (locationOut) {
                let [lat, lng] = locationOut.split(',');
                let mapOut = L.map('mapOut' + itemId).setView([lat, lng], 18);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19
                }).addTo(mapOut);
                L.marker([lat, lng]).addTo(mapOut);
            }
        }

    </script>
@endpush
