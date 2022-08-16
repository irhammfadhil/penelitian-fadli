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

					<h1 class="h3 mb-3">Laporan Umum</h1>
					
					<br>
					<div class="card">
						<div class="card-body">
                        <h3>General</h3>
                            <hr>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col" class="text-center" style="width: 30%;">Jenis Kelamin</th>
                                    <th scope="col" class="text-center">Jumlah Responden</th>
                                    <th scope="col" class="text-center">Rata-rata Indeks DMFT</th>
                                    <th scope="col" class="text-center">Rata-rata Indeks RTI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">Laki-laki</td>
                                        @php $found = 0; @endphp
                                        @foreach($query_general as $q)
                                        @if($q->jenis_kelamin == 'Laki-laki')
                                        <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                        <td class="text-center"><b>{{number_format($q->rata_rata_dmft,1)}}</b></td>
                                        <td class="text-center"><b>{{number_format($q->rata_rata_rti*100,1)}} %</b></td>
                                        @php $found = 1; @endphp
                                        @endif
                                        @endforeach
                                        @if(!$found)
                                        <td class="text-center"><b>0</b></td>
                                        <td class="text-center"><b>0</b></td>
                                        <td class="text-center"><b>0%</b></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="text-center">Perempuan</td>
                                        @php $found = 0; @endphp
                                        @foreach($query_general as $q)
                                        @if($q->jenis_kelamin == 'Perempuan')
                                        <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                        <td class="text-center"><b>{{number_format($q->rata_rata_dmft,1)}}</b></td>
                                        <td class="text-center"><b>{{number_format($q->rata_rata_rti*100,1)}} %</b></td>
                                        @php $found = 1; @endphp
                                        @endif
                                        @endforeach
                                        @if(!$found)
                                        <td class="text-center"><b>0</b></td>
                                        <td class="text-center"><b>0</b></td>
                                        <td class="text-center"><b>0%</b></td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                            <h3>Berdasarkan Kelompok Usia</h3>
                            <hr>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col" class="text-center" style="width: 15%;">Jenis Kelamin</th>
                                    <th scope="col" class="text-center" style="width: 15%;">Kelompok Usia</th>
                                    <th scope="col" class="text-center">Jumlah Responden</th>
                                    <th scope="col" class="text-center">Rata-rata Indeks DMFT</th>
                                    <th scope="col" class="text-center">Rata-rata Indeks RTI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td rowspan="2" class="text-center">Laki-laki</td>
                                        <td class="text-center">7-10 tahun</td>
                                        @php $found = 0; @endphp
                                        @foreach($query_klp_usia as $q)
                                        @if($q->jenis_kelamin == 'Laki-laki' && $q->kategori_umur == 'Usia 7-10 th')
                                        <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                        <td class="text-center"><b>{{number_format($q->rata_rata_dmft,1)}}</b></td>
                                        <td class="text-center"><b>{{number_format($q->rata_rata_rti*100,1)}} %</b></td>
                                        @php $found = 1; @endphp
                                        @endif
                                        @endforeach
                                        @if(!$found)
                                        <td class="text-center"><b>0</b></td>
                                        <td class="text-center"><b>0</b></td>
                                        <td class="text-center"><b>0%</b></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="text-center">10-12 tahun</td>
                                        @php $found = 0; @endphp
                                        @foreach($query_klp_usia as $q)
                                        @if($q->jenis_kelamin == 'Laki-laki' && $q->kategori_umur == 'Usia 10-12 th')
                                        <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                        <td class="text-center"><b>{{number_format($q->rata_rata_dmft,1)}}</b></td>
                                        <td class="text-center"><b>{{number_format($q->rata_rata_rti*100,1)}} %</b></td>
                                        @php $found = 1; @endphp
                                        @endif
                                        @endforeach
                                        @if(!$found)
                                        <td class="text-center"><b>0</b></td>
                                        <td class="text-center"><b>0</b></td>
                                        <td class="text-center"><b>0%</b></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td rowspan="2" class="text-center">Perempuan</td>
                                        <td class="text-center">7-10 tahun</td>
                                        @php $found = 0; @endphp
                                        @foreach($query_klp_usia as $q)
                                        @if($q->jenis_kelamin == 'Perempuan' && $q->kategori_umur == 'Usia 7-10 th')
                                        <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                        <td class="text-center"><b>{{number_format($q->rata_rata_dmft,1)}}</b></td>
                                        <td class="text-center"><b>{{number_format($q->rata_rata_rti*100,1)}} %</b></td>
                                        @php $found = 1; @endphp
                                        @endif
                                        @endforeach
                                        @if(!$found)
                                        <td class="text-center"><b>0</b></td>
                                        <td class="text-center"><b>0</b></td>
                                        <td class="text-center"><b>0%</b></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="text-center">10-12 tahun</td>
                                        @php $found = 0; @endphp
                                        @foreach($query_klp_usia as $q)
                                        @if($q->jenis_kelamin == 'Perempuan' && $q->kategori_umur == 'Usia 10-12 th')
                                        <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                        <td class="text-center"><b>{{number_format($q->rata_rata_dmft,1)}}</b></td>
                                        <td class="text-center"><b>{{number_format($q->rata_rata_rti*100,1)}} %</b></td>
                                        @php $found = 1; @endphp
                                        @endif
                                        @endforeach
                                        @if(!$found)
                                        <td class="text-center"><b>0</b></td>
                                        <td class="text-center"><b>0</b></td>
                                        <td class="text-center"><b>0%</b></td>
                                        @endif
                                    </tr>
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