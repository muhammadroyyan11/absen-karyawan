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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Set konfigurasi awal Webcam dengan kamera belakang (mobile-friendly)
        Webcam.set({
            width: 640,
            height: 480,
            image_format: 'jpeg',
            jpeg_quality: 80,
            constraints: {
                facingMode: "environment" // Gunakan kamera belakang jika tersedia
            }
        });

        Webcam.on('error', function(err) {
            console.error("Webcam error:", err);
        });

        // Attach kamera ke div
        Webcam.attach('.webcam-capture');

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

        // Ambil dan kirim foto serta lokasi saat tombol diklik
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
