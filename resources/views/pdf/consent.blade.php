<!DOCTYPE html>
<html>
<head>
    <title>Informed Consent {{$user->name}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
    .page_break { page-break-before: always; }
            .center {
                text-align: center;
            }
            .center img {
                display: block;
            }
	</style>
    <style> 
    #box {
    box-sizing: content-box;  
    width: 600px;
    height: 40px;
    padding: 20px;  
    border: 3px solid black;
    }
    </style>
  <style type="text/css">
        html,body,h1,h2,h3,h4,h5,p {
            font-family: "Times New Roman", Times, serif;
        }
        .row{ clear: both; }
        .col-lg-1 {width:8%;  float:left;}
        .col-lg-2 {width:16%; float:left;}
        .col-lg-3 {width:25%; float:left;}
        .col-lg-4 {width:33%; float:left;}
        .col-lg-5 {width:42%; float:left;}
        .col-lg-6 {width:50%; float:left;}
        .col-lg-7 {width:58%; float:left;}
        .col-lg-8 {width:66%; float:left;}
        .col-lg-9 {width:75%; float:left;}
        .col-lg-10{width:83%; float:left;}
        .col-lg-11{width:92%; float:left;}
        .col-lg-12{width:100%; float:left;}
        hr.new1 {
          border-top: 1px solid black;
        }
    </style>
    <h3 class="text-center">LEMBAR PERSETUJUAN SUBJEK PENELITIAN</h3>
    <hr class="new1">
	Saya yang bertandatangan di bawah ini, 
    <div class="row">
		<div class="col-lg-1">

		</div>
		<div class="col-lg-3">
			Nama
		</div>
		<div class="col-lg-8">
			: {{$ortu->name_ortu}}
		</div>
	</div>
    <div class="row">
		<div class="col-lg-1">

		</div>
		<div class="col-lg-3">
			Alamat
		</div>
		<div class="col-lg-8">
			: {{$ortu->address}}
		</div>
	</div>
    <br>
	Sebagai orang tua dari:
    <div class="row">
		<div class="col-lg-1">

		</div>
		<div class="col-lg-3">
			Nama
		</div>
		<div class="col-lg-8">
			: {{$user->name}}
		</div>
	</div>
    <div class="row">
		<div class="col-lg-1">

		</div>
		<div class="col-lg-3">
			Umur
		</div>
		<div class="col-lg-8">
			: {{$age}} tahun
		</div>
	</div>
    <div class="row">
		<div class="col-lg-1">

		</div>
		<div class="col-lg-3">
			Alamat
		</div>
		<div class="col-lg-8">
			: {{$ortu->address}}
		</div>
	</div>
    <br>
	Setelah mendapatkan penjelasan dan keterangan secara lengkap, menyatakan <b>bersedia</b> dan mengizinkan anak saya untuk melakukan pemeriksaan gigi demi kepentingan penelitian dari :
    <div class="row">
		<div class="col-lg-1">

		</div>
		<div class="col-lg-3">
			Nama
		</div>
		<div class="col-lg-8">
			: <b>Fadli Muhammad Fathoni</b>
		</div>
	</div>
    <div class="row">
		<div class="col-lg-1">

		</div>
		<div class="col-lg-3">
			NIM
		</div>
		<div class="col-lg-8">
			: <b>191610101125</b>
		</div>
	</div>
    <div class="row">
		<div class="col-lg-1">

		</div>
		<div class="col-lg-3">
			Fakultas
		</div>
		<div class="col-lg-8">
			: <b>Kedokteran Gigi Universitas Jember</b>
		</div>
	</div>
    <br> 
	Dengan Judul <b>“PENILAIAN REOUIRED TREATMENT INDEX (RTI) PADA ANAK SEKOLAH DASAR DI WILAYAH AGROINDUSTRI BOBBIN ARJASA KABUPATEN JEMBER MELALUI APLIKASI BERBASIS WEB "SIMETRI"”</b> dengan sebenar-benarnya tanpa ada suatu paksaan dari pihak manapun. 
    <div class="row">
		<div class="col-lg-6">
			<br>
			Saya yang bertandatangan,
		</div>
		<div class="col-lg-6">
			Jember, {{$tanggal}}<br>
			Peneliti,
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
		    @if($user->signature)
            <img src="{{public_path($user->signature)}}" style="width: 120px; height: 96px;"> 
            @endif
		</div>
		<div class="col-lg-6">
            <img src="{{public_path('ttd.jpg')}}" style="width: 120px; height: 96px;"> 
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			{{$ortu->name_ortu}}
		</div>
		<div class="col-lg-6">
			<b>Fadli Muhammad Fathoni</b>
        </div>
	</div>
</body>
</html>