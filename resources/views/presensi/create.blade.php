@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{Redirect::back()}}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Absen</div>
        <div class="right"></div>
    </div>

    <style>
        .webcam-wrapper {
            width: 100%;
            max-width: 640px;
            height: auto;
        }

        .webcam-capture {
            width: 100%;
            height: auto;
        }

        #switchCamera {
            opacity: 0.9;
            backdrop-filter: blur(4px);
        }
    </style>
@endsection

@section('content')
    <div class="row" style="margin-top: 60px">
        <div class="col">
            <input type="hidden" id="lokasi">
{{--            <button id="switchCamera" class="btn btn-outline-secondary mb-2">Ganti Kamera</button>--}}
{{--            <div class="webcam-capture"></div>--}}
            <div class="webcam-wrapper position-relative">
                <div class="webcam-capture"></div>
                <button id="switchCamera" class="btn btn-sm btn-light position-absolute d-flex align-items-center gap-1"
                        style="top: 10px; right: 10px; z-index: 10; opacity: 0.9; backdrop-filter: blur(4px);">
                    <ion-icon name="camera-reverse-outline"></ion-icon>
                    Ganti
                </button>
            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        let useFrontCamera = false;

        function startCamera() {
            Webcam.reset(); // matikan kamera sebelumnya

            Webcam.set({
                width: 640,
                height: 480,
                image_format: 'jpeg',
                jpeg_quality: 80,
                constraints: {
                    facingMode: useFrontCamera ? "user" : "environment"
                }
            });

            Webcam.attach('.webcam-capture');
        }

        // Jalankan kamera saat halaman dimuat
        startCamera();

        // Tombol ganti kamera
        document.getElementById('switchCamera').addEventListener('click', function () {
            useFrontCamera = !useFrontCamera;
            startCamera();
        });

        // Lokasi via Geolocation
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
            console.error("Lokasi tidak ditemukan atau ditolak.");
        }

        // Absen (ambil foto dan kirim)
        $('#absen').click(function (e){
            Webcam.snap(function (uri){
                var lokasi = $('#lokasi').val();
                $.ajax({
                    type: 'POST',
                    url: '/presensi/store',
                    data: {
                        _token: "{{csrf_token()}}",
                        image: uri,
                        lokasi: lokasi
                    },
                    cache: false,
                    success: function (respon){
                        var status = respon.split('|');
                        if (status[0] === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: status[1],
                                icon: 'success'
                            });
                            setTimeout(() => {
                                location.href = '/dashboard';
                            }, 3000);
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Silahkan hubungi IT',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
