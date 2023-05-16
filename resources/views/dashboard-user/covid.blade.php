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
    @php
    function tgl_indo($tanggal){
    $bulan = array (
    1 => 'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
    @endphp
    <div class="wrapper">
        @include('layouts.sidebar')

        <div class="main">
            @include('layouts.navbar-login')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Screening COVID-19</h1>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-0">Form Screening COVID-19</h3>
                            <h3 class="text-center">Form Screening COVID-19</h3>
                            <h5 class="text-center">Jawablah pertanyaan di bawah ini dengan keadaan Anda yang sebenarnya.</h5>
                            <form action="/screening-covid" method="post">
                                @csrf
                                @if(!$screening)
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Apakah Anda sedang Demam atau riwayat demam >38°c?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_demam" id="is_demam" value="1">
                                        <label class="form-check-label" for="is_demam">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_demam" id="is_demam" value="0">
                                        <label class="form-check-label" for="is_demam">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Apakah Anda sedang Batuk / pilek / nyeri tenggorokan/tidak bisa mencium?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_batuk" id="is_batuk" value="1">
                                        <label class="form-check-label" for="is_batuk">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_batuk" id="is_batuk" value="0">
                                        <label class="form-check-label" for="is_batuk">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Apakah Anda sedang Sesak napas?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_sesak" id="is_sesak" value="1">
                                        <label class="form-check-label" for="is_sesak">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_sesak" id="is_sesak" value="0">
                                        <label class="form-check-label" for="is_sesak">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Apakah Anda Memiliki riwayat perjalanan ke luar kota atau kontak dengan orang yang memiliki riwayat perjalanan ke luar kota dalam 14 hari terakhir?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_travel" id="is_travel" value="1">
                                        <label class="form-check-label" for="is_travel">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_travel" id="is_travel" value="0">
                                        <label class="form-check-label" for="is_travel">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Apakah Anda memiliki Riwayat kontak erat dengan kasus konfirmasi covid-19?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_close_contact" id="is_close_contact" value="1">
                                        <label class="form-check-label" for="is_close_contact">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_close_contact" id="is_close_contact" value="0">
                                        <label class="form-check-label" for="is_close_contact">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Apakah Anda Mengunjungi fasilitas kesehatan yang berhubungan dengan pasien konfirmasi COVID-19?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_health_facilities_visit" id="is_health_facilities_visit" value="1">
                                        <label class="form-check-label" for="is_health_facilities_visit">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_health_facilities_visit" id="is_health_facilities_visit" value="0">
                                        <label class="form-check-label" for="is_health_facilities_visit">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                            @else
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Apakah Anda sedang Demam atau riwayat demam >38°c?</label>
                                <div class="form-check">
                                    @if($screening->is_demam == 1)
                                    <input class="form-check-input" type="radio" name="is_demam" id="is_demam" value="1" checked>
                                    @else
                                    <input class="form-check-input" type="radio" name="is_demam" id="is_demam" value="1">
                                    @endif
                                    <label class="form-check-label" for="is_demam">
                                        Ya
                                    </label>
                                </div>
                                <div class="form-check">
                                    @if($screening->is_demam == 0)
                                    <input class="form-check-input" type="radio" name="is_demam" id="is_demam" value="0" checked>
                                    @else
                                    <input class="form-check-input" type="radio" name="is_demam" id="is_demam" value="0">
                                    @endif
                                    <label class="form-check-label" for="is_demam">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Apakah Anda sedang Batuk / pilek / nyeri tenggorokan/tidak bisa mencium?</label>
                                <div class="form-check">
                                    @if($screening->is_batuk == 1)
                                    <input class="form-check-input" type="radio" name="is_batuk" id="is_batuk" value="1" checked>
                                    @else
                                    <input class="form-check-input" type="radio" name="is_batuk" id="is_batuk" value="1">
                                    @endif
                                    <label class="form-check-label" for="is_batuk">
                                        Ya
                                    </label>
                                </div>
                                <div class="form-check">
                                    @if($screening->is_batuk == 0)
                                    <input class="form-check-input" type="radio" name="is_batuk" id="is_batuk" value="0" checked>
                                    @else
                                    <input class="form-check-input" type="radio" name="is_batuk" id="is_batuk" value="0">
                                    @endif
                                    <label class="form-check-label" for="is_batuk">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Apakah Anda sedang Sesak napas?</label>
                                <div class="form-check">
                                    @if($screening->is_sesak == 1)
                                    <input class="form-check-input" type="radio" name="is_sesak" id="is_sesak" value="1" checked>
                                    @else
                                    <input class="form-check-input" type="radio" name="is_sesak" id="is_sesak" value="1">
                                    @endif
                                    <label class="form-check-label" for="is_sesak">
                                        Ya
                                    </label>
                                </div>
                                <div class="form-check">
                                    @if($screening->is_sesak == 0)
                                    <input class="form-check-input" type="radio" name="is_sesak" id="is_sesak" value="0" checked>
                                    @else
                                    <input class="form-check-input" type="radio" name="is_sesak" id="is_sesak" value="0">
                                    @endif
                                    <label class="form-check-label" for="is_sesak">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Apakah Anda Memiliki riwayat perjalanan ke luar kota atau kontak dengan orang yang memiliki riwayat perjalanan ke luar kota dalam 14 hari terakhir?</label>
                                <div class="form-check">
                                    @if($screening->is_travel == 1)
                                    <input class="form-check-input" type="radio" name="is_travel" id="is_travel" value="1" checked>
                                    @else
                                    <input class="form-check-input" type="radio" name="is_travel" id="is_travel" value="1">
                                    @endif
                                    <label class="form-check-label" for="is_travel">
                                        Ya
                                    </label>
                                </div>
                                <div class="form-check">
                                    @if($screening->is_travel == 0)
                                    <input class="form-check-input" type="radio" name="is_travel" id="is_travel" value="0" checked>
                                    @else
                                    <input class="form-check-input" type="radio" name="is_travel" id="is_travel" value="0">
                                    @endif
                                    <label class="form-check-label" for="is_travel">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Apakah Anda memiliki Riwayat kontak erat dengan kasus konfirmasi covid-19?</label>
                                <div class="form-check">
                                    @if($screening->is_close_contact == 1)
                                    <input class="form-check-input" type="radio" name="is_close_contact" id="is_close_contact" value="1" checked>
                                    @else
                                    <input class="form-check-input" type="radio" name="is_close_contact" id="is_close_contact" value="1">
                                    @endif
                                    <label class="form-check-label" for="is_close_contact">
                                        Ya
                                    </label>
                                </div>
                                <div class="form-check">
                                    @if($screening->is_close_contact == 0)
                                    <input class="form-check-input" type="radio" name="is_close_contact" id="is_close_contact" value="0" checked>
                                    @else
                                    <input class="form-check-input" type="radio" name="is_close_contact" id="is_close_contact" value="0">
                                    @endif
                                    <label class="form-check-label" for="is_close_contact">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Apakah Anda Mengunjungi fasilitas kesehatan yang berhubungan dengan pasien konfirmasi COVID-19?</label>
                                <div class="form-check">
                                    @if($screening->is_health_facilities_visit == 1)
                                    <input class="form-check-input" type="radio" name="is_health_facilities_visit" id="is_health_facilities_visit" value="1" checked>
                                    @else
                                    <input class="form-check-input" type="radio" name="is_health_facilities_visit" id="is_health_facilities_visit" value="1">
                                    @endif
                                    <label class="form-check-label" for="is_health_facilities_visit">
                                        Ya
                                    </label>
                                </div>
                                <div class="form-check">
                                    @if($screening->is_health_facilities_visit == 0)
                                    <input class="form-check-input" type="radio" name="is_health_facilities_visit" id="is_health_facilities_visit" value="0" checked>
                                    @else
                                    <input class="form-check-input" type="radio" name="is_health_facilities_visit" id="is_health_facilities_visit" value="0">
                                    @endif
                                    <label class="form-check-label" for="is_health_facilities_visit">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                            @endif
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
    <script type="text/javascript">
        var sig = $('#sig').signature({
            syncField: '#signature64',
            syncFormat: 'PNG'
        });
        $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64").val('');
        });
    </script>
    <style>
        .required:after {
            content: " *";
            color: red;
        }

        .md-stepper-horizontal {
            display: table;
            width: 100%;
            margin: 0 auto;
            background-color: #FFFFFF;
            box-shadow: 0 3px 8px -6px rgba(0, 0, 0, .50);
        }

        .md-stepper-horizontal .md-step {
            display: table-cell;
            position: relative;
            padding: 24px;
        }

        @media screen and (max-width: 750px) {
            .md-stepper-horizontal .md-step {
                display: block;
                position: relative;
                padding: 24px;
            }
        }

        @media screen and (min-width: 750px) and (max-width: 1100px) {
            .md-stepper-horizontal .md-step {
                display: table-cell;
                position: relative;
                padding: 8px;
            }
        }

        .md-stepper-horizontal .md-step:hover,
        .md-stepper-horizontal .md-step:active {
            background-color: rgba(0, 0, 0, 0.04);
        }

        .md-stepper-horizontal .md-step:active {
            border-radius: 15% / 75%;
        }

        .md-stepper-horizontal .md-step:first-child:active {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .md-stepper-horizontal .md-step:last-child:active {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .md-stepper-horizontal .md-step:hover .md-step-circle {
            background-color: #757575;
        }

        .md-stepper-horizontal .md-step:first-child .md-step-bar-left,
        .md-stepper-horizontal .md-step:last-child .md-step-bar-right {
            display: none;
        }

        .md-stepper-horizontal .md-step .md-step-circle {
            width: 30px;
            height: 30px;
            margin: 0 auto;
            background-color: #999999;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-size: 16px;
            font-weight: 600;
            color: #FFFFFF;
        }

        .md-stepper-horizontal.green .md-step.active .md-step-circle {
            background-color: #00AE4D;
        }

        .md-stepper-horizontal.orange .md-step.active .md-step-circle {
            background-color: #F96302;
        }

        .md-stepper-horizontal .md-step.active .md-step-circle {
            background-color: rgb(33, 150, 243);
        }

        .md-stepper-horizontal .md-step.done .md-step-circle:before {
            font-family: 'FontAwesome';
            font-weight: 100;
            content: "\f00c";
        }

        .md-stepper-horizontal .md-step.done .md-step-circle *,
        .md-stepper-horizontal .md-step.editable .md-step-circle * {
            display: none;
        }

        .md-stepper-horizontal .md-step.editable .md-step-circle {
            -moz-transform: scaleX(-1);
            -o-transform: scaleX(-1);
            -webkit-transform: scaleX(-1);
            transform: scaleX(-1);
        }

        .md-stepper-horizontal .md-step.editable .md-step-circle:before {
            font-family: 'FontAwesome';
            font-weight: 100;
            content: "\f040";
        }

        .md-stepper-horizontal .md-step .md-step-title {
            margin-top: 16px;
            font-size: 16px;
            font-weight: 600;
        }

        .md-stepper-horizontal .md-step .md-step-title,
        .md-stepper-horizontal .md-step .md-step-optional {
            text-align: center;
            color: rgba(0, 0, 0, .26);
        }

        .md-stepper-horizontal .md-step.active .md-step-title {
            font-weight: 600;
            color: rgba(0, 0, 0, .87);
        }

        .md-stepper-horizontal .md-step.active.done .md-step-title,
        .md-stepper-horizontal .md-step.active.editable .md-step-title {
            font-weight: 600;
        }

        .md-stepper-horizontal .md-step .md-step-optional {
            font-size: 12px;
        }

        .md-stepper-horizontal .md-step.active .md-step-optional {
            color: rgba(0, 0, 0, .54);
        }

        .md-stepper-horizontal .md-step .md-step-bar-left,
        .md-stepper-horizontal .md-step .md-step-bar-right {
            position: absolute;
            top: 36px;
            height: 1px;
            border-top: 1px solid #DDDDDD;
        }

        .md-stepper-horizontal .md-step .md-step-bar-right {
            right: 0;
            left: 50%;
            margin-left: 20px;
        }

        .md-stepper-horizontal .md-step .md-step-bar-left {
            left: 0;
            right: 50%;
            margin-right: 20px;
        }
    </style>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(function() {
                $('#kecamatan').on('change', function() {
                    let id_kecamatan = $('#kecamatan').val();
                    $.ajax({
                        type: 'POST',
                        url: "/getDesa",
                        data: {
                            id_district: id_kecamatan
                        },
                        cache: false,
                        success: function(msg) {
                            $('#desa').html(msg);
                        },
                        error: function(data) {
                            console.log('error:', data);
                        },
                    });
                });
            });
        });
    </script>
</body>

</html>