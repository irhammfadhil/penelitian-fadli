<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login SIMETRI</title>
    @include('layouts.header')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{asset('auth/images/icons/favicon.ico')}}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('auth/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('auth/vendor/animate/animate.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('auth/vendor/css-hamburgers/hamburgers.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('auth/vendor/animsition/css/animsition.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('auth/vendor/select2/select2.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('auth/vendor/daterangepicker/daterangepicker.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('auth/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('auth/css/main.css')}}">
    <!--===============================================================================================-->
</head>

<body>
    @include('layouts.navbar')

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-form-title" style="background-image: url(Picture1.png);">
                    <span class="login100-form-title-1">
                        Sign In
                    </span>
                </div>

                <br>

                @if($message = Session::get('danger'))
                <div class="alert alert-danger" role="alert">
                    <strong>{{$message}}</strong>
                </div>
                @elseif($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    <strong>{{$message}}</strong>
                </div>
                @endif

                <form action="/login" method="post" class="login100-form validate-form" enctype="multipart/form-data">
                    @csrf
                    <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                        <span class="label-input100">Username</span>
                        <input type="text" name="email" id="email" class="input100" placeholder="Nama Pengguna" required />
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 validate-input m-b-26" data-validate="Password is required">
                        <span class="label-input100">Password</span>
                        <input type="password" name="password" id="password" class="input100" placeholder="Password" required />
                        <span class="focus-input100"></span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block" style="background-color: #1d443f;">
                        Login
                    </button>
                </form>
                <div class="closing">
                    <p class="small fw-bold mt-2 pt-1 mb-0 text-center txt1">Belum mempunyai akun? <a href="/register" class="link-danger">Daftar sekarang.</a></p>
                    <p class="small fw-bold mt-2 pt-1 mb-0 text-center txt1"><a href="/forget-password" class="link-danger">Lupa Password?</a></p>
                </div>
                <br>
            </div>
        </div>
    </div>

    <style>
        .closing {
            margin-top: -70px;
        }

        @media screen and (max-width: 800px) {
            .closing {
                margin-top: -50px;
            }
        }
    </style>

    <!--===============================================================================================-->
    <script src="{{asset('auth/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
    <!--===============================================================================================-->
    <script src="{{asset('auth/vendor/animsition/js/animsition.min.js')}}"></script>
    <!--===============================================================================================-->
    <script src="{{asset('auth/vendor/bootstrap/js/popper.js')}}"></script>
    <script src="{{asset('auth/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <!--===============================================================================================-->
    <script src="{{asset('auth/vendor/select2/select2.min.js')}}"></script>
    <!--===============================================================================================-->
    <script src="{{asset('auth/vendor/daterangepicker/moment.min.js')}}"></script>
    <script src="{{asset('auth/vendor/daterangepicker/daterangepicker.js')}}"></script>
    <!--===============================================================================================-->
    <script src="{{asset('auth/vendor/countdowntime/countdowntime.js')}}"></script>
    <!--===============================================================================================-->
    <script src="{{asset('auth/js/main.js')}}"></script>
    <!-- Vendor JS Files -->
    <script src="{{asset('assets/vendor/aos/aos.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{asset('assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('assets/js/main.js')}}"></script>

</body>

</html>