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
									<div class="col-lg-4">Nama</div>
									<div class="col-lg-8">: {{$user->name}}</div>
								</div>
								@if($biodata)
								<div class="row">
									<div class="col-lg-4">Jenis Kelamin</div>
									<div class="col-lg-8">: {{$biodata->gender}}</div>
								</div>
								<div class="row">
									<div class="col-lg-4">Tempat dan Tanggal Lahir</div>
									<div class="col-lg-8">: {{$biodata->birth_place}}, @php echo(tgl_indo($biodata->birth_date)); @endphp</div>
								</div>
							<div id="biodata">
								<hr>
								@endif
								@if($ortu)
								<h4>Data Orang Tua </h4>
								<div class="row">
									<div class="col-lg-4">Nama Orang Tua</div>
									<div class="col-lg-8">: {{$ortu->name_ortu}}</div>
								</div>
								<div class="row">
									<div class="col-lg-4">No. HP Orang Tua</div>
									<div class="col-lg-8">: {{$ortu->phone}}</div>
								</div>
								<div class="row">
									<div class="col-lg-4">Alamat</div>
									<div class="col-lg-8">: {{$ortu->address}}, RT {{$ortu->rt}} RW {{$ortu->rw}} DESA {{$ortu->desa}} KECAMATAN {{$ortu->kecamatan}} KABUPATEN JEMBER JAWA TIMUR</div>
								</div>
							</div>
							<hr>
							@endif
							@if($foto)
							<h4>Foto Gigi (<a href="#" id="foto-toggle">tampilkan</a><a href="#" id="foto-toggle-hide">sembunyikan</a>)</h4>
							<div id="foto">
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
							</div>
							@endif
							<hr>
							<div class="row">
								<div class="col-6">
									<h4>Odontogram</h4>
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
											<tr class="text-center">
											<td>18</td>
											<td>17</td>
											<td>16</td>
											<td>15</td>
											<td>14</td>
											<td>13</td>
											<td>12</td>
											<td>11</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-6">
									<table class="table table-bordered">
										<tbody>
											<tr class="text-center">
											<td>21</td>
											<td>22</td>
											<td>23</td>
											<td>24</td>
											<td>25</td>
											<td>26</td>
											<td>27</td>
											<td>28</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>

							<div class="row">
								<div class="col-6">
									<table class="table table-bordered" style="width: 62.5%; text-align: right;">
										<tbody>
											<tr class="text-center">
											<td>55</td>
											<td>54</td>
											<td>53</td>
											<td>52</td>
											<td>51</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-6">
									<table class="table table-bordered" style="width: 62.5%; text-align: right;">
										<tbody>
											<tr class="text-center">
											<td>61</td>
											<td>62</td>
											<td>63</td>
											<td>64</td>
											<td>65</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<table class="table table-bordered" style="width: 62.5%; text-align: right;">
										<tbody>
											<tr class="text-center">
											<td>85</td>
											<td>84</td>
											<td>83</td>
											<td>82</td>
											<td>81</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-6">
									<table class="table table-bordered" style="width: 62.5%; text-align: right;">
										<tbody>
											<tr class="text-center">
											<td>71</td>
											<td>72</td>
											<td>73</td>
											<td>74</td>
											<td>75</td>
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
											<td>48</td>
											<td>47</td>
											<td>46</td>
											<td>45</td>
											<td>44</td>
											<td>43</td>
											<td>42</td>
											<td>41</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-6">
									<table class="table table-bordered">
										<tbody>
											<tr class="text-center">
											<td>31</td>
											<td>32</td>
											<td>33</td>
											<td>34</td>
											<td>35</td>
											<td>36</td>
											<td>37</td>
											<td>38</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							{{--<table class="table table-bordered table-hover">
								<thead class="thead-dark">
									<tr>
									<th scope="col" style="width: 25%;" class="text-center">ID Gigi</th>
									<th scope="col" style="width: 25%;" class="text-center">Diagnosis</th>
									<th scope="col" style="width: 25%;" class="text-center">Diagnosis</th>
									<th scope="col" style="width: 25%;" class="text-center">ID Gigi</th>
									</tr>
								</thead>
								<tbody>
									@for($i=0;$i<sizeof($id_gigi_tetap_kiri_atas);$i++)
									<tr>
									@if($i<5)
									<td>{{$id_gigi_tetap_kiri_atas[$i]}} [{{$id_gigi_sulung_kiri_atas[$i]}}]</td>
									@else
									<td>{{$id_gigi_tetap_kiri_atas[$i]}}</td>
									@endif
									<td>
										{{$id_gigi_tetap_kiri_atas[$i]}}: @foreach($odontogram as $o)
										@if($o->id_gigi == $id_gigi_tetap_kiri_atas[$i])
										{{$o->region->region_code}} {{$o->diagnosis->diagnosis_code}}
										@elseif($i<5)
										@if($o->id_gigi == $id_gigi_sulung_kiri_atas[$i])
										; {{$id_gigi_sulung_kiri_atas[$i]}}: {{$o->region->region_code}} {{$o->diagnosis->diagnosis_code}}
										@endif
										@endif
										@endforeach
									</td>
									<td>
										{{$id_gigi_tetap_kanan_atas[$i]}}: @foreach($odontogram as $o)
										@if($o->id_gigi == $id_gigi_tetap_kanan_atas[$i])
										{{$o->region->region_code}} {{$o->diagnosis->diagnosis_code}}
										@elseif($i<5)
										@if($o->id_gigi == $id_gigi_sulung_kanan_atas[$i])
										; {{$id_gigi_sulung_kanan_atas[$i]}}: {{$o->region->region_code}} {{$o->diagnosis->diagnosis_code}}
										@endif
										@endif
										@endforeach
									</td>
									@if($i<5)
									<td>[{{$id_gigi_sulung_kanan_atas[$i]}}] {{$id_gigi_tetap_kanan_atas[$i]}}</td>
									@else
									<td>{{$id_gigi_tetap_kanan_atas[$i]}}</td>
									@endif
									</tr>
									@endfor
								</tbody>
							</table>

							<table class="table table-bordered table-hover">
								<thead class="thead-dark">
									<tr>
									<th scope="col" style="width: 25%;" class="text-center">ID Gigi</th>
									<th scope="col" style="width: 25%;" class="text-center">Diagnosis</th>
									<th scope="col" style="width: 25%;" class="text-center">Diagnosis</th>
									<th scope="col" style="width: 25%;" class="text-center">ID Gigi</th>
									</tr>
								</thead>
								<tbody>
									@for($i=sizeof($id_gigi_tetap_kiri_bawah)-1;$i>=0;$i--)
									<tr>
									@if($i<5)
									<td>{{$id_gigi_tetap_kiri_bawah[$i]}} [{{$id_gigi_sulung_kiri_bawah[$i]}}]</td>
									@else
									<td>{{$id_gigi_tetap_kiri_bawah[$i]}}</td>
									@endif
									<td>
										{{$id_gigi_tetap_kiri_bawah[$i]}}: @foreach($odontogram as $o)
										@if($o->id_gigi == $id_gigi_tetap_kiri_bawah[$i])
										{{$o->region->region_code}} {{$o->diagnosis->diagnosis_code}}
										@elseif($i<5)
										@if($o->id_gigi == $id_gigi_sulung_kiri_bawah[$i])
										; {{$id_gigi_sulung_kiri_bawah[$i]}}: {{$o->region->region_code}} {{$o->diagnosis->diagnosis_code}}
										@endif
										@endif
										@endforeach
									</td>
									<td>
										{{$id_gigi_tetap_kanan_bawah[$i]}}: @foreach($odontogram as $o)
										@if($o->id_gigi == $id_gigi_tetap_kanan_bawah[$i])
										{{$o->region->region_code}} {{$o->diagnosis->diagnosis_code}}
										@elseif($i<5)
										@if($o->id_gigi == $id_gigi_sulung_kanan_bawah[$i])
										; {{$id_gigi_sulung_kanan_bawah[$i]}}: {{$o->region->region_code}} {{$o->diagnosis->diagnosis_code}}
										@endif
										@endif
										@endforeach
									</td>
									@if($i<5)
									<td>[{{$id_gigi_sulung_kanan_bawah[$i]}}] {{$id_gigi_tetap_kanan_bawah[$i]}}</td>
									@else
									<td>{{$id_gigi_tetap_kanan_bawah[$i]}}</td>
									@endif
									</tr>
									@endfor
								</tbody>
							</table>--}}
							D: ... M: ... F: ...
							<br>
							DMFT: ....
							<br>
							RTI: ....

							<!-- Modal -->
							{{--<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
									</div>
									<div class="mb-3">
										<label for="exampleInputEmail1" class="form-label">Regio</label>
										<select class="form-select" aria-label="Default select example" name="regio" id="regio">
											<option selected>Pilih Regio...</option>
											@foreach($region as $r) 
											<option value="{{$r->id}}">{{$r->region_code}} - {{$r->region_name}}</option>
											@endforeach
										</select>
									</div>
									<div class="mb-3">
										<label for="exampleInputEmail1" class="form-label">Diagnosis</label>
										<select class="form-select" aria-label="Default select example" name="diagnosis" id="diagnosis">
											<option selected>Pilih Diagnosis...</option>
											@foreach($diagnosis as $d) 
											<option value="{{$d->id}}">{{$d->diagnosis_code}} - {{$d->diagnosis_arti}}</option>
											@endforeach
										</select>
									</div>
									<div class="mb-3">
										<label for="exampleFormControlTextarea1" class="form-label">Catatan</label>
										<textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
								</form>
								</div>
							</div>
							</div>--}}
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script>
		$(document).ready( function () {
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