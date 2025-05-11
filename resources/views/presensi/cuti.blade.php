@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{Redirect::back()}}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Cuti</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <div class="row" style="margin-top: 60px">
        <div class="col">
            <p>Leave Quota: {{ $leaveQuota }} days</p>
            @php
                $messageSuccess = Session::get('success');
                $messageError = Session::get('error');
            @endphp
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{$messageSuccess}}
                </div>
            @else
                <div class="alert alert-error">
                    {{$messageError}}

                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            @foreach($dataizin as $d)
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <div class="in">
                                    <div>
                                        {{ \Carbon\Carbon::parse($d->tgl_izin)->locale('id')->translatedFormat('d F Y') }} {{ $d->status == 's' ? 'Sakit' : 'Izin' }}
                                        <small class="text-muted">{{ $d->keterangan }}</small>
                                    </div>
                                    @if($d->status_approved == 0)
                                        <span class="badge badge-warning">Menunggu Persetujuan</span>
                                    @elseif($d->status_approved == 1)
                                        <span class="badge badge-success">Disetujui</span>
                                    @elseif($d->status_approved == 2)
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif

                            </div>
                        </div>
                    </li>
                </ul>
            @endforeach
        </div>
    </div>
    <div class="fab-button bottom-right" style="margin-bottom: 70px;">
        <a href="/presensi/cuti/create" class="fab">
            <ion-icon name="add-outline"></ion-icon>
        </a>
    </div>
@endsection
