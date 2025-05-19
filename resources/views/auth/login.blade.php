<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Mobilekit Mobile UI Kit</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="manifest" href="__manifest.json">
</head>

<body class="bg-white">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <div class="login-bg">
        <img src="{{ asset('assets/img/login/download.jpg') }}" alt="background" class="bg-image">
    </div>
    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0">

        <div class="login-form mt-1">
            <div class="section">
                <img src="{{ asset('assets/img/sample/photo/Logo JEZ Sport@2x.png') }}" alt="image" class="form-image">
            </div>
            <div class="section mt-1">
                <h1>Get Started</h1>
                <h4>LOGIN JEZ😊!</h4>
            </div>
            <div class="section mt-1 mb-5">
                @php
                    $messageWarning = Session::get('warning');
                @endphp
                @if (Session::get('warning'))
                    <div class="alert alert-outline-danger">
                        {{ $messageWarning }}
                    </div>
                @endif
                <form action="/prosesLogin" method="post">
                    @csrf
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" class="form-control" id="nik" name="nik"
                                placeholder="Id Staff">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Password">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-links mt-2">
                        <div>
                            <a href="page-register.html">Register Now</a>
                        </div>
                        <div><a href="page-forgot-password.html" class="text-muted">Forgot Password?</a></div>
                    </div>

                    <div class="form-button-group">
                        <button type="submit" class="btn btn-danger btn-block btn-lg">Log in</button>
                    </div>

                </form>
            </div>
        </div>
        <style>
            h1, h4 {
                color: white;
            }
            .login-form {
                background: rgba(255, 255, 255, 0.25);
                border-radius: 16px;
                box-shadow: 0 4px 32px 0 rgba(0,0,0,0.15);
                padding: 32px 24px 24px 24px;
                backdrop-filter: blur(6px);
            }
            .form-links a {
                color: #fff !important;
            }
            .form-links .text-muted {
                color: #fff !important;
            }
            .form-button-group .btn {
                background: #dc3545;
                color: #fff;
                border: none;
                box-shadow: none;
                border-radius: 8px;
                padding: 12px 0;
                font-size: 18px;
                font-weight: bold;
            }

            .form-button-group .btn,
            .form-button-group .btn:focus,
            .form-button-group .btn:active {
                background: #dc3545 !important;
                color: #fff !important;
                box-shadow: none !important;
                outline: none !important;
            }

            .form-button-group {
                background: transparent !important;
                box-shadow: none !important;
            }
            .login-bg {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                z-index: -1;
                overflow: hidden;
            }

            .login-bg .bg-image {
                width: 100vw;
                height: 100vh;
                object-fit: cover;
                filter: brightness(0.5);
            }

            /* Ensure background stays behind everything including the button group */
            .login-form, .login-form * {
                position: relative;
                z-index: 1;
            }


        </style>

    </div>
    <!-- * App Capsule -->



    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js') }}"></script>
    <!-- Bootstrap-->
    <script src="{{ asset('assets/js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('assets/js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <!-- jQuery Circle Progress -->
    <script src="{{ asset('assets/js/plugins/jquery-circle-progress/circle-progress.min.js') }}"></script>
    <!-- Base Js File -->
    <script src="{{ asset('assets/js/base.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('device_conflict'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: '{{ session('device_conflict') }}',
                confirmButtonColor: '#3085d6',
            });
        </script>
    @endif


</body>

</html>
