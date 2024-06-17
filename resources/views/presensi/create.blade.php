@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Blank Page</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <div class="row" style="margin-top: 60px">
        <div class="col">
            <input type="hidden" id="lokasi">
            <div class="webcam-capture"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @if($data['check'] > 0)
                <button id="absen" class="btn btn-primary btn-block">
                    <ion-icon name="camera-outline"></ion-icon>
                    Absen Pulang
                </button>
            @else
                <button id="absen" class="btn btn-primary btn-block">
                    <ion-icon name="camera-outline"></ion-icon>
                    Absen Masuk
                </button>
            @endif

        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>
@endsection

@push('custom')
    <script>
        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jgep',
            jpeg_quality: 80
        });

        Webcam.attach('.webcam-capture');

        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(coordinate) {
            lokasi.value = coordinate.coords.latitude + "," + coordinate.coords.longitude;
            var map = L.map('map').setView([coordinate.coords.latitude, coordinate.coords.longitude], 18);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var marker = L.marker([coordinate.coords.latitude, coordinate.coords.longitude]).addTo(map);

            var circle = L.circle([coordinate.coords.latitude, coordinate.coords.longitude], {
                color: 'red',
                fillColor: 'rgba(11,253,0,0.13)',
                fillOpacity: 0.5,
                radius: 20
            }).addTo(map);
        }

        function errorCallback() {

        }

        $('#absen').click(function (e){
           Webcam.snap(function (uri){
               image = uri;
           });

            var lokasi = $('#lokasi').val();
            $.ajax({
                type: 'POST',
                url: '/presensi/store',
                data: {
                    _token: "{{csrf_token()}}",
                    image: image,
                    lokasi: lokasi
                },
                cache: false,
                success: function (respon){
                   // if(respon.code == 200){
                   //     Swal.fire({
                   //         title: 'Berhasil !',
                   //         text: respon.status,
                   //         icon: 'success'
                   //     });
                   //     setTimeout("location.href='/dashboard'", 3000);
                   // } else {
                   //     Swal.fire({
                   //         title: 'Error!',
                   //         text: 'Coba lakukan absen lagi',
                   //         icon: 'error',
                   //         confirmButtonText: 'OK'
                   //     });
                   // }
                }
            });
           //  console.log('tes');
        });
    </script>
@endpush
