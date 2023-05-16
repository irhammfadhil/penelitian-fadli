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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
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

					<h1 class="h3 mb-3">Pemeriksaan Gigi</h1>
					
					<br>
					<div class="card">
						<div class="card-body">
							<h3>Detail Anak</h3>
							<br>
							<h4>Informasi Pribadi (<a href="#" id="biodata-toggle">tampilkan</a><a href="#" id="biodata-toggle-hide">sembunyikan</a>)</h4>
								<div class="row">
									<div class="col-4">Nama</div>
									<div class="col-8">: {{$user->name}}</div>
								</div>
								@if($biodata)
								<div class="row">
									<div class="col-4">Jenis Kelamin</div>
									<div class="col-8">: {{$biodata->gender}}</div>
								</div>
								<div class="row">
									<div class="col-4">Tempat dan Tanggal Lahir</div>
									<div class="col-8">: {{$biodata->birth_place}}, @php echo(tgl_indo($biodata->birth_date)); @endphp</div>
								</div>
							<div id="biodata">
								<hr>
								@endif
								@if($ortu)
								<h4>Data Orang Tua </h4>
								<div class="row">
									<div class="col-4">Nama Orang Tua</div>
									<div class="col-8">: {{$ortu->name_ortu}}</div>
								</div>
								<div class="row">
									<div class="col-4">No. HP Orang Tua</div>
									<div class="col-8">: {{$ortu->phone}}</div>
								</div>
								<div class="row">
									<div class="col-4">Alamat</div>
									<div class="col-8">: {{$ortu->address}}, RT {{$ortu->rt}} RW {{$ortu->rw}} DESA {{$ortu->desa}} KECAMATAN {{$ortu->kecamatan}} KABUPATEN JEMBER JAWA TIMUR</div>
								</div>
								<div class="row">
									<div class="col-4">Range Gaji Orang Tua</div>
									<div class="col-8">: Rp {{$ortu->gaji}}</div>
								</div>
								<div class="row">
									<div class="col-4">Luas Rumah</div>
									<div class="col-8">: {{$ortu->luas_rumah}} m2</div>
								</div>
								<div class="row">
									<div class="col-4">Daya Listrik</div>
									<div class="col-8">: {{$ortu->daya_listrik}} VA</div>
								</div>
								{{--@if($screening)
								<hr>
								<h4>Data Screening COVID-19 </h4>
								<div class="row">
									<div class="col-4">Apakah Anda sedang Demam atau riwayat demam >38°c?</div>
									<div class="col-8">: 
										@if($screening->is_demam == 0)
										Tidak
										@else
										Ya
										@endif
									</div>
								</div>
								<div class="row">
									<div class="col-4">Apakah Anda sedang Batuk / pilek / nyeri tenggorokan/tidak bisa mencium?</div>
									<div class="col-8">: 
										@if($screening->is_batuk == 0)
										Tidak
										@else
										Ya
										@endif
									</div>
								</div>
								<div class="row">
									<div class="col-4">Apakah Anda sedang Sesak napas?</div>
									<div class="col-8">: 
										@if($screening->is_sesak == 0)
										Tidak
										@else
										Ya
										@endif
									</div>
								</div>
								<div class="row">
									<div class="col-4">Apakah Anda Memiliki riwayat perjalanan ke luar kota atau kontak dengan orang yang memiliki riwayat perjalanan ke luar kota dalam 14 hari terakhir?</div>
									<div class="col-8">: 
										@if($screening->is_travel == 0)
										Tidak
										@else
										Ya
										@endif
									</div>
								</div>
								<div class="row">
									<div class="col-4">Apakah Anda memiliki Riwayat kontak erat dengan kasus konfirmasi covid-19?</div>
									<div class="col-8">: 
										@if($screening->is_close_contact == 0)
										Tidak
										@else
										Ya
										@endif
									</div>
								</div>
								<div class="row">
									<div class="col-4">Apakah Anda Mengunjungi fasilitas kesehatan yang berhubungan dengan pasien konfirmasi COVID-19?</div>
									<div class="col-8">: 
										@if($screening->is_health_facilities_visit == 0)
										Tidak
										@else
										Ya
										@endif
									</div>
								</div>
								@endif--}}
							</div>
							<hr>
							@endif
							@if($foto)
							<h4>Foto Gigi (<a href="#" id="foto-toggle">tampilkan</a><a href="#" id="foto-toggle-hide">sembunyikan</a>)</h4>
							<div id="foto">
								<div class="row">
									<div class="col-4">Status Persetujuan Foto</div>
									<div class="col-8">: <b>@if($user->is_photo_verified == 0) Belum Disetujui @else Sudah Disetujui @endif</b> </div>
								</div>
								<div class="row">
									<div class="col-4">Komentar Foto</div>
									<div class="col-8">: {{$user->photo_comments}} </div>
								</div>
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
										<i>Tanggal Pengambilan: @php echo(tgl_indo($foto->date_taken_senyum)); @endphp</i>
									</div>
									<div class="tab-pane fade" id="tampak-depan" role="tabpanel" aria-labelledby="tampak-depan-tab">
										<br>
										<img src="{{asset($foto->foto_depan)}}" class="img-fluid">
										<br>
										<i>Tanggal Pengambilan: @php echo(tgl_indo($foto->date_taken_depan)); @endphp</i>
									</div>
									<div class="tab-pane fade" id="tampak-kiri" role="tabpanel" aria-labelledby="tampak-kiri-tab">
										<br>
										<img src="{{asset($foto->foto_kiri)}}" class="img-fluid">
										<br>
										<i>Tanggal Pengambilan: @php echo(tgl_indo($foto->date_taken_kiri)); @endphp</i>
									</div>
									<div class="tab-pane fade" id="tampak-atas" role="tabpanel" aria-labelledby="tampak-atas-tab">
										<br>
										<img src="{{asset($foto->foto_atas)}}" class="img-fluid">
										<br>
										<i>Tanggal Pengambilan: @php echo(tgl_indo($foto->date_taken_atas)); @endphp</i>
									</div>
									<div class="tab-pane fade" id="tampak-kanan" role="tabpanel" aria-labelledby="tampak-kanan-tab">
										<br>
										<img src="{{asset($foto->foto_kanan)}}" class="img-fluid">
										<br>
										<i>Tanggal Pengambilan: @php echo(tgl_indo($foto->date_taken_kanan)); @endphp</i>
									</div>
									<div class="tab-pane fade" id="tampak-bawah" role="tabpanel" aria-labelledby="tampak-bawah-tab">
										<br>
										<img src="{{asset($foto->foto_bawah)}}" class="img-fluid">
										<br>
										<i>Tanggal Pengambilan: @php echo(tgl_indo($foto->date_taken_bawah)); @endphp</i>
									</div>
								</div>
								<form action="/admin/submitFoto" method="post">
									@csrf
									<input type="hidden" name="id" value="{{ app('request')->input('id') }}">
									<div class="form-group">
										<label for="exampleFormControlTextarea1">Komentar Admin:</label>
										<textarea class="form-control" id="komentar-foto" name="komentar_foto" rows="3"></textarea>
									</div>
									<br>
									<div class="row text-center">
										<div class="col-6">
											<button type="submit" name="action" value="tolak" class="btn btn-danger">Tolak Foto</button>
										</div>
										<div class="col-6">
											<button type="submit" name="action" value="setuju" class="btn btn-primary">Setujui Foto</button>
										</div>
									</div>
								</form>
							</div>
							@endif
							<hr>
							<div class="row">
								<div class="col-6">
									<h4>Pemeriksaan RTI</h4>
								</div>
								<div class="col-6">
									<!-- Button trigger modal -->
									<button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
									Diagnosis Baru
									</button>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-6">
									<table class="table table-bordered">
										<tbody>
											<tr class="text-center" style="border:none;">
											<td class="" id="" style="border:none;">18</td>
											<td class="" id="" style="border:none;">17</td>
											<td class="" id="" style="border:none;">16</td>
											<td class="" id="" style="border:none;">15</td>
											<td class="" id="" style="border:none;">14</td>
											<td class="" id="" style="border:none;">13</td>
											<td class="" id="" style="border:none;">12</td>
											<td class="" id="" style="border:none;">11</td>
											</tr>
											<tr class="text-center">
											<td class="gigi" id="gigi18" style="height: 2.5rem; width: 2.5rem;">
											@foreach($diagnosis as $d)
											@if($d->id_gigi == 18)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td>
											<td class="gigi" id="gigi17" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 17)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi16" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 16)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi15" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 15)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi14" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 14)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi13" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 13)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi12" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 12)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi11" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 11)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-6">
									<table class="table table-bordered">
										<tbody>
											<tr class="text-center" style="border:none;">
											<td class="" id="" style="border:none;">21</td>
											<td class="" id="" style="border:none;">22</td>
											<td class="" id="" style="border:none;">23</td>
											<td class="" id="" style="border:none;">24</td>
											<td class="" id="" style="border:none;">25</td>
											<td class="" id="" style="border:none;">26</td>
											<td class="" id="" style="border:none;">27</td>
											<td class="" id="" style="border:none;">28</td>
											</tr>
											<tr class="text-center">
											<td class="gigi" id="gigi21" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 21)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi22" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 22)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi23" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 23)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi24" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 24)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi25" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 25)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi26" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 26)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi27" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 27)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi28" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 28)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>

							<div class="row">
								<div class="col-6">
									<div id="tabel-gigi-susu-kiri">
										<table class="table table-bordered" style="width: 62.5%; float: right;">
											<tbody>
												<tr class="text-center" style="border:none;">
												<td class="" id="" style="border:none;">55</td>
												<td class="" id="" style="border:none;">54</td>
												<td class="" id="" style="border:none;">53</td>
												<td class="" id="" style="border:none;">52</td>
												<td class="" id="" style="border:none;">51</td>
												</tr>
												<tr class="text-center">
												<td class="gigi" id="gigi55" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 55)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
												<td class="gigi" id="gigi54" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 54)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
												<td class="gigi" id="gigi53" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 53)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
												<td class="gigi" id="gigi52" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 52)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
												<td class="gigi" id="gigi51" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 51)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-6">
									<table class="table table-bordered" style="width: 62.5%; text-align: right;">
										<tbody>
											<tr class="text-center" style="border:none;">
												<td class="" id="" style="border:none;">61</td>
												<td class="" id="" style="border:none;">62</td>
												<td class="" id="" style="border:none;">63</td>
												<td class="" id="" style="border:none;">64</td>
												<td class="" id="" style="border:none;">65</td>
											</tr>
											<tr class="text-center">
											<td class="gigi" id="gigi61" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 61)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi62" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 62)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi63" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 63)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi64" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 64)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi65" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 65)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-6">
									<table class="table table-bordered" style="width: 62.5%; float: right;">
										<tbody>
											<tr class="text-center">
											<td class="gigi" id="gigi85" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 85)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi84" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 84)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi83" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 83)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi82" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 82)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi81" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 81)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											</tr>
											<tr class="text-center" style="border:none;">
												<td class="" id="" style="border:none;">85</td>
												<td class="" id="" style="border:none;">84</td>
												<td class="" id="" style="border:none;">83</td>
												<td class="" id="" style="border:none;">82</td>
												<td class="" id="" style="border:none;">81</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-6">
									<table class="table table-bordered" style="width: 62.5%; text-align: right;">
										<tbody>
											<tr class="text-center">
											<td class="gigi" id="gigi71" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 71)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi72" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 72)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi73" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 73)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi74" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 74)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi75" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 75)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											</tr>
											<tr class="text-center" style="border:none;">
												<td class="" id="" style="border:none;">71</td>
												<td class="" id="" style="border:none;">72</td>
												<td class="" id="" style="border:none;">73</td>
												<td class="" id="" style="border:none;">74</td>
												<td class="" id="" style="border:none;">75</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>

							<div class="row">
								<div class="col-6">
									<table class="table table-bordered">
										<tbody>
											<tr class="text-center">
											<td class="gigi" id="gigi48" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 48)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi47" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 47)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi46" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 46)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi45" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 45)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi44" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 44)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi43" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 43)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi42" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 42)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi41" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 41)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											</tr>
											<tr class="text-center" style="border:none;">
												<td class="" id="" style="border:none;">48</td>
												<td class="" id="" style="border:none;">47</td>
												<td class="" id="" style="border:none;">46</td>
												<td class="" id="" style="border:none;">45</td>
												<td class="" id="" style="border:none;">44</td>
												<td class="" id="" style="border:none;">43</td>
												<td class="" id="" style="border:none;">42</td>
												<td class="" id="" style="border:none;">41</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-6">
									<table class="table table-bordered">
										<tbody>
											<tr class="text-center">
											<td class="gigi" id="gigi31" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 31)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi32" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 32)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi33" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 33)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi34" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 34)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi35" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 35)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi36" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 36)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi37" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 37)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											<td class="gigi" id="gigi38" style="height: 2.5rem; width: 2.5rem;">@foreach($diagnosis as $d)
											@if($d->id_gigi == 38)
											@if ($d->is_decay == 1)
											D
											@endif 
											@if ($d->is_missing == 1)
											M
											@endif
											@if ($d->is_filling == 1)
											F
											@endif 
											@endif 
											@endforeach</td></td>
											</tr>
											<tr class="text-center" style="border:none;">
												<td class="" id="" style="border:none;">31</td>
												<td class="" id="" style="border:none;">32</td>
												<td class="" id="" style="border:none;">33</td>
												<td class="" id="" style="border:none;">34</td>
												<td class="" id="" style="border:none;">35</td>
												<td class="" id="" style="border:none;">36</td>
												<td class="" id="" style="border:none;">37</td>
												<td class="" id="" style="border:none;">38</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>

							D/d: <b>{{$sum_decay_tetap}}/{{$sum_decay_susu}}</b> M/e: <b>{{$sum_missing_tetap}}/{{$sum_missing_susu}}</b> F/f: <b>{{$sum_filling_tetap}}/{{$sum_filling_susu}}</b>
							<br>
							DMFT: <b>{{$user->dmft_score}}</b>, Kriteria DMFT: <b>{{$kriteria_dmft}}</b>
							<br>
							def-t: <b>{{$user->deft_score}}</b>, Kriteria def-t: <b>{{$kriteria_deft}}</b>
							<br>
							@if($user->dmft_score == 0)
							RTI: <b>0%</b>
							@else
							RTI: <b>{{number_format($sum_decay_tetap/$user->dmft_score, 2)*100}}%</b>
							@endif
							<hr>
							<h4>Saran</h4>
							<form action="/admin/submitKomentar" method="post">
								@csrf
								<input type="hidden" name="id" value="{{ app('request')->input('id') }}">
								<div class="form-group">
									<textarea class="form-control" id="komentar" name="komentar" rows="3">{{$user->comments}}</textarea>
								</div>
								<br>
								<button type="submit" class="btn btn-primary">Submit</button>
							</form>
							<!-- Modal -->
							<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-xl">
								<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Diagnosis Baru</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<form action="/odontogram/submit" method="post">
								<div class="modal-body">
									@csrf
									<input type="hidden" id="usersId" name="usersId" value="">
									<div class="mb-3">
										<label for="exampleInputEmail1" class="form-label">ID Gigi</label>
										<select class="form-select" aria-label="Default select example" name="gigi" id="gigi">
											<option selected>Pilih ID Gigi...</option>
											@foreach($id_gigi as $i) 
											<option value="{{$i}}">{{$i}}</option>
											@endforeach
										</select>
										<br>
										<b>Diagnosis:</b>
										<div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="decay" name="decay">
											<label class="form-check-label" for="flexCheckDefault">
												Decay
											</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="missing" name="missing">
											<label class="form-check-label" for="flexCheckDefault">
												Missing
											</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="filling" name="filling">
											<label class="form-check-label" for="flexCheckDefault">
												Filling
											</label>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
								</form>
								</div>
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script>
		$(document).ready( function () {
			id_gigi = 0;
			$("#gigi18").click(function(){
				console.log($("#gigi18").text());
			});
			$("#gigi17").click(function(){
				console.log($("#gigi17").text());
			});
			$("#gigi16").click(function(){
				console.log($("#gigi16").text());
			});
			$("#gigi15").click(function(){
				console.log($("#gigi15").text());
			});
			$("#gigi14").click(function(){
				console.log($("#gigi14").text());
			});
			$("#gigi13").click(function(){
				console.log($("#gigi13").text());
			});
			$("#gigi12").click(function(){
				console.log($("#gigi12").text());
			});
			$("#gigi11").click(function(){
				console.log($("#gigi11").text());
			});
			$("#gigi21").click(function(){
				console.log($("#gigi21").text());
			});
			$("#gigi22").click(function(){
				console.log($("#gigi22").text());
			});
			$("#gigi23").click(function(){
				console.log($("#gigi23").text());
			});
			$("#gigi24").click(function(){
				console.log($("#gigi24").text());
			});
			$("#gigi25").click(function(){
				console.log($("#gigi25").text());
			});
			$("#gigi26").click(function(){
				console.log($("#gigi26").text());
			});
			$("#gigi27").click(function(){
				console.log($("#gigi27").text());
			});
			$("#gigi28").click(function(){
				console.log($("#gigi28").text());
			});
			$("#gigi55").click(function(){
				console.log($("#gigi55").text());
			});
			$("#gigi54").click(function(){
				console.log($("#gigi54").text());
			});
			$("#gigi53").click(function(){
				console.log($("#gigi53").text());
			});
			$("#gigi52").click(function(){
				console.log($("#gigi52").text());
			});
			$("#gigi51").click(function(){
				console.log($("#gigi51").text());
			});
			$("#gigi61").click(function(){
				console.log($("#gigi61").text());
			});
			$("#gigi62").click(function(){
				console.log($("#gigi62").text());
			});
			$("#gigi63").click(function(){
				console.log($("#gigi63").text());
			});
			$("#gigi64").click(function(){
				console.log($("#gigi64").text());
			});
			$("#gigi65").click(function(){
				console.log($("#gigi65").text());
			});
			$("#gigi85").click(function(){
				console.log($("#gigi85").text());
			});
			$("#gigi84").click(function(){
				console.log($("#gigi84").text());
			});
			$("#gigi83").click(function(){
				console.log($("#gigi83").text());
			});
			$("#gigi82").click(function(){
				console.log($("#gigi82").text());
			});
			$("#gigi81").click(function(){
				console.log($("#gigi81").text());
			});
			$("#gigi71").click(function(){
				console.log($("#gigi71").text());
			});
			$("#gigi72").click(function(){
				console.log($("#gigi72").text());
			});
			$("#gigi73").click(function(){
				console.log($("#gigi73").text());
			});
			$("#gigi74").click(function(){
				console.log($("#gigi74").text());
			});
			$("#gigi75").click(function(){
				console.log($("#gigi75").text());
			});
			$("#gigi48").click(function(){
				console.log($("#gigi48").text());
			});
			$("#gigi47").click(function(){
				console.log($("#gigi47").text());
			});
			$("#gigi46").click(function(){
				console.log($("#gigi46").text());
			});
			$("#gigi45").click(function(){
				console.log($("#gigi45").text());
			});
			$("#gigi44").click(function(){
				console.log($("#gigi44").text());
			});
			$("#gigi43").click(function(){
				console.log($("#gigi43").text());
			});
			$("#gigi42").click(function(){
				console.log($("#gigi42").text());
			});
			$("#gigi41").click(function(){
				console.log($("#gigi41").text());
			});
			$("#gigi31").click(function(){
				console.log($("#gigi31").text());
			});
			$("#gigi32").click(function(){
				console.log($("#gigi32").text());
			});
			$("#gigi33").click(function(){
				console.log($("#gigi33").text());
			});
			$("#gigi34").click(function(){
				console.log($("#gigi34").text());
			});
			$("#gigi35").click(function(){
				console.log($("#gigi35").text());
			});
			$("#gigi36").click(function(){
				console.log($("#gigi36").text());
			});
			$("#gigi37").click(function(){
				console.log($("#gigi37").text());
			});
			$("#gigi38").click(function(){
				console.log($("#gigi38").text());
			});
			$('#listAnak').DataTable();
			$('#biodata').hide();
			$('#biodata-toggle-hide').hide();
			$('#foto').hide();
			$('#foto-toggle-hide').hide();
			$("#biodata-toggle").click(function() {
				$('#biodata').show();
				$('#biodata-toggle').hide();
				$('#biodata-toggle-hide').show();
			});
			$("#biodata-toggle-hide").click(function() {
				$('#biodata').hide();
				$('#biodata-toggle').show();
				$('#biodata-toggle-hide').hide();
			});
			$("#foto-toggle").click(function() {
				$('#foto').show();
				$('#foto-toggle').hide();
				$('#foto-toggle-hide').show();
			});
			$("#foto-toggle-hide").click(function() {
				$('#foto').hide();
				$('#foto-toggle').show();
				$('#foto-toggle-hide').hide();
			});
			//triggered when modal is about to be shown
			$('#exampleModal').on('show.bs.modal', function(e) {
				$(".modal-body #usersId").val({{ app('request')->input('id') }});
			});
		});
	</script>
	{{--<style>
		svg{border:1px solid; width:50px}
		use{fill:white;}
		use:hover{fill:gold}
	</style>--}}
</body>

</html>