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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		@include('layouts.sidebar')

		<div class="main">
			@include('layouts.navbar-login')

			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Detail Anak</h1>
					
					<br>
					<div class="card">
						<div class="card-body">
							<h3>Detail Anak</h3>
							<br>
							<h4>Informasi Pribadi</h4>
							<div class="row">
								<div class="col-lg-6">Nama</div>
								<div class="col-lg-6">: {{$user->name}}</div>
							</div>
							<div class="row">
								<div class="col-lg-6">Nama Pengguna</div>
								<div class="col-lg-6">: {{$user->username}}</div>
							</div>
							<div class="row">
								<div class="col-lg-6">Email</div>
								<div class="col-lg-6">: {{$user->email}}</div>
							</div>
							<hr>
							@if($biodata)
							<h4>Biodata</h4>
							<div class="row">
								<div class="col-lg-6">Jenis Kelamin</div>
								<div class="col-lg-6">: {{$biodata->gender}}</div>
							</div>
							<div class="row">
								<div class="col-lg-6">Tempat dan Tanggal Lahir</div>
								<div class="col-lg-6">: {{$biodata->birth_place}}, {{$biodata->birth_date}}</div>
							</div>
							<hr>
							@endif
							@if($ortu)
							<h4>Data Orang Tua</h4>
							<div class="row">
								<div class="col-lg-6">Nama Orang Tua</div>
								<div class="col-lg-6">: {{$ortu->name_ortu}}</div>
							</div>
							<div class="row">
								<div class="col-lg-6">No. HP Orang Tua</div>
								<div class="col-lg-6">: {{$ortu->phone}}</div>
							</div>
							<div class="row">
								<div class="col-lg-6">Alamat</div>
								<div class="col-lg-6">: {{$ortu->address}}, RT {{$ortu->rt}} RW {{$ortu->rw}} DESA {{$ortu->desa}} KECAMATAN {{$ortu->kecamatan}} KABUPATEN JEMBER JAWA TIMUR</div>
							</div>
							<hr>
							@endif
							@if($foto)
							<h4>Foto Gigi</h4>
							<ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item" role="presentation">
								<button class="nav-link active" id="senyum-penuh-tab" data-bs-toggle="tab" data-bs-target="#senyum-penuh" type="button" role="tab" aria-controls="home" aria-selected="true">Senyum Penuh</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="tampak-depan-tab" data-bs-toggle="tab" data-bs-target="#tampak-depan" type="button" role="tab" aria-controls="profile" aria-selected="false">Tampak Depan</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="tampak-kiri-tab" data-bs-toggle="tab" data-bs-target="#tampak-kiri" type="button" role="tab" aria-controls="contact" aria-selected="false">Tampak Kiri</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="tampak-atas-tab" data-bs-toggle="tab" data-bs-target="#tampak-atas" type="button" role="tab" aria-controls="contact" aria-selected="false">Tampak Atas</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="tampak-kanan-tab" data-bs-toggle="tab" data-bs-target="#tampak-kanan" type="button" role="tab" aria-controls="contact" aria-selected="false">Tampak Kanan</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="tampak-bawah-tab" data-bs-toggle="tab" data-bs-target="#tampak-kanan" type="button" role="tab" aria-controls="contact" aria-selected="false">Tampak Bawah</button>
							</li>
							</ul>
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade show active" id="senyum-penuh" role="tabpanel" aria-labelledby="senyum-penuh-tab">
									<br>
									<img src="{{asset($foto->foto_senyum)}}" class="img-fluid">
									<br>
									<i>Tanggal Pengambilan: {{$foto->date_taken_senyum}}</i>
								</div>
								<div class="tab-pane fade" id="tampak-depan" role="tabpanel" aria-labelledby="tampak-depan-tab">
									<br>
									<img src="{{asset($foto->foto_depan)}}" class="img-fluid">
									<br>
									<i>Tanggal Pengambilan: {{$foto->date_taken_depan}}</i>
								</div>
								<div class="tab-pane fade" id="tampak-kiri" role="tabpanel" aria-labelledby="tampak-kiri-tab">
									<br>
									<img src="{{asset($foto->foto_kiri)}}" class="img-fluid">
									<br>
									<i>Tanggal Pengambilan: {{$foto->date_taken_kiri}}</i>
								</div>
								<div class="tab-pane fade" id="tampak-atas" role="tabpanel" aria-labelledby="tampak-atas-tab">
									<br>
									<img src="{{asset($foto->foto_atas)}}" class="img-fluid">
									<br>
									<i>Tanggal Pengambilan: {{$foto->date_taken_atas}}</i>
								</div>
								<div class="tab-pane fade" id="tampak-kanan" role="tabpanel" aria-labelledby="tampak-kanan-tab">
									<br>
									<img src="{{asset($foto->foto_kanan)}}" class="img-fluid">
									<br>
									<i>Tanggal Pengambilan: {{$foto->date_taken_kanan}}</i>
								</div>
								<div class="tab-pane fade" id="tampak-bawah" role="tabpanel" aria-labelledby="tampak-bawah-tab">
									<br>
									<img src="{{asset($foto->foto_bawah)}}" class="img-fluid">
									<br>
									<i>Tanggal Pengambilan: {{$foto->date_taken_bawah}}</i>
								</div>
							</div>
							@endif
							<hr>
							<h4>Odontogram</h4>
							<div class="row">
								<div class="col-4" style="text-align: right;">
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
								</div>
								<div class="col-4">
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
								</div>
								<div class="col-3"></div>
							</div>
							<br>
							<div class="row">
								<div class="col-4" style="text-align: right;">
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
								</div>
								<div class="col-4">
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
								</div>
								<div class="col-3"></div>
							</div>
							<br>
							<div class="row">
								<div class="col-4" style="text-align: right;">
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
								</div>
								<div class="col-4">
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
								</div>
								<div class="col-3"></div>
							</div>
							<br>
							<div class="row">
								<div class="col-4" style="text-align: right;">
								<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
								</div>
								<div class="col-4">
								<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
									<svg viewBox="-115 -115 230 230">
										<defs>
										<polygon id="poly" stroke="black"  points="-36.5,36.5 36.5,36.5 108, 108 -108,108 -36.5,36.5" transform="translate(0,3)"  />
										</defs>

										<use xlink:href="#poly" />
										<use xlink:href="#poly" transform="rotate(90)" /> 
										<use xlink:href="#poly" transform="rotate(180)" />
										<use xlink:href="#poly" transform="rotate(270)" />
										
										<rect stroke="black" fill="none" x="-35" y="-35" width="70" height="70" />	
										
									</svg>
								</div>
								<div class="col-3"></div>
							</div>
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
	<script>
		$(document).ready( function () {
			$('#listAnak').DataTable();
		} );
	</script>
	<style>
		svg{border:1px solid; width:50px}
		use{fill:white;}
		use:hover{fill:gold}
	</style>
</body>

</html>