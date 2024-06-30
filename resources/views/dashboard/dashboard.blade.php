@extends('layout.presensi')
@section('content')
    <div class="section" id="user-section">
        <div id="user-detail">
            <div class="avatar">
                <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
            </div>
            <div id="user-info">
                <h3 id="user-name">{{ Auth::user()->name }}</h3>
                <span id="user-role">{{ Auth::user()->jabatan }}</span>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
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
                            <a href="" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if($data['presensiHarian'] != null)
                                        @php
                                            $path = \Illuminate\Support\Facades\Storage::url('uploads/absensi/'.$data['presensiHarian']->foto_in);
                                        @endphp
                                        <img src="{{ url($path) }}" class="imaged w64">
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
                                    @if($data['presensiHarian'] != null && $data['presensiHarian']->jam_out != null)
                                        @php
                                            $path = \Illuminate\Support\Facades\Storage::url('uploads/absensi/'.$data['presensiHarian']->foto_out);
                                        @endphp
                                        <img src="{{ url($path) }}" class="imaged w64">
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
                                  style="position: absolute; top: 3px; right: 20px; font-size: 0.6rem; ">0</span>
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
                                  style="position: absolute; top: 3px; right: 20px; font-size: 0.6rem; ">0</span>
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
@endsection
