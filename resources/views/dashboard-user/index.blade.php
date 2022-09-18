<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{asset('img/icons/icon-48x48.png')}}" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Simetri</title>



	<link href="{{asset('static/css/app.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		@include('layouts.sidebar')

		<div class="main">
			@include('layouts.navbar-login')

			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Dashboard</h1>

					<div class="row">
						<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Status</h5>
								</div>
								<div class="card-body d-flex w-100">
									@if(Auth::user()->finalisasi_at == NULL)
									<div class="alert alert-danger" role="alert">
										Anda belum melakukan finalisasi atas data Anda!
									</div>
									@elseif(Auth::user()->finalisasi_at && !Auth::user()->photo_comments && Auth::user()->is_photo_verified == 0)
									<div class="alert alert-success" role="alert">
										Anda sudah melakukan finalisasi atas data Anda! Harap tunggu, admin akan menilai kondisi gigi Anda.
									</div>
									@elseif(Auth::user()->finalisasi_at && Auth::user()->photo_comments && Auth::user()->is_photo_verified == 0)
									<div class="alert alert-danger" role="alert">
										Mohon maaf, foto gigi Anda belum disetujui! <br><br>
										<b>Catatan Admin: </b>{{Auth::user()->photo_comments}}
									</div>
									@elseif(Auth::user()->finalisasi_at && Auth::user()->is_photo_verified == 1)
									<div class="alert alert-success" role="alert">
										Foto Anda sudah disetujui! Anda dapat melihat hasil kondisi gigi pada laman <b>Laporan</b>.<br><br>
										<b>Catatan Admin: </b>{{Auth::user()->photo_comments}}
									</div>
									@endif
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Informasi</h5>
								</div>
								<div class="card-body d-flex w-100">
								</div>
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
								<a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Simetri</strong></a> &copy;
							</p>
						</div>
						<div class="col-6 text-end">

						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<style>
		.alert {
			width: 100%;
		}
	</style>

	<script src="{{asset('static/js/app.js')}}"></script>



</body>

</html>