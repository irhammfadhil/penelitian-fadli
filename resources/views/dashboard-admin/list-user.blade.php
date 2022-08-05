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

					<h1 class="h3 mb-3">Daftar User</h1>
					
					<br>
					<div class="card">
						<div class="card-body">
							<table class="table table-striped table-hover table-bordered" id="listAnak" width="100%" cellspacing="0">
								<thead class="thead-dark">
									<tr>
									<th scope="col" style="width:5%;" class="text-center">No</th>
									<th scope="col" class="text-center">Nama Anak</th>
									<th scope="col" class="text-center">Tanggal Pendaftaran</th>
									<th scope="col" class="text-center">Role</th>
									<th scope="col" class="text-center">Tindakan</th>
									</tr>
								</thead>
								<tbody>
									@foreach($anak as $a)
									<tr>
									<th scope="row" class="text-center">{{$loop->iteration}}</th>
									<td>{{$a->name}}</td>
									<td class="text-center">{{$a->created_at}}</td>
									<td class="text-center">@if($a->is_admin == 0) User @else Admin @endif</td>
									<td class="text-center">@if($a->is_admin == 0)<a class="btn btn-primary" href="/daftar-user/makeAdmin?id={{$a->id}}" role="button">Jadikan sebagai Admin</a>
                                    @else
                                    <a class="btn btn-primary" href="/daftar-user/makeUser?id={{$a->id}}" role="button">Jadikan sebagai User</a>
                                    @endif
									</td>
									</tr>
									@endforeach
								</tbody>
							</table>
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

	<script src="{{asset('static/js/app.js')}}"></script>
	<script>
		$(document).ready( function () {
			$('#listAnak').DataTable();
		} );
	</script>
</body>

</html>