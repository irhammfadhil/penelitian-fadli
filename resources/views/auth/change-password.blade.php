<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <meta name="csrf-token" content="{{csrf_token()}}" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{asset('img/icons/icon-48x48.png')}}" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <title>Simetri</title>

    <link href="{{asset('static/css/app.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{{asset('script.js')}}"></script>
    <style>
        /* Styles for signature plugin v1.2.0. */
        .kbw-signature {
            display: inline-block;
            border: 1px solid #a0a0a0;
            -ms-touch-action: none;
        }

        .kbw-signature-disabled {
            opacity: 0.35;
        }
    </style>

    <style>
        .kbw-signature {
            width: 30%;
            height: 200px;
        }

        #sig canvas {
            width: 100% !important;
            height: auto;
        }

        @media screen and (max-width: 400px) {
            .kbw-signature {
                width: 100%;
                height: 200px;
            }
        }

        @media only screen and (max-width: 600px) and (min-width: 400px) {
            .kbw-signature {
                width: 70%;
                height: 200px;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        @include('layouts.sidebar')

        <div class="main">
            @include('layouts.navbar-login')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Ubah Password</h1>
                    <div class="card">
                        <div class="card-body">
                            @if($message = Session::get('success'))
                            <div class="alert alert-success" role="alert">
                                <strong>{{$message}}</strong>
                            </div>
                            @elseif($message = Session::get('danger'))
                            <div class="alert alert-danger" role="alert">
                                <strong>{{$message}}</strong>
                            </div>
                            @endif
                            <p>Gunakan formulir ini untuk mengubah password Anda:</p>
                            <form action="/change-password" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Password Saat Ini</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Masukkan password saat ini" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Masukkan password baru (minimal 8 karakter)" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" placeholder="Masukkan kembali password baru" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Ubah Password Anda</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Simetri</strong></a> &copy; {{date('Y')}}. All rights reserved.
                            </p>
                        </div>
                        <div class="col-6 text-end">

                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{asset('static/js/app.js')}}"></script>
</body>

</html>