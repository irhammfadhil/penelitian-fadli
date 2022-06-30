<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
	<meta name="csrf-token" content="{{csrf_token()}}"/>

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{asset('img/icons/icon-48x48.png')}}" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Serat</title>

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
        .kbw-signature { width: 30%; height: 200px;}
        #sig canvas{
            width: 100% !important;
            height: auto;
        }
        @media screen and (max-width: 400px) {
            .kbw-signature { width: 100%; height: 200px;}
        }
        @media only screen and (max-width: 600px) and (min-width: 400px) {
            .kbw-signature { width: 70%; height: 200px;}
        }
    </style>
</head>

<body>
	@php
		function tgl_indo($tanggal){
		$bulan = array (
		1 =>   'Januari',
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

					<h1 class="h3 mb-3">Informed Consent</h1>
					
                    <div class="md-stepper-horizontal orange">
                        <div class="md-step active col-lg-1 col-md-1" onclick="location.href='/biodata';" style="cursor: pointer;">
                        <div class="md-step-circle"><span>1</span></div>
                        <div class="md-step-title">Biodata</div>
                        <div class="md-step-bar-left"></div>
                        <div class="md-step-bar-right"></div>
                        </div>
						<div class="md-step active col-lg-1 col-md-1" onclick="location.href='/informed-consent';" style="cursor: pointer;">
                        <div class="md-step-circle"><span>2</span></div>
                        <div class="md-step-title">Informed Consent</div>
                        <div class="md-step-bar-left"></div>
                        <div class="md-step-bar-right"></div>
                        </div>
                        <div class="md-step col-lg-1 col-md-1" onclick="location.href='/foto-gigi';" style="cursor: pointer;">
                        <div class="md-step-circle"><span>3</span></div>
                        <div class="md-step-title">Foto Gigi</div>
                        <div class="md-step-bar-left"></div>
                        <div class="md-step-bar-right"></div>
                        </div>
                    </div>
					<br>
					<div class="card">
						<div class="card-body">
                            @if($biodata)
							<h3 class="card-title mb-0">Informed Consent</h3>
							<br>
							<h3 class="text-center">LEMBAR PERSETUJUAN SUBJEK PENELITIAN</h3>
							<br>
							<br>
							<b>Saya yang bertandatangan di bawah ini, </b>
							<div class="row">
								<div class="col-1">

								</div>
								<div class="col-3">
									Nama
								</div>
								<div class="col-8">
									: {{$ortu->name_ortu}}
								</div>
							</div>
							{{--<div class="row">
								<div class="col-3">
									Umur
								</div>
								<div class="col-9">
									: 
								</div>
							</div>--}}
							<div class="row">
								<div class="col-1">
									
								</div>
								<div class="col-3">
									Alamat
								</div>
								<div class="col-8">
									: {{$ortu->address}}
								</div>
							</div>
							<br>
							<b>Sebagai orang tua dari:</b>
							<div class="row">
								<div class="col-1">
									
								</div>
								<div class="col-3">
									Nama
								</div>
								<div class="col-8">
									: {{Auth::user()->name}}
								</div>
							</div>
							<div class="row">
								<div class="col-1">
									
								</div>
								<div class="col-3">
									Umur
								</div>
								<div class="col-8">
									: {{$age}} tahun
								</div>
							</div>
							<div class="row">
								<div class="col-1">
									
								</div>
								<div class="col-3">
									Alamat
								</div>
								<div class="col-8">
									: {{$ortu->address}}
								</div>
							</div>
							<br>
							Setelah mendapatkan penjelasan dan keterangan secara lengkap, menyatakan bersedia dan mengizinkan anak saya untuk melakukan pemeriksaan gigi demi kepentingan penelitian dari :
							<div class="row">
								<div class="col-1">
									
								</div>
								<div class="col-3">
									Nama
								</div>
								<div class="col-8">
									: <b>Fadli Muhammad Fathoni</b>
								</div>
							</div>
							<div class="row">
								<div class="col-1">
									
								</div>
								<div class="col-3">
									NIM
								</div>
								<div class="col-8">
									: <b>191610101125</b>
								</div>
							</div>
							<div class="row">
								<div class="col-1">
									
								</div>
								<div class="col-3">
									Fakultas
								</div>
								<div class="col-8">
									: <b>Kedokteran Gigi Universitas Jember</b>
								</div>
							</div>
							<br> 
							Dengan Judul <b>“Penilaian Indeks Kebutuhan Perawatan Gigi pada Anak Sekolah Dasar di Wilayah Argoindustri Bobbin Arjasa Melalui Aplikasi Berbasis Web”</b> dengan sebenar-benarnya tanpa ada suatu paksaan dari pihak manapun. 
							<div class="row">
								<div class="col-6">
									<br>
									Saya yang bertandatangan,
								</div>
								<div class="col-6">
									Jember, @php echo(tgl_indo(date('Y-m-d')));@endphp<br>
									Peneliti,
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									@if(Auth::user()->signature)
                                    <img src="{{asset(Auth::user()->signature)}}" class="img-fluid"> 
                                    @endif
								</div>
								<div class="col-6">
									
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									{{$ortu->name_ortu}}
								</div>
								<div class="col-6">
									<b>Fadli Muhammad Fathoni</b>
								</div>
							</div>
							<hr>
							<h5>Tandatangani Informed Consent</h5>
							<form method="POST" action="/tandatangan" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <label class="" for="">Signature:</label>
                                    <br/>
                                    <div id="sig" ></div>
                                    <br/>
                                    
                                    <textarea id="signature64" name="signed" style="display: none"></textarea>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                        <button id="clear" class="btn btn-danger btn-sm">Hapus tanda tangan</button>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                        <button class="btn btn-success">Tandatangani Informed Consent</button>
                                    </div>
                                </div>
                            </form>
                            @else
                            <h3 class="card-title mb-0">Bagian ini belum dapat diakses</h3>
                            <br>
							<h3 class="text-center">Bagian ini belum dapat diakses. Silakan isi biodata terlebih dahulu.</h3>
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
								<a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Serat</strong></a> &copy;
							</p>
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline">
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<script src="{{asset('static/js/app.js')}}"></script>
	<script type="text/javascript">
		var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
		$('#clear').click(function(e) {
			e.preventDefault();
			sig.signature('clear');
			$("#signature64").val('');
		});
	</script>
    <style>
          .required:after {
            content:" *";
            color: red;
        }
        .md-stepper-horizontal {
            display:table;
            width:100%;
            margin:0 auto;
            background-color:#FFFFFF;
            box-shadow: 0 3px 8px -6px rgba(0,0,0,.50);
        }
        .md-stepper-horizontal .md-step {
            display:table-cell;
            position:relative;
            padding:24px;
        }
        @media screen and (max-width: 750px) {
            .md-stepper-horizontal .md-step {
            display:block;
            position:relative;
            padding:24px;
            }
        }
        @media screen and (min-width: 750px) and (max-width: 1100px) {
            .md-stepper-horizontal .md-step {
            display:table-cell;
            position:relative;
            padding:8px;
            }
        }
        .md-stepper-horizontal .md-step:hover,
        .md-stepper-horizontal .md-step:active {
            background-color:rgba(0,0,0,0.04);
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
            background-color:#757575;
        }
        .md-stepper-horizontal .md-step:first-child .md-step-bar-left,
        .md-stepper-horizontal .md-step:last-child .md-step-bar-right {
            display:none;
        }
        .md-stepper-horizontal .md-step .md-step-circle {
            width:30px;
            height:30px;
            margin:0 auto;
            background-color:#999999;
            border-radius: 50%;
            text-align: center;
            line-height:30px;
            font-size: 16px;
            font-weight: 600;
            color:#FFFFFF;
        }
        .md-stepper-horizontal.green .md-step.active .md-step-circle {
            background-color:#00AE4D;
        }
        .md-stepper-horizontal.orange .md-step.active .md-step-circle {
            background-color:#F96302;
        }
        .md-stepper-horizontal .md-step.active .md-step-circle {
            background-color: rgb(33,150,243);
        }
        .md-stepper-horizontal .md-step.done .md-step-circle:before {
            font-family:'FontAwesome';
            font-weight:100;
            content: "\f00c";
        }
        .md-stepper-horizontal .md-step.done .md-step-circle *,
        .md-stepper-horizontal .md-step.editable .md-step-circle * {
            display:none;
        }
        .md-stepper-horizontal .md-step.editable .md-step-circle {
            -moz-transform: scaleX(-1);
            -o-transform: scaleX(-1);
            -webkit-transform: scaleX(-1);
            transform: scaleX(-1);
        }
        .md-stepper-horizontal .md-step.editable .md-step-circle:before {
            font-family:'FontAwesome';
            font-weight:100;
            content: "\f040";
        }
        .md-stepper-horizontal .md-step .md-step-title {
            margin-top:16px;
            font-size:16px;
            font-weight:600;
        }
        .md-stepper-horizontal .md-step .md-step-title,
        .md-stepper-horizontal .md-step .md-step-optional {
            text-align: center;
            color:rgba(0,0,0,.26);
        }
        .md-stepper-horizontal .md-step.active .md-step-title {
            font-weight: 600;
            color:rgba(0,0,0,.87);
        }
        .md-stepper-horizontal .md-step.active.done .md-step-title,
        .md-stepper-horizontal .md-step.active.editable .md-step-title {
            font-weight:600;
        }
        .md-stepper-horizontal .md-step .md-step-optional {
            font-size:12px;
        }
        .md-stepper-horizontal .md-step.active .md-step-optional {
            color:rgba(0,0,0,.54);
        }
        .md-stepper-horizontal .md-step .md-step-bar-left,
        .md-stepper-horizontal .md-step .md-step-bar-right {
            position:absolute;
            top:36px;
            height:1px;
            border-top:1px solid #DDDDDD;
        }
        .md-stepper-horizontal .md-step .md-step-bar-right {
            right:0;
            left:50%;
            margin-left:20px;
        }
        .md-stepper-horizontal .md-step .md-step-bar-left {
            left:0;
            right:50%;
            margin-right:20px;
        }
    </style>
	<script>
        $(function() {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $(function() {
                $('#kecamatan').on('change', function(){
                    let id_kecamatan = $('#kecamatan').val();
                    $.ajax({
                        type: 'POST',
                        url: "/getDesa",
                        data: {id_district: id_kecamatan},
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