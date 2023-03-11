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

                    <h1 class="h3 mb-3">Laporan DMF-T Berdasarkan Sekolah</h1>

                    <br>
                    <div class="card">
                        <div class="card-body">
                            <form action="/report/bySchool" method="post">
                                @csrf
                                @if($result == 0)
                                <input type="hidden" name="type" value="dmft">
                                <div class="form-group">
                                    <label for="sekolah">Sekolah</label>
                                    <select class="form-control" id="sekolah" name="sekolah">
                                        <option value="">Pilih...</option>
                                        @foreach($sekolah as $s)
                                        <option value="{{$s}}">{{$s}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @elseif($result == 1)
                                <input type="hidden" name="type" value="dmft">
                                <div class="form-group">
                                    <label for="sekolah">Sekolah</label>
                                    <select class="form-control" id="sekolah" name="sekolah">
                                        <option value="">Pilih...</option>
                                        @foreach($sekolah as $s)
                                        @if($s == $sekolah_selected)
                                        <option value="{{$s}}" selected>{{$s}}</option>
                                        @else
                                        <option value="{{$s}}">{{$s}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <br>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                            <br>
                            @if($result == 1)
                            <h3>Berdasarkan Jenis Kelamin</h3>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center" style="width: 7.5%;">Jenis Kelamin</th>
                                            <th scope="col" class="text-center" style="width: 10%;">Jumlah Responden</th>
                                            <th scope="col" class="text-center" style="width: 10%;">D (decay)</th>
                                            <th scope="col" class="text-center" style="width: 10%;">M (missing)</th>
                                            <th scope="col" class="text-center" style="width: 10%;">F (filling)</th>
                                            <th scope="col" class="text-center" style="width: 10%;">Rata-rata Indeks DMF-T</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">Laki-laki</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_general as $q)
                                            @if($q->jenis_kelamin == 'Laki-laki')
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_79 + $jml_decay_lk_912}}</td>
                                            <td class="text-center">{{$jml_missing_lk_79 + $jml_missing_lk_912}}</td>
                                            <td class="text-center">{{$jml_filling_lk_79 + $jml_filling_lk_912}}</td>
                                            <td class="text-center"><b>{{number_format($q->rata_rata_dmft,1)}}</b></td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="text-center">Perempuan</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_general as $q)
                                            @if($q->jenis_kelamin == 'Perempuan')
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_pr_79 + $jml_decay_pr_912}}</td>
                                            <td class="text-center">{{$jml_missing_pr_79 + $jml_missing_pr_912}}</td>
                                            <td class="text-center">{{$jml_filling_pr_79 + $jml_filling_pr_912}}</td>
                                            <td class="text-center"><b>{{number_format($q->rata_rata_dmft,1)}}</b></td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="text-center" colspan="1">Total</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total as $q)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_79 + $jml_decay_lk_912 + $jml_decay_pr_79 + $jml_decay_pr_912}}</td>
                                            <td class="text-center">{{$jml_missing_lk_79 + $jml_missing_lk_912 + $jml_missing_pr_79 + $jml_missing_pr_912}}</td>
                                            <td class="text-center">{{$jml_filling_lk_79 + $jml_filling_lk_912 + $jml_filling_pr_79 + $jml_filling_pr_912}}</td>
                                            <td class="text-center"><b>{{number_format($q->rata_rata_dmft,1)}}</b></td>
                                            @php $found = 1; @endphp
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h3>Berdasarkan Kelompok Usia</h3>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center" style="width: 7.5%;">Kelompok Usia</th>
                                            <th scope="col" class="text-center" style="width: 10%;">Jumlah Responden</th>
                                            <th scope="col" class="text-center" style="width: 10%;">D (decay)</th>
                                            <th scope="col" class="text-center" style="width: 10%;">M (missing)</th>
                                            <th scope="col" class="text-center" style="width: 10%;">F (filling)</th>
                                            <th scope="col" class="text-center" style="width: 10%;">Rata-rata Indeks DMF-T</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="1" class="text-center">7 tahun</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total_by_age as $q)
                                            @if($q->age == 7)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_7 + $jml_decay_pr_7}}</td>
                                            <td class="text-center">{{$jml_missing_lk_7 + $jml_missing_pr_7}}</td>
                                            <td class="text-center">{{$jml_filling_lk_7 + $jml_filling_pr_7}}</td>
                                            <td class="text-center">{{number_format($q->rata_rata_dmft,1)}}</td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td rowspan="1" class="text-center">8 tahun</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total_by_age as $q)
                                            @if($q->age == 8)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_8 + $jml_decay_pr_8}}</td>
                                            <td class="text-center">{{$jml_missing_lk_8 + $jml_missing_pr_8}}</td>
                                            <td class="text-center">{{$jml_filling_lk_8 + $jml_filling_pr_8}}</td>
                                            <td class="text-center">{{number_format($q->rata_rata_dmft,1)}}</td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td rowspan="1" class="text-center">9 tahun</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total_by_age as $q)
                                            @if($q->age == 9)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_9 + $jml_decay_pr_9}}</td>
                                            <td class="text-center">{{$jml_missing_lk_9 + $jml_missing_pr_9}}</td>
                                            <td class="text-center">{{$jml_filling_lk_9 + $jml_filling_pr_9}}</td>
                                            <td class="text-center">{{number_format($q->rata_rata_dmft,1)}}</td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td rowspan="1" class="text-center">10 tahun</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total_by_age as $q)
                                            @if($q->age == 10)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_10 + $jml_decay_pr_10}}</td>
                                            <td class="text-center">{{$jml_missing_lk_10 + $jml_missing_pr_10}}</td>
                                            <td class="text-center">{{$jml_filling_lk_10 + $jml_filling_pr_10}}</td>
                                            <td class="text-center">{{number_format($q->rata_rata_dmft,1)}}</td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td rowspan="1" class="text-center">11 tahun</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total_by_age as $q)
                                            @if($q->age == 11)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_11 + $jml_decay_pr_11}}</td>
                                            <td class="text-center">{{$jml_missing_lk_11 + $jml_missing_pr_11}}</td>
                                            <td class="text-center">{{$jml_filling_lk_11 + $jml_filling_pr_11}}</td>
                                            <td class="text-center">{{number_format($q->rata_rata_dmft,1)}}</td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td rowspan="1" class="text-center">12 tahun</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total_by_age as $q)
                                            @if($q->age == 12)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_12 + $jml_decay_pr_12}}</td>
                                            <td class="text-center">{{$jml_missing_lk_12 + $jml_missing_pr_12}}</td>
                                            <td class="text-center">{{$jml_filling_lk_12 + $jml_filling_pr_12}}</td>
                                            <td class="text-center">{{number_format($q->rata_rata_dmft,1)}}</td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="text-center" colspan="1">Total</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total as $q)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_79 + $jml_decay_lk_912 + $jml_decay_pr_79 + $jml_decay_pr_912}}</td>
                                            <td class="text-center">{{$jml_missing_lk_79 + $jml_missing_lk_912 + $jml_missing_pr_79 + $jml_missing_pr_912}}</td>
                                            <td class="text-center">{{$jml_filling_lk_79 + $jml_filling_lk_912 + $jml_filling_pr_79 + $jml_filling_pr_912}}</td>
                                            <td class="text-center">{{number_format($q->rata_rata_dmft,1)}}</td>
                                            @php $found = 1; @endphp
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="text-center" colspan="5"><b>Indeks DMF-T Maksimum</b></td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total as $q)
                                            <td class="text-center"><b>{{number_format($max_dmft,1)}}</b> ({{$max_dmft_label}} tahun)</td>
                                            @php $found = 1; @endphp
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="text-center" colspan="5"><b>Indeks DMF-T Minimum</b></td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total as $q)
                                            <td class="text-center"><b>{{number_format($min_dmft,1)}}</b> ({{$min_dmft_label}} tahun)</td>
                                            @php $found = 1; @endphp
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="text-center" colspan="5"><b>Nilai DMF-T Rata-rata</b></td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total as $q)
                                            <td class="text-center"><b>{{number_format($q->rata_rata_dmft,1)}}</b></td>
                                            @php $found = 1; @endphp
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @endif
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
        $(document).ready(function() {
            $('#listAnak').DataTable();
        });
    </script>
</body>

</html>