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

	<title>Simetri</title>

	<link href="{{asset('static/css/app.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
	<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="wrapper">
		@include('layouts.sidebar')

		<div class="main">
			@include('layouts.navbar-login')

			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Biodata dan Foto Gigi</h1>
					
                    <div class="md-stepper-horizontal orange">
                        <div class="md-step active col-lg-1 col-md-1" onclick="location.href='/biodata';" style="cursor: pointer;">
                        <div class="md-step-circle"><span>1</span></div>
                        <div class="md-step-title">Biodata</div>
                        <div class="md-step-bar-left"></div>
                        <div class="md-step-bar-right"></div>
                        </div>
						<div class="md-step col-lg-1 col-md-1" onclick="location.href='/informed-consent';" style="cursor: pointer;">
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
						<div class="md-step col-lg-1 col-md-1" onclick="location.href='/komentar';" style="cursor: pointer;">
                        <div class="md-step-circle"><span>4</span></div>
                        <div class="md-step-title">Laporan</div>
                        <div class="md-step-bar-left"></div>
                        <div class="md-step-bar-right"></div>
                        </div>
                    </div>
					<br>
					<div class="card">
						<div class="card-body">
							<h3 class="card-title mb-0">Biodata Diri</h3>
							@if($message = Session::get('success'))
                            <div class="alert alert-success" role="alert">
                                <strong>{{$message}}</strong>
                            </div>
							@elseif($message = Session::get('danger'))
								<div class="alert alert-danger" role="alert">
									<strong>{{$message}}</strong>
								</div>
							@endif
							<br>
							<form action="/biodata" method="post">
								@csrf
								@if($biodata)
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Nama</label>
											<input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" value="{{Auth::user()->name}}" placeholder="Nama anak" disabled>
										</div>
									</div>
									@if(!$biodata)
									<div class="col-lg-6">
										<label for="exampleInputEmail1">Jenis Kelamin</label>
										<select class="form-select" name="gender" id="gender" aria-label="Default select example">
											<option selected>Pilih...</option>
											<option value="Laki-laki">Laki-laki</option>
											<option value="Perempuan">Perempuan</option>
										</select>
									</div>
									@else
									<div class="col-lg-6">
										<label for="exampleInputEmail1">Jenis Kelamin</label>
										<select class="form-select" name="gender" id="gender" aria-label="Default select example">
											@foreach($gender as $g)
											@if($g == $biodata->gender)
											<option value="{{$g}}"selected>{{$g}}</option>
											@else
											<option value="{{$g}}">{{$g}}</option>
											@endif
											@endforeach
										</select>
									</div>
									@endif
								</div>
								<br>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Tempat Lahir</label>
											<input type="text" class="form-control" id="birthplace" name="birthplace" aria-describedby="emailHelp" value="{{$biodata->birth_place}}" placeholder="Tempat lahir">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Tanggal Lahir</label>
											<input class="form-control" id="birthdate" name="birthdate" aria-describedby="emailHelp" value="{{$biodata->birth_date}}" placeholder="Tanggal lahir">
										</div>
									</div>
								</div>
								{{--<div class="form-group">
									<label for="exampleInputEmail1">Nama</label>
									<input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Nama anak">
								</div>--}}
								<br>
								<label for="exampleInputEmail1">Sekolah</label>
								<select class="form-select" name="sekolah" id="sekolah" aria-label="Default select example">
									<option>Pilih...</option>
									<option value="SDN Biting 04">SDN Biting 04</option>
									<option value="SDN Candijati 01">SDN Candijati 01</option>
								</select>
								@else
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Nama</label>
											<input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" value="{{Auth::user()->name}}" placeholder="Nama anak" disabled>
										</div>
									</div>
									@if(!$biodata)
									<div class="col-lg-6">
										<label for="exampleInputEmail1">Jenis Kelamin</label>
										<select class="form-select" name="gender" id="gender" aria-label="Default select example">
											<option selected>Pilih...</option>
											<option value="Laki-laki">Laki-laki</option>
											<option value="Perempuan">Perempuan</option>
										</select>
									</div>
									@else
									<div class="col-lg-6">
										<label for="exampleInputEmail1">Jenis Kelamin</label>
										<select class="form-select" name="gender" id="gender" aria-label="Default select example">
											@foreach($gender as $g)
											@if($g == $biodata->gender)
											<option value="{{$g}}"selected>{{$g}}</option>
											@else
											<option value="{{$g}}">{{$g}}</option>
											@endif
											@endforeach
										</select>
									</div>
									@endif
								</div>
								<br>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Tempat Lahir</label>
											<input type="text" class="form-control" id="birthplace" name="birthplace" aria-describedby="emailHelp" placeholder="Tempat lahir">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Tanggal Lahir</label>
											<input type="date" class="form-control" id="birthdate" name="birthdate" aria-describedby="emailHelp" placeholder="Tanggal lahir">
										</div>
									</div>
								</div>
								{{--<div class="form-group">
									<label for="exampleInputEmail1">Nama</label>
									<input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Nama anak">
								</div>--}}
								<br>
								<label for="exampleInputEmail1">Sekolah</label>
								<select class="form-select" name="sekolah" id="sekolah" aria-label="Default select example">
									<option>Pilih...</option>
									<option value="SDN Biting 04">SDN Biting 04</option>
									<option value="SDN Candijati 01">SDN Candijati 01</option>
								</select>
								@endif
								<hr>
								<h3 class="card-title mb-0">Biodata Orang Tua</h3>
								<br>
								@if($ortu)
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Nama Orang Tua</label>
											<input type="text" class="form-control" id="name_ortu" name="name_ortu" value="{{$ortu->name_ortu}}" aria-describedby="emailHelp" placeholder="Nama orang tua">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Alamat</label>
											<input type="text" class="form-control" id="address" name="address" value="{{$ortu->address}}" aria-describedby="emailHelp" placeholder="Alamat">
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Pendidikan Terakhir</label>
											<select class="form-select" name="pendidikan_terakhir" id="pendidikan_terakhir" aria-label="Default select example">
												<option>Pilih...</option>
												<option value="TK">TK</option>
												<option value="SD">SD</option>
												<option value="SMP">SMP</option>
												<option value="SMA">SMA</option>
												<option value="Diploma 1, 2, 3">Diploma 1, 2, 3</option>
												<option value="D4/S1">D4/S1</option>
												<option value="S2">S2</option>
												<option value="S3">S3</option>
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Pekerjaan</label>
											<select class="form-select" name="pekerjaan" id="pekerjaan" aria-label="Default select example">
												<option>Pilih...</option>
												<option value="Guru/Dosen">Guru/Dosen</option>
												<option value="Petani/Nelayan">Petani/Nelayan</option>
												<option value="Wiraswasta">Wiraswasta</option>
												<option value="TNI/POLRI">TNI/POLRI</option>
												<option value="Pensiunan">Pensiunan</option>
												<option value="Pegawai Negeri">Pegawai Negeri</option>
												<option value="Pegawai BUMN/BUMD">Pegawai BUMN/BUMD</option>
												<option value="Pegawai Swasta">Pegawai Swasta</option>
												<option value="Lainnya">Lainnya</option>
											</select>
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Provinsi</label>
											<input type="text" class="form-control" id="provinsi" name="provinsi" aria-describedby="emailHelp" placeholder="Provinsi" value="Jawa Timur" disabled>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Kabupaten/Kota</label>
											<input type="text" class="form-control" id="kab" name="kab" aria-describedby="emailHelp" placeholder="Kabupaten/Kota" value="Kabupaten Jember" disabled>
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-6">
										<label for="exampleInputEmail1">Kecamatan</label>
										@if(!$ortu)
										<select class="form-select" name="kecamatan" id="kecamatan" aria-label="Default select example">
											<option value="" selected>Pilih...</option>
											@foreach($kecamatan as $k)
											<option value="{{$k->id}}">{{$k->name}}</option>
											@endforeach
										</select>
										@else
										<select class="form-select" name="kecamatan" id="kecamatan" aria-label="Default select example">
											<option value="" selected>{{$ortu->kecamatan}}</option>
											@foreach($kecamatan as $k)
											<option value="{{$k->id}}">{{$k->name}}</option>
											@endforeach
										</select>
										@endif
									</div>
									<div class="col-lg-6">
										<label for="exampleInputEmail1">Desa/Kelurahan</label>
										@if(!$ortu)
										<select class="form-select" name="desa" id="desa" aria-label="Default select example">
											<option value="" selected>Pilih...</option>
										</select>
										@else
										<select class="form-select" name="desa" id="desa" aria-label="Default select example">
											<option value="" selected>{{$ortu->desa}}</option>
										</select>
										@endif
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">RT</label>
											<input type="text" class="form-control" id="rt" name="rt" value="{{$ortu->rt}}" aria-describedby="emailHelp" placeholder="RT">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">RW</label>
											<input type="text" class="form-control" id="rw" name="rw" value="{{$ortu->rw}}" aria-describedby="emailHelp" placeholder="RW">
										</div>
									</div>
								</div>
								<br>
								<div class="form-group">
									<label for="exampleInputEmail1">No. HP</label>
									<input type="text" class="form-control" id="phone" name="phone" value="{{$ortu->phone}}" aria-describedby="emailHelp" placeholder="Nomor HP">
								</div>
								@else
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Nama Orang Tua</label>
											<input type="text" class="form-control" id="name_ortu" name="name_ortu" aria-describedby="emailHelp" placeholder="Nama orang tua">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Alamat</label>
											<input type="text" class="form-control" id="address" name="address" aria-describedby="emailHelp" placeholder="Alamat">
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Pendidikan Terakhir</label>
											<select class="form-select" name="pendidikan_terakhir" id="pendidikan_terakhir" aria-label="Default select example">
												<option>Pilih...</option>
												<option value="TK">TK</option>
												<option value="SD">SD</option>
												<option value="SMP">SMP</option>
												<option value="SMA">SMA</option>
												<option value="Diploma 1, 2, 3">Diploma 1, 2, 3</option>
												<option value="D4/S1">D4/S1</option>
												<option value="S2">S2</option>
												<option value="S3">S3</option>
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Pekerjaan</label>
											<select class="form-select" name="pekerjaan" id="pekerjaan" aria-label="Default select example">
												<option>Pilih...</option>
												<option value="Guru/Dosen">Guru/Dosen</option>
												<option value="Petani/Nelayan">Petani/Nelayan</option>
												<option value="Wiraswasta">Wiraswasta</option>
												<option value="TNI/POLRI">TNI/POLRI</option>
												<option value="Pensiunan">Pensiunan</option>
												<option value="Pegawai Negeri">Pegawai Negeri</option>
												<option value="Pegawai BUMN/BUMD">Pegawai BUMN/BUMD</option>
												<option value="Pegawai Swasta">Pegawai Swasta</option>
												<option value="Lainnya">Lainnya</option>
											</select>
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Provinsi</label>
											<input type="text" class="form-control" id="provinsi" name="provinsi" aria-describedby="emailHelp" placeholder="Provinsi" value="Jawa Timur" disabled>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Kabupaten/Kota</label>
											<input type="text" class="form-control" id="kab" name="kab" aria-describedby="emailHelp" placeholder="Kabupaten/Kota" value="Kabupaten Jember" disabled>
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-6">
										<label for="exampleInputEmail1">Kecamatan</label>
										@if(!$ortu)
										<select class="form-select" name="kecamatan" id="kecamatan" aria-label="Default select example">
											<option value="" selected>Pilih...</option>
											@foreach($kecamatan as $k)
											<option value="{{$k->id}}">{{$k->name}}</option>
											@endforeach
										</select>
										@else
										<select class="form-select" name="kecamatan" id="kecamatan" aria-label="Default select example">
											<option value="" selected>{{$ortu->kecamatan}}</option>
											@foreach($kecamatan as $k)
											<option value="{{$k->id}}">{{$k->name}}</option>
											@endforeach
										</select>
										@endif
									</div>
									<div class="col-lg-6">
										<label for="exampleInputEmail1">Desa/Kelurahan</label>
										@if(!$ortu)
										<select class="form-select" name="desa" id="desa" aria-label="Default select example">
											<option value="" selected>Pilih...</option>
										</select>
										@else
										<select class="form-select" name="desa" id="desa" aria-label="Default select example">
											<option value="" selected>{{$ortu->desa}}</option>
										</select>
										@endif
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">RT</label>
											<input type="text" class="form-control" id="rt" name="rt" aria-describedby="emailHelp" placeholder="RT">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">RW</label>
											<input type="text" class="form-control" id="rw" name="rw" aria-describedby="emailHelp" placeholder="RW">
										</div>
									</div>
								</div>
								<br>
								<div class="form-group">
									<label for="exampleInputEmail1">No. HP</label>
									<input type="text" class="form-control" id="phone" name="phone" aria-describedby="emailHelp" placeholder="Nomor HP">
								</div>
								@endif
								<br>
								<button type="submit" class="btn btn-primary">Lanjut</button>
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
								<a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Simetri</strong></a> &copy;
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
		$('#birthdate').datepicker({
            uiLibrary: 'bootstrap4',
			format: 'dd/mm/yyyy'
        });
    </script>
</body>

</html>