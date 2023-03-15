<!DOCTYPE html>
<html>

<head>
    <title>Laporan a.n. {{$user->name}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }

        .page_break {
            page-break-before: always;
        }

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
        html,
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        p {
            font-family: "Times New Roman", Times, serif;
        }

        .row {
            clear: both;
        }

        .col-lg-1 {
            width: 8%;
            float: left;
        }

        .col-lg-2 {
            width: 16%;
            float: left;
        }

        .col-lg-3 {
            width: 25%;
            float: left;
        }

        .col-lg-4 {
            width: 33%;
            float: left;
        }

        .col-lg-5 {
            width: 42%;
            float: left;
        }

        .col-lg-6 {
            width: 50%;
            float: left;
        }

        .col-lg-7 {
            width: 58%;
            float: left;
        }

        .col-lg-8 {
            width: 66%;
            float: left;
        }

        .col-lg-9 {
            width: 75%;
            float: left;
        }

        .col-lg-10 {
            width: 83%;
            float: left;
        }

        .col-lg-11 {
            width: 92%;
            float: left;
        }

        .col-lg-12 {
            width: 100%;
            float: left;
        }

        hr.new1 {
            border-top: 1px solid black;
        }

        .page_break {
            page-break-before: always;
        }
    </style>
    <div class="row">
        <div class="col-lg-2">
            <img src="{{public_path('logo-unej.png')}}" style="width: auto; height: 125px;">
        </div>
        <div class="col-lg-9">
            <h3 class="text-center">Laporan Hasil Diagnosis</h3>
            <h3 class="text-center">SIMETRI</h3>
            <h5 class="text-center" style="font-size:18px;">Sistem Informasi Penilaian Required Treatment Index Gigi Anak</h5>
            <h5 class="text-center" style="font-size:20px;">Fakultas Kedokteran Gigi Universitas Jember</h5>
        </div>
    </div>
    <br><br><br><br><br><br>
    <hr>
    <h5>Informasi Pribadi</h5>
    <div class="row">
        <div class="col-lg-3">
            Nama
        </div>
        <div class="col-lg-9">
            : {{$user->name}}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Alamat Email
        </div>
        <div class="col-lg-9">
            : {{$user->email}}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Waktu Pendaftaran
        </div>
        <div class="col-lg-9">
            : {{$tanggal_daftar}}
        </div>
    </div>
    @if($biodata)
    <div class="row">
        <div class="col-lg-3">
            Jenis Kelamin
        </div>
        <div class="col-lg-9">
            : {{$biodata->gender}}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Tempat dan Tanggal Lahir
        </div>
        <div class="col-lg-9">
            : {{$biodata->birth_place}}, {{$tanggal_lahir}}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Sekolah
        </div>
        <div class="col-lg-9">
            : {{$biodata->id_sekolah}}
        </div>
    </div>
    <br>
    @endif
    @if($ortu)
    <hr>
    <h5>Informasi Orang Tua</h5>
    <div class="row">
        <div class="col-lg-3">
            Nama Orang Tua
        </div>
        <div class="col-lg-9">
            : {{$ortu->name_ortu}}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Alamat Orang Tua
        </div>
        <div class="col-lg-9">
            : {{$ortu->address}}, RT {{$ortu->rt}} RW {{$ortu->rw}}, {{$ortu->desa}}, {{$ortu->kecamatan}}, Kabupaten
            Jember
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Pendidikan Orang Tua
        </div>
        <div class="col-lg-9">
            : {{$ortu->pendidikan_terakhir}}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Pekerjaan Orang Tua
        </div>
        <div class="col-lg-9">
            : {{$ortu->pekerjaan}}
        </div>
    </div>
    <br>
    @endif
    @if($foto)
    <hr>
    <h5>Foto Gigi</h5>
    <br>
    <div class="row">
        <div class="col-lg-3">
            Foto Gigi Tampak Senyum Penuh
        </div>
        <div class="col-lg-9">
            @if($foto->foto_senyum)
            : <img src="{{public_path($foto->foto_senyum)}}" style="width: 200px; height: auto;">
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Tanggal Pengambilan Foto
        </div>
        <div class="col-lg-9">
            : {{$tanggal_foto_senyum}}
        </div>
    </div>
    <br><br><br>
    <div class="row">
        <div class="col-lg-3">
            Foto Gigi Tampak Depan
        </div>
        <div class="col-lg-9">
            @if($foto->foto_depan)
            : <img src="{{public_path($foto->foto_depan)}}" style="width: 200px; height: auto;">
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Tanggal Pengambilan Foto
        </div>
        <div class="col-lg-9">
            : {{$tanggal_foto_depan}}
        </div>
    </div>
    <br><br><br>
    <div class="page_break"></div>
    <div class="row">
        <div class="col-lg-3">
            Foto Gigi Tampak Kiri
        </div>
        <div class="col-lg-9">
            @if($foto->foto_kiri)
            : <img src="{{public_path($foto->foto_kiri)}}" style="width: 200px; height: auto;">
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Tanggal Pengambilan Foto
        </div>
        <div class="col-lg-9">
            : {{$tanggal_foto_kiri}}
        </div>
    </div>
    <br><br><br>
    <div class="row">
        <div class="col-lg-3">
            Foto Gigi Tampak Atas
        </div>
        <div class="col-lg-9">
            @if($foto->foto_atas)
            : <img src="{{public_path($foto->foto_atas)}}" style="width: 200px; height: auto;">
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Tanggal Pengambilan Foto
        </div>
        <div class="col-lg-9">
            : {{$tanggal_foto_atas}}
        </div>
    </div>
    <br><br><br>
    <div class="row">
        <div class="col-lg-3">
            Foto Gigi Tampak Kanan
        </div>
        <div class="col-lg-9">
            @if($foto->foto_kanan)
            : <img src="{{public_path($foto->foto_kanan)}}" style="width: 200px; height: auto;">
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Tanggal Pengambilan Foto
        </div>
        <div class="col-lg-9">
            : {{$tanggal_foto_kanan}}
        </div>
    </div>
    <br><br><br>
    <div class="row">
        <div class="col-lg-3">
            Foto Gigi Tampak Bawah
        </div>
        <div class="col-lg-9">
            @if($foto->foto_bawah)
            : <img src="{{public_path($foto->foto_bawah)}}" style="width: 200px; height: auto;">
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Tanggal Pengambilan Foto
        </div>
        <div class="col-lg-9">
            : {{$tanggal_foto_bawah}}
        </div>
    </div>
    @endif
    @if($diagnosis)
    <div class="page_break"></div>
    <h5>Diagnosis</h5>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            D/d: <b>{{$sum_decay_tetap}}/{{$sum_decay_susu}}</b> M/e:
            <b>{{$sum_missing_tetap}}/{{$sum_missing_susu}}</b> F/f: <b>{{$sum_filling_tetap}}/{{$sum_filling_susu}}</b>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">DMFT: <b>{{$user->dmft_score}}</b></div>
        <div class="col-lg-8">Kriteria DMFT: <b>{{$kriteria_dmft}}</b></div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-2">def-t: <b>{{$user->deft_score}}</b></div>
        <div class="col-lg-8">Kriteria def-t: <b>{{$kriteria_deft}}</b></div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12">
            @if($user->dmft_score == 0)
            RTI Gigi Tetap: <b>0%</b>
            @else
            RTI Gigi Tetap: <b>{{number_format($sum_decay_tetap/$user->dmft_score, 2)*100}}%</b>
            @endif
            <br>
            @if($user->deft_score == 0)
            RTI Gigi Sulung: <b>0%</b>
            @else
            RTI Gigi Sulung: <b>{{number_format($sum_decay_susu/$user->deft_score, 2)*100}}%</b>
            @endif
            <br><br>
        </div>
    </div>
    <h5>Saran</h5>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            {{$user->comments}}
        </div>
    </div>
    @endif
</body>

</html>