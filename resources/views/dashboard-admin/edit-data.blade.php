<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <meta name="csrf-token" content="{{csrf_token()}}" />

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
    1 => 'Januari',
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

                    <h1 class="h3 mb-3">Edit Data Anak</h1>

                    <br>
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ app('request')->input('id') }}">
                                <h5>Biodata</h5>
                                <hr>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" value="{{$user->name}}" placeholder="Nama anak">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Jenis Kelamin</label>
                                    <select class="form-select" name="gender" id="gender" aria-label="Default select example">
                                        @foreach($gender as $g)
                                        @if($g == $biodata->gender)
                                        <option value="{{$g}}" selected>{{$g}}</option>
                                        @else
                                        <option value="{{$g}}">{{$g}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="exampleInputEmail1">Tempat Lahir</label>
                                            <input type="text" class="form-control" id="birthplace" name="birthplace" aria-describedby="emailHelp" value="{{$biodata->birth_place}}" placeholder="Tempat lahir">
                                        </div>
                                        <div class="col-6">
                                            <label for="exampleInputEmail1">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="birthdate" name="birthdate" aria-describedby="emailHelp" value="{{$biodata->birth_date}}" placeholder="Tanggal lahir">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Sekolah</label>
                                    <select class="form-select" name="sekolah" id="sekolah" aria-label="Default select example">
                                        @foreach($sekolah as $s)
                                        @if($s == $biodata->id_sekolah)
                                        <option value="{{$s}}" selected>{{$s}}</option>
                                        @else
                                        <option value="{{$s}}">{{$s}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <h5>Data Orang Tua</h5>
                                <hr>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Orang Tua</label>
                                    <input type="text" class="form-control" id="name_ortu" name="name_ortu" value="{{$ortu->name_ortu}}" aria-describedby="emailHelp" placeholder="Nama orang tua">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Alamat</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{$ortu->address}}" aria-describedby="emailHelp" placeholder="Alamat">
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Pendidikan Terakhir</label>
                                            <select class="form-select" name="pendidikan_terakhir" id="pendidikan_terakhir" aria-label="Default select example">
                                                @foreach($pendidikan as $p)
                                                @if($p == $ortu->pendidikan_terakhir)
                                                <option value="{{$p}}" selected>{{$p}}</option>
                                                @else
                                                <option value="{{$p}}">{{$p}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Pekerjaan</label>
                                            <select class="form-select" name="pekerjaan" id="pekerjaan" aria-label="Default select example">
                                                @foreach($pekerjaan as $p)
                                                @if($p == $ortu->pekerjaan)
                                                <option value="{{$p}}" selected>{{$p}}</option>
                                                @else
                                                <option value="{{$p}}">{{$p}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Gaji Orang Tua</label>
                                            <select class="form-select" name="gaji" id="gaji" aria-label="Default select example">
                                                <option>Pilih...</option>
                                                @foreach($label_gaji as $l)
                                                @if($l == $ortu->gaji)
                                                <option value="{{$l}}" selected>{{$l}}</option>
                                                @else
                                                <option value="{{$l}}">{{$l}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Luas rumah (m2)</label>
                                            <input type="text" class="form-control" id="luas_rumah" name="luas_rumah" value="{{$ortu->luas_rumah}}" aria-describedby="emailHelp" placeholder="Luas rumah" required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Daya Listrik (VA)</label>
                                            <select class="form-select" name="daya_listrik" id="daya_listrik" aria-label="Default select example" required>
                                                <option>Pilih...</option>
                                                @foreach($label_listrik as $l)
                                                @if($l == $ortu->daya_listrik)
                                                <option value="{{$l}}" selected>{{$l}}</option>
                                                @else
                                                <option value="{{$l}}">{{$l}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">No. HP</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{$ortu->phone}}" aria-describedby="emailHelp" placeholder="Nomor HP">
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
                                            <option value="{{$id_kecamatan}}" selected>{{$ortu->kecamatan}}</option>
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
                                            <option value="{{$id_desa}}" selected>{{$ortu->desa}}</option>
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
                                <h5>Foto Gigi</h5>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Foto Gigi Tampak Senyum Penuh</label><br>
                                            <small id="emailHelp" class="form-text text-muted" style="color: red;">Ukuran maksimum file: 2 MB dengan jenis file: JPG/JPEG.</small>
                                            <input type="file" class="form-control-file" id="gigi_senyum" name="gigi_senyum">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Foto Gigi Tampak Samping Kiri</label><br>
                                            <small id="emailHelp" class="form-text text-muted" style="color: red;">Ukuran maksimum file: 2 MB dengan jenis file: JPG/JPEG.</small>
                                            <input type="file" class="form-control-file" id="gigi_kiri" name="gigi_kiri">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tanggal Pengambilan Gambar Foto Gigi Tampak Senyum Penuh</label><br>
                                            <input type="date" class="form-control" id="date_gigi_senyum" name="date_gigi_senyum">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tanggal Pengambilan Gambar Foto Gigi Tampak Samping Kiri</label><br>
                                            <input type="date" class="form-control" id="date_gigi_kiri" name="date_gigi_kiri">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Foto Gigi Tampak Depan</label><br>
                                            <small id="emailHelp" class="form-text text-muted" style="color: red;">Ukuran maksimum file: 2 MB dengan jenis file: JPG/JPEG.</small>
                                            <input type="file" class="form-control-file" id="gigi_depan" name="gigi_depan">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Foto Gigi Tampak Atas</label><br>
                                            <small id="emailHelp" class="form-text text-muted" style="color: red;">Ukuran maksimum file: 2 MB dengan jenis file: JPG/JPEG.</small>
                                            <input type="file" class="form-control-file" id="gigi_atas" name="gigi_atas">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tanggal Pengambilan Foto Gigi Tampak Depan</label><br>
                                            <input type="date" class="form-control" id="date_gigi_depan" name="date_gigi_depan">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tanggal Pengambilan Foto Gigi Tampak Atas</label><br>
                                            <input type="date" class="form-control" id="date_gigi_atas" name="date_gigi_atas">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Foto Gigi Tampak Samping Kanan</label><br>
                                            <small id="emailHelp" class="form-text text-muted" style="color: red;">Ukuran maksimum file: 2 MB dengan jenis file: JPG/JPEG.</small>
                                            <input type="file" class="form-control-file" id="gigi_kanan" name="gigi_kanan">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Foto Gigi Tampak Bawah</label><br>
                                            <small id="emailHelp" class="form-text text-muted" style="color: red;">Ukuran maksimum file: 2 MB dengan jenis file: JPG/JPEG.</small>
                                            <input type="file" class="form-control-file" id="gigi_bawah" name="gigi_bawah">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tanggal Pengambilan Foto Gigi Tampak Samping Kanan</label><br>
                                            <input type="date" class="form-control" id="date_gigi_kanan" name="date_gigi_kanan">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tanggal Pengambilan Foto Gigi Tampak Bawah</label><br>
                                            <input type="date" class="form-control" id="date_gigi_bawah" name="date_gigi_bawah">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{asset('static/js/app.js')}}"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(function() {
                $('#kecamatan').on('change', function() {
                    let id_kecamatan = $('#kecamatan').val();
                    $.ajax({
                        type: 'POST',
                        url: "/getDesa",
                        data: {
                            id_district: id_kecamatan
                        },
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