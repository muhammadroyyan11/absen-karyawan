@extends('layout.presensi')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{ Redirect::back() }}" class="headerButton goBack">
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
            <div class="webcam-wrapper position-relative">
                <div class="webcam-capture"></div>
                <button id="switchCamera"
                        class="btn btn-sm btn-light position-absolute d-flex align-items-center gap-1"
                        style="top: 10px; right: 10px; z-index: 10;">
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

    <!-- Loading overlay -->
    <div id="loadingOverlay" style="display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.4);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;">
        <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden"></span>
        </div>
    </div>
@endsection

@push('custom')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-o9N1j7kC1b8zX+0p06gC1xkz+uYnEutP3pZCk2W0Xqo="
            crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-sA+4jvibvVVjwlTlU2d+xvAqaaKYF7dLndpk+z4gD3I="
          crossorigin=""/>

    <script>
        let useFrontCamera = false;
        let cameraReady = false;

        function startCamera() {
            $('#loadingOverlay').show();
            cameraReady = false;
            Webcam.reset();
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

            // Wait for camera live event
            Webcam.on('live', function () {
                cameraReady = true;
                $('#loadingOverlay').hide();
            });
        }

        // Start camera on page load
        startCamera();

        // Switch camera
        document.getElementById('switchCamera').addEventListener('click', function () {
            useFrontCamera = !useFrontCamera;
            startCamera();
        });

        // Ambil lokasi
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

            L.marker([coordinate.coords.latitude, coordinate.coords.longitude]).addTo(map);
            L.circle([coordinate.coords.latitude, coordinate.coords.longitude], {
                color: 'red',
                fillColor: 'rgba(11,253,0,0.13)',
                fillOpacity: 0.5,
                radius: 20
            }).addTo(map);
        }

        function errorCallback() {
            console.error("Lokasi tidak ditemukan.");
        }

        // Tombol Absen
        $('#absen').click(function (e) {
            if (!cameraReady) {
                Swal.fire({
                    title: 'Kamera belum siap',
                    text: 'Mohon tunggu beberapa detik...',
                    icon: 'info'
                });
                return;
            }

            $('#loadingOverlay').show();

            Webcam.snap(function (uri) {
                var lokasi = $('#lokasi').val();
                $.ajax({
                    type: 'POST',
                    url: '/presensi/store',
                    data: {
                        _token: "{{ csrf_token() }}",
                        image: uri,
                        lokasi: lokasi
                    },
                    cache: false,
                    success: function (respon) {
                        $('#loadingOverlay').hide();
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
                    },
                    error: function () {
                        $('#loadingOverlay').hide();
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan jaringan.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endpush
