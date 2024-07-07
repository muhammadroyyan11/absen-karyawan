@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{Redirect::back()}}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Edit Profile</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <div class="row" style="margin-top: 60px">
        <div class="col">
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
    <form action="/presensi/{{ Auth::user()->id }}/update-profile" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col">
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <label for="">Nama</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" name="nama_lengkap"
                           placeholder="Nama Lengkap" autocomplete="off">
                </div>
            </div>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <label for="">No Hp</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->no_hp }}" name="no_hp" placeholder="No. HP" autocomplete="off">
                </div>
            </div>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
                </div>
            </div>
{{--            <div class="custom-file-upload" id="fileUpload1">--}}
{{--                <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">--}}
{{--                <label for="fileuploadInput">--}}
{{--                <span>--}}
{{--                    <strong>--}}
{{--                        <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>--}}
{{--                        <i>Tap to Upload</i>--}}
{{--                    </strong>--}}
{{--                </span>--}}
{{--                </label>--}}
{{--            </div>--}}
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <button type="submit" class="btn btn-primary btn-block">
                        <ion-icon name="refresh-outline"></ion-icon>
                        Update
                    </button>
                </div>
            </div>

            <div class="form-group boxed">
                <div class="input-wrapper">
                    <a href="/logout" class="btn btn-danger btn-block">
                        <ion-icon name="refresh-power"></ion-icon>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection
