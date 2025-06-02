@extends('layout.presensi')
@section('content')
    <div class="section" id="user-section">
        <div id="user-detail" class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="avatar">
                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                </div>
                <div id="user-info" class="ms-2">
                    <h3 id="user-name">{{ Auth::user()->name }}</h3>
                    <span id="user-role">{{ Auth::user()->jabatan }}</span>
                </div>
            </div>
            {{--            <button class="btn btn-warning rounded-pill px-4">Rest</button>--}}
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="#" class="green" style="font-size: 40px;" data-bs-toggle="modal" data-bs-target="#modalIstirahat">
                                <ion-icon name="time"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Istirahat</span><br>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/jadwal" class="orange" style="font-size: 40px;">
                                <ion-icon name="calendar"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Jadwal Kerja
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning text-center" role="alert">
                        @if($data['shift'] != NULL)
                            <h4 class="presencetitle"><b>Besok kamu {{ $data['shift'] }} </b> - Jangan terlambat ya</h4>
                        @else
                            <h4 class="presencetitle">Jadwal belum di setting , Hubungi leader ya!</h4>
                        @endif

                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if($data['presensiHarian'] && $data['presensiHarian']->foto_in)
                                        <img
                                            src="{{ asset(Storage::url('uploads/absensi/' . $data['presensiHarian']->foto_in)) }}"
                                            class="imaged w64">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>

                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ $data['presensiHarian']  != null ? $data['presensiHarian']->jam_in : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if($data['presensiHarian'] && $data['presensiHarian']->foto_out)
                                        <img
                                            src="{{ asset(Storage::url('uploads/absensi/' . $data['presensiHarian']->foto_out)) }}"
                                            class="imaged w64">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>{{ $data['presensiHarian']  != null &&  $data['presensiHarian']->jam_out != null ? $data['presensiHarian']->jam_out : 'Belum Absen Pulang' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="rekappresence">
            <h3>Rekap Presensi Bulan Ini</h3>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px !important;">
                            <span class="badge badge-danger"
                                  style="position: absolute; top: 3px; right: 20px; font-size: 0.6rem; ">{{$data['hadir']->jmlhadir}}</span>
                            <ion-icon name="accessibility-outline" style="font-size: 1.6rem;"
                                      class="text-primary"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem">Kehadiran</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px !important;">
                            <span class="badge badge-danger"
                                  style="position: absolute; top: 3px; right: 20px; font-size: 0.6rem; ">{{$data['cuti']->jmlcuti}}</span>
                            <ion-icon name="newspaper-outline" style="font-size: 1.6rem;"
                                      class="text-success"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem">Cuti</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px !important;">
                            <span class="badge badge-danger"
                                  style="position: absolute; top: 3px; right: 20px; font-size: 0.6rem; ">{{$data['sakit']->jmlsakit}}</span>
                            <ion-icon name="medkit-outline" style="font-size: 1.6rem;" class="text-warning"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem">Sakit</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px !important;">
                            <span class="badge badge-danger"
                                  style="position: absolute; top: 3px; right: 20px; font-size: 0.6rem; ">{{$data['hadir']->jmltelat}}</span>
                            <ion-icon name="time-outline" style="font-size: 1.6rem;" class="text-danger"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem">Terlambat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Absensi Terlambat
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach($data['history'] as $d)
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="finger-print-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{ \Carbon\Carbon::parse($d->tgl_presensi)->locale('id')->translatedFormat('d F Y') }}</div>
                                        <div>
                                            <span class="badge badge-success">{{ $d->jam_in  }}</span>
                                            <span
                                                class="badge badge-danger">{{ $d->jam_out != null ? $d->jam_out : 'Belum absen' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach($data['terlambat'] as $d)
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-danger">
                                        <ion-icon name="finger-print-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{ \Carbon\Carbon::parse($d->tgl_presensi)->locale('id')->translatedFormat('d F Y') }}</div>
                                        <div>
                                            <span class="badge badge-danger">{{ $d->jam_in  }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>




    <!-- Modal Istirahat -->
    <div class="modal fade" id="modalIstirahat" tabindex="-1" aria-labelledby="modalIstirahatLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalIstirahatLabel">Status Istirahat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Apakah Anda ingin memulai istirahat sekarang?</p>
                    <button class="btn btn-success me-2">Mulai Istirahat</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('dashboard.dashboard_js')


