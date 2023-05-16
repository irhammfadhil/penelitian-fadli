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
    <style>
        thead {
            border-top: 3px solid;
            border-bottom: 3px solid;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        @include('layouts.sidebar')

        <div class="main">
            @include('layouts.navbar-login')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Laporan RTI Berdasarkan Sekolah</h1>

                    <br>
                    <div class="card">
                        <div class="card-body">
                            <form action="/report/bySchool" method="post">
                                @csrf
                                @if($result == 0)
                                <input type="hidden" name="type" value="rti">
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
                                <input type="hidden" name="type" value="rti">
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
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col" rowspan="2" class="text-center align-middle" style="width: 7.5%;">Jenis Kelamin</th>
                                            <th scope="col" rowspan="2" class="text-center align-middle" style="width: 10%;">Subjek Penelitian</th>
                                            <th scope="col" rowspan="2" class="text-center align-middle" style="width: 10%;">d</th>
                                            <th scope="col" rowspan="2" class="text-center align-middle" style="width: 10%;">def-t</th>
                                            <th scope="col" rowspan="2" class="text-center align-middle" style="width: 10%;">D</th>
                                            <th scope="col" rowspan="2" class="text-center align-middle" style="width: 10%;">DMF-T</th>
                                            <th scope="col" class="text-center" colspan="2">RTI</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="text-center align-middle" style="width: 10%;">Gigi Sulung</th>
                                            <th scope="col" class="text-center align-middle" style="width: 10%;">Gigi Tetap</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">Laki-laki</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_general as $q)
                                            @if($q->jenis_kelamin == 'Laki-laki')
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_79_anak + $jml_decay_lk_912_anak}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_79_anak + $jml_decay_lk_912_anak + $jml_missing_lk_79_anak + $jml_missing_lk_912_anak + $jml_filling_lk_79_anak + $jml_filling_lk_912_anak)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{$jml_decay_lk_79 + $jml_decay_lk_912}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_79 + $jml_decay_lk_912 + $jml_missing_lk_79 + $jml_missing_lk_912 + $jml_filling_lk_79 + $jml_filling_lk_912)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_79_anak + $jml_decay_lk_912_anak)/($jml_decay_lk_79_anak + $jml_decay_lk_912_anak + $jml_missing_lk_79_anak + $jml_missing_lk_912_anak + $jml_filling_lk_79_anak + $jml_filling_lk_912_anak)*100,2)}} %</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_79 + $jml_decay_lk_912)/($jml_decay_lk_79+$jml_missing_lk_79+$jml_filling_lk_79 + $jml_decay_lk_912+$jml_missing_lk_912+$jml_filling_lk_912)*100,2)}} %</td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="text-center">Perempuan</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_general as $q)
                                            @if($q->jenis_kelamin == 'Perempuan')
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_pr_79_anak + $jml_decay_pr_912_anak}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_pr_79_anak + $jml_decay_pr_912_anak + $jml_missing_pr_79_anak + $jml_missing_pr_912_anak + $jml_filling_pr_79_anak + $jml_filling_pr_912_anak)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{$jml_decay_pr_79 + $jml_decay_pr_912}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_pr_79 + $jml_decay_pr_912 + $jml_missing_pr_79 + $jml_missing_pr_912 + $jml_filling_pr_79 + $jml_filling_pr_912)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_pr_79_anak + $jml_decay_pr_912_anak)/($jml_decay_pr_79_anak + $jml_decay_pr_912_anak + $jml_missing_pr_79_anak + $jml_missing_pr_912_anak + $jml_filling_pr_79_anak + $jml_filling_pr_912_anak)*100,2)}} %</td>
                                            <td class="text-center">{{number_format(($jml_decay_pr_79 + $jml_decay_pr_912)/($jml_decay_pr_79+$jml_missing_pr_79+$jml_filling_pr_79 + $jml_decay_pr_912+$jml_missing_pr_912+$jml_filling_pr_912)*100,2)}} %</td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            @endif
                                        </tr>
                                        <tr style="border-top: 3px solid; border-bottom: 3px solid;">
                                            <td class="text-center" colspan="1">Total</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total as $q)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center"><b>{{$jml_decay_lk_79_anak + $jml_decay_lk_912_anak + $jml_decay_pr_79_anak + $jml_decay_pr_912_anak}}</b></td>
                                            <td class="text-center"><b>{{number_format(($jml_decay_lk_79_anak + $jml_decay_lk_912_anak + $jml_missing_lk_79_anak + $jml_missing_lk_912_anak + $jml_filling_lk_79_anak + $jml_filling_lk_912_anak + $jml_decay_pr_79_anak + $jml_decay_pr_912_anak + $jml_missing_pr_79_anak + $jml_missing_pr_912_anak + $jml_filling_pr_79_anak + $jml_filling_pr_912_anak)/$q->jumlah,2)}}</b></td>
                                            <td class="text-center"><b>{{$jml_decay_lk_79 + $jml_decay_lk_912 + $jml_decay_pr_79 + $jml_decay_pr_912}}</b></td>
                                            <td class="text-center"><b>{{number_format(($jml_decay_lk_79 + $jml_decay_lk_912 + $jml_missing_lk_79 + $jml_missing_lk_912 + $jml_filling_lk_79 + $jml_filling_lk_912 + $jml_decay_pr_79 + $jml_decay_pr_912 + $jml_missing_pr_79 + $jml_missing_pr_912 + $jml_filling_pr_79 + $jml_filling_pr_912)/$q->jumlah,2)}}</b></td>
                                            <td class="text-center"><b>{{number_format(($jml_decay_lk_79_anak + $jml_decay_lk_912_anak + $jml_decay_pr_79_anak + $jml_decay_pr_912_anak)/($jml_decay_lk_79_anak + $jml_decay_lk_912_anak + $jml_missing_lk_79_anak + $jml_missing_lk_912_anak + $jml_filling_lk_79_anak + $jml_filling_lk_912_anak + $jml_decay_pr_79_anak + $jml_decay_pr_912_anak + $jml_missing_pr_79_anak + $jml_missing_pr_912_anak + $jml_filling_pr_79_anak + $jml_filling_pr_912_anak)*100,2)}} %</b></td>
                                            <td class="text-center"><b>{{number_format(($jml_decay_lk_79 + $jml_decay_lk_912 + $jml_decay_pr_79 + $jml_decay_pr_912)/($jml_decay_lk_79+$jml_missing_lk_79+$jml_filling_lk_79 + $jml_decay_lk_912+$jml_missing_lk_912+$jml_filling_lk_912 + $jml_decay_pr_79+$jml_missing_pr_79+$jml_filling_lk_79 + $jml_decay_pr_912+$jml_missing_pr_912+$jml_filling_pr_912)*100,2)}} %</b></td>
                                            @php $found = 1; @endphp
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h3>Berdasarkan Usia</h3>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col" rowspan="2" class="text-center align-middle" style="width: 7.5%;">Jenis Kelamin</th>
                                            <th scope="col" rowspan="2" class="text-center align-middle" style="width: 10%;">Subjek Penelitian</th>
                                            <th scope="col" rowspan="2" class="text-center align-middle" style="width: 10%;">d</th>
                                            <th scope="col" rowspan="2" class="text-center align-middle" style="width: 10%;">def-t</th>
                                            <th scope="col" rowspan="2" class="text-center align-middle" style="width: 10%;">D</th>
                                            <th scope="col" rowspan="2" class="text-center align-middle" style="width: 10%;">DMF-T</th>
                                            <th scope="col" class="text-center" colspan="2">RTI</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="text-center align-middle" style="width: 10%;">Gigi Tetap</th>
                                            <th scope="col" class="text-center align-middle" style="width: 10%;">Gigi Sulung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="1" class="text-center">7 tahun</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total_by_age as $q)
                                            @if($q->age == 7)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_7_anak + $jml_decay_pr_7_anak}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_7_anak + $jml_decay_pr_7_anak + $jml_missing_lk_7_anak + $jml_missing_pr_7_anak + $jml_filling_lk_7_anak + $jml_filling_pr_7_anak)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{$jml_decay_lk_7 + $jml_decay_pr_7}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_7 + $jml_decay_pr_7 + $jml_missing_lk_7 + $jml_missing_pr_7 + $jml_filling_lk_7 + $jml_filling_pr_7)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_7_anak + $jml_decay_pr_7_anak) / ($jml_decay_lk_7_anak + $jml_missing_lk_7_anak + $jml_filling_lk_7_anak + $jml_decay_pr_7_anak + $jml_missing_pr_7_anak + $jml_filling_pr_7_anak)*100,2)}} %</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_7 + $jml_decay_pr_7) / ($jml_decay_lk_7 + $jml_missing_lk_7 + $jml_filling_lk_7 + $jml_decay_pr_7 + $jml_missing_pr_7 + $jml_filling_pr_7)*100,2)}} %</td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td rowspan="1" class="text-center">8 tahun</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total_by_age as $q)
                                            @if($q->age == 8)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_8_anak + $jml_decay_pr_8_anak}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_8_anak + $jml_decay_pr_8_anak + $jml_missing_lk_8_anak + $jml_missing_pr_8_anak + $jml_filling_lk_8_anak + $jml_filling_pr_8_anak)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{$jml_decay_lk_8 + $jml_decay_pr_8}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_8 + $jml_decay_pr_8 + $jml_missing_lk_8 + $jml_missing_pr_8 + $jml_filling_lk_8 + $jml_filling_pr_8)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_8_anak + $jml_decay_pr_8_anak) / ($jml_decay_lk_8_anak + $jml_missing_lk_8_anak + $jml_filling_lk_8_anak + $jml_decay_pr_8_anak + $jml_missing_pr_8_anak + $jml_filling_pr_8_anak)*100,2)}} %</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_8 + $jml_decay_pr_8) / ($jml_decay_lk_8 + $jml_missing_lk_8 + $jml_filling_lk_8 + $jml_decay_pr_8 + $jml_missing_pr_8 + $jml_filling_pr_8)*100,2)}} %</td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td rowspan="1" class="text-center">9 tahun</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total_by_age as $q)
                                            @if($q->age == 9)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_9_anak + $jml_decay_pr_9_anak}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_9_anak + $jml_decay_pr_9_anak + $jml_missing_lk_9_anak + $jml_missing_pr_9_anak + $jml_filling_lk_9_anak + $jml_filling_pr_9_anak)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{$jml_decay_lk_9 + $jml_decay_pr_9}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_9 + $jml_decay_pr_9 + $jml_missing_lk_9 + $jml_missing_pr_9 + $jml_filling_lk_9 + $jml_filling_pr_9)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_9_anak + $jml_decay_pr_9_anak) / ($jml_decay_lk_9_anak + $jml_missing_lk_9_anak + $jml_filling_lk_9_anak + $jml_decay_pr_9_anak + $jml_missing_pr_9_anak + $jml_filling_pr_9_anak)*100,2)}} %</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_9 + $jml_decay_pr_9) / ($jml_decay_lk_9 + $jml_missing_lk_9 + $jml_filling_lk_9 + $jml_decay_pr_9 + $jml_missing_pr_9 + $jml_filling_pr_9)*100,2)}} %</td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td rowspan="1" class="text-center">10 tahun</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total_by_age as $q)
                                            @if($q->age == 10)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_10_anak + $jml_decay_pr_10_anak}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_10_anak + $jml_decay_pr_10_anak + $jml_missing_lk_10_anak + $jml_missing_pr_10_anak + $jml_filling_lk_10_anak + $jml_filling_pr_10_anak)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{$jml_decay_lk_10 + $jml_decay_pr_10}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_10 + $jml_decay_pr_10 + $jml_missing_lk_10 + $jml_missing_pr_10 + $jml_filling_lk_10 + $jml_filling_pr_10)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_10_anak + $jml_decay_pr_10_anak) / ($jml_decay_lk_10_anak + $jml_missing_lk_10_anak + $jml_filling_lk_10_anak + $jml_decay_pr_10_anak + $jml_missing_pr_10_anak + $jml_filling_pr_10_anak)*100,2)}} %</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_10 + $jml_decay_pr_10) / ($jml_decay_lk_10 + $jml_missing_lk_10 + $jml_filling_lk_10 + $jml_decay_pr_10 + $jml_missing_pr_10 + $jml_filling_pr_10)*100,2)}} %</td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td rowspan="1" class="text-center">11 tahun</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total_by_age as $q)
                                            @if($q->age == 11)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_11_anak + $jml_decay_pr_11_anak}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_11_anak + $jml_decay_pr_11_anak + $jml_missing_lk_11_anak + $jml_missing_pr_11_anak + $jml_filling_lk_11_anak + $jml_filling_pr_11_anak)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{$jml_decay_lk_11 + $jml_decay_pr_11}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_11 + $jml_decay_pr_11 + $jml_missing_lk_11 + $jml_missing_pr_11 + $jml_filling_lk_11 + $jml_filling_pr_11)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_11_anak + $jml_decay_pr_11_anak) / ($jml_decay_lk_11_anak + $jml_missing_lk_11_anak + $jml_filling_lk_11_anak + $jml_decay_pr_11_anak + $jml_missing_pr_11_anak + $jml_filling_pr_11_anak)*100,2)}} %</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_11 + $jml_decay_pr_11) / ($jml_decay_lk_11 + $jml_missing_lk_11 + $jml_filling_lk_11 + $jml_decay_pr_11 + $jml_missing_pr_11 + $jml_filling_pr_11)*100,2)}} %</td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td rowspan="1" class="text-center">12 tahun</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total_by_age as $q)
                                            @if($q->age == 12)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center">{{$jml_decay_lk_12_anak + $jml_decay_pr_12_anak}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_12_anak + $jml_decay_pr_12_anak + $jml_missing_lk_12_anak + $jml_missing_pr_12_anak + $jml_filling_lk_12_anak + $jml_filling_pr_12_anak)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{$jml_decay_lk_12 + $jml_decay_pr_12}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_12 + $jml_decay_pr_12 + $jml_missing_lk_12 + $jml_missing_pr_12 + $jml_filling_lk_12 + $jml_filling_pr_12)/$q->jumlah,2)}}</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_12_anak + $jml_decay_pr_12_anak) / ($jml_decay_lk_12_anak + $jml_missing_lk_12_anak + $jml_filling_lk_12_anak + $jml_decay_pr_12_anak + $jml_missing_pr_12_anak + $jml_filling_pr_12_anak)*100,2)}} %</td>
                                            <td class="text-center">{{number_format(($jml_decay_lk_12 + $jml_decay_pr_12) / ($jml_decay_lk_12 + $jml_missing_lk_12 + $jml_filling_lk_12 + $jml_decay_pr_12 + $jml_missing_pr_12 + $jml_filling_pr_12)*100,2)}} %</td>
                                            @php $found = 1; @endphp
                                            @endif
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            @endif
                                        </tr>
                                        <tr style="border-top: 3px solid; border-bottom: 3px solid;">
                                            <td class="text-center" colspan="1">Total</td>
                                            @php $found = 0; @endphp
                                            @foreach($query_total as $q)
                                            <td class="text-center"><b>{{$q->jumlah}}</b></td>
                                            <td class="text-center"><b>{{$jml_decay_lk_79_anak + $jml_decay_lk_912_anak + $jml_decay_pr_79_anak + $jml_decay_pr_912_anak}}</b></td>
                                            <td class="text-center"><b>{{number_format(($jml_decay_lk_79_anak + $jml_decay_lk_912_anak + $jml_missing_lk_79_anak + $jml_missing_lk_912_anak + $jml_filling_lk_79_anak + $jml_filling_lk_912_anak + $jml_decay_pr_79_anak + $jml_decay_pr_912_anak + $jml_missing_pr_79_anak + $jml_missing_pr_912_anak + $jml_filling_pr_79_anak + $jml_filling_pr_912_anak)/$q->jumlah,2)}}</b></td>
                                            <td class="text-center"><b>{{$jml_decay_lk_79 + $jml_decay_lk_912 + $jml_decay_pr_79 + $jml_decay_pr_912}}</b></td>
                                            <td class="text-center"><b>{{number_format(($jml_decay_lk_79 + $jml_decay_lk_912 + $jml_missing_lk_79 + $jml_missing_lk_912 + $jml_filling_lk_79 + $jml_filling_lk_912 + $jml_decay_pr_79 + $jml_decay_pr_912 + $jml_missing_pr_79 + $jml_missing_pr_912 + $jml_filling_pr_79 + $jml_filling_pr_912)/$q->jumlah,2)}}</b></td>
                                            <td class="text-center"><b>{{number_format(($jml_decay_lk_79_anak + $jml_decay_lk_912_anak + $jml_decay_pr_79_anak + $jml_decay_pr_912_anak)/($jml_decay_lk_79_anak + $jml_decay_lk_912_anak + $jml_missing_lk_79_anak + $jml_missing_lk_912_anak + $jml_filling_lk_79_anak + $jml_filling_lk_912_anak + $jml_decay_pr_79_anak + $jml_decay_pr_912_anak + $jml_missing_pr_79_anak + $jml_missing_pr_912_anak + $jml_filling_pr_79_anak + $jml_filling_pr_912_anak)*100,2)}} %</b></td>
                                            <td class="text-center"><b>{{number_format(($jml_decay_lk_79 + $jml_decay_lk_912 + $jml_decay_pr_79 + $jml_decay_pr_912)/($jml_decay_lk_79+$jml_missing_lk_79+$jml_filling_lk_79 + $jml_decay_lk_912+$jml_missing_lk_912+$jml_filling_lk_912 + $jml_decay_pr_79+$jml_missing_pr_79+$jml_filling_lk_79 + $jml_decay_pr_912+$jml_missing_pr_912+$jml_filling_pr_912)*100,2)}} %</b></td>
                                            @php $found = 1; @endphp
                                            @endforeach
                                            @if(!$found)
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0</b></td>
                                            <td class="text-center"><b>0%</b></td>
                                            <td class="text-center"><b>0%</b></td>
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
    <script>
        $(document).ready(function() {
            $('#listAnak').DataTable();
        });
    </script>
</body>

</html>