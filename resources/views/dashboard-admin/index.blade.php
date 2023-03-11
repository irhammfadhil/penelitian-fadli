<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{asset('img/icons/icon-48x48.png')}}" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Simetri</title>

	<link href="{{asset('static/css/app.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>

<body>
	<div class="wrapper">
		@include('layouts.sidebar')

		<div class="main">
			@include('layouts.navbar-login')

			<main class="content">
				<div class="container-fluid p-0">

					<h1>Dashboard</h1>
					<br>
					<div class="row">
						<div class="col-lg-6">
							<h4>Rekapitulasi Responden</h4>
							<div id="container-report-overall"></div>
						</div>
						<div class="col-lg-6">
							<h4>Rekapitulasi Responden Berdasarkan Usia</h4>
							<div id="container-report-overall-by-age"></div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-6">
							<h4>Rekapitulasi Indeks DMF-T</h4>
							<div id="container-report-dmft"></div>
						</div>
						<div class="col-lg-6">
							<h4>Rekapitulasi Indeks def-t</h4>
							<div id="container-report-deft"></div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-6">
							<h4>Rekapitulasi Jumlah DMF usia 7-10 tahun</h4>
							<div id="container-report-dmf_7"></div>
						</div>
						<div class="col-lg-6">
							<h4>Rekapitulasi Jumlah DMF usia 10-12 tahun</h4>
							<div id="container-report-dmf_10"></div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-6">
							<h4>Rekapitulasi Jumlah def usia 7-10 tahun</h4>
							<div id="container-report-dmf_7_anak"></div>
						</div>
						<div class="col-lg-6">
							<h4>Rekapitulasi Jumlah def usia 10-12 tahun</h4>
							<div id="container-report-dmf_10_anak"></div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-6">
							<h4>Rekapitulasi Indeks RTI Gigi Tetap</h4>
							<div id="container-report-rti-tetap"></div>
						</div>
						<div class="col-lg-6">
							<h4>Rekapitulasi Indeks RTI Gigi Sulung</h4>
							<div id="container-report-rti-sulung"></div>
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
		Highcharts.chart('container-report-overall', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Rekapitulasi Responden Keseluruhan'
			},
			subtitle: {
				text: 'Sistem Informasi Penilaian Required Treatment Index Gigi Anak'
			},
			xAxis: {
				categories: <?php echo json_encode($gender_label) ?>,
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Rekapitulasi Responden'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.0f} orang</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Responden',
				data: <?php echo json_encode($gender_sum) ?>
			}]
		});
		Highcharts.chart('container-report-overall-by-age', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Rekapitulasi Responden Berdasarkan Usia'
			},
			subtitle: {
				text: 'Sistem Informasi Penilaian Required Treatment Index Gigi Anak'
			},
			xAxis: {
				categories: <?php echo json_encode($gender_label) ?>,
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Rekapitulasi Responden'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.0f} orang</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Usia 7-10 th',
				data: <?php echo json_encode($sum_79th) ?>
			}, {
				name: 'Usia 10-12 th',
				data: <?php echo json_encode($sum_912th) ?>
			},{
				name: 'Total',
				data: <?php echo json_encode($sum_total_by_age) ?>
			}]
		});
		Highcharts.chart('container-report-dmft', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Rekapitulasi Indeks DMF-T Berdasarkan Usia'
			},
			subtitle: {
				text: 'Sistem Informasi Penilaian Required Treatment Index Gigi Anak'
			},
			xAxis: {
				categories: <?php echo json_encode($gender_label) ?>,
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Indeks DMF-T'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.2f}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Usia 7-10 th',
				data: <?php echo json_encode($array_dmft_79) ?>
			}, {
				name: 'Usia 10-12 th',
				data: <?php echo json_encode($array_dmft_912) ?>
			}]
		});
		Highcharts.chart('container-report-dmf_7', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Rekapitulasi Jumlah DMF pada Anak Usia 7-10 Tahun'
			},
			subtitle: {
				text: 'Sistem Informasi Penilaian Required Treatment Index Gigi Anak'
			},
			xAxis: {
				categories: <?php echo json_encode($gender_label) ?>,
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Indeks DMF-T'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Decay Usia 7-10 th',
				data: <?php echo json_encode($array_decay_79) ?>
			},{
				name: 'Missing Usia 7-10 th',
				data: <?php echo json_encode($array_missing_79) ?>
			},{
				name: 'Filling Usia 7-10 th',
				data: <?php echo json_encode($array_filling_79) ?>
			}]
		});
		Highcharts.chart('container-report-dmf_10', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Rekapitulasi Jumlah DMF pada Anak Usia 10-12 Tahun'
			},
			subtitle: {
				text: 'Sistem Informasi Penilaian Required Treatment Index Gigi Anak'
			},
			xAxis: {
				categories: <?php echo json_encode($gender_label) ?>,
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Indeks DMF-T'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Decay Usia 10-12 th',
				data: <?php echo json_encode($array_decay_912) ?>
			},{
				name: 'Missing Usia 10-12 th',
				data: <?php echo json_encode($array_missing_912) ?>
			},{
				name: 'Filling Usia 10-12 th',
				data: <?php echo json_encode($array_filling_912) ?>
			}]
		});
		Highcharts.chart('container-report-dmf_7_anak', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Rekapitulasi Jumlah def pada Anak Usia 7-10 Tahun'
			},
			subtitle: {
				text: 'Sistem Informasi Penilaian Required Treatment Index Gigi Anak'
			},
			xAxis: {
				categories: <?php echo json_encode($gender_label) ?>,
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Indeks DMF-T'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Decay Usia 7-10 th',
				data: <?php echo json_encode($array_decay_79_anak) ?>
			},{
				name: 'Missing Usia 7-10 th',
				data: <?php echo json_encode($array_missing_79_anak) ?>
			},{
				name: 'Filling Usia 7-10 th',
				data: <?php echo json_encode($array_filling_79_anak) ?>
			}]
		});
		Highcharts.chart('container-report-dmf_10_anak', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Rekapitulasi Jumlah def pada Anak Usia 10-12 Tahun'
			},
			subtitle: {
				text: 'Sistem Informasi Penilaian Required Treatment Index Gigi Anak'
			},
			xAxis: {
				categories: <?php echo json_encode($gender_label) ?>,
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Indeks DMF-T'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Decay Usia 10-12 th',
				data: <?php echo json_encode($array_decay_912_anak) ?>
			},{
				name: 'Missing Usia 10-12 th',
				data: <?php echo json_encode($array_missing_912_anak) ?>
			},{
				name: 'Filling Usia 10-12 th',
				data: <?php echo json_encode($array_filling_912_anak) ?>
			}]
		});
		Highcharts.chart('container-report-deft', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Rekapitulasi Indeks def-t Berdasarkan Usia'
			},
			subtitle: {
				text: 'Sistem Informasi Penilaian Required Treatment Index Gigi Anak'
			},
			xAxis: {
				categories: <?php echo json_encode($gender_label) ?>,
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Indeks def-t'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.2f}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Usia 7-10 th',
				data: <?php echo json_encode($array_deft_79) ?>
			}, {
				name: 'Usia 10-12 th',
				data: <?php echo json_encode($array_deft_912) ?>
			}]
		});
		Highcharts.chart('container-report-rti-tetap', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Rekapitulasi Indeks RTI Gigi Tetap Berdasarkan Usia'
			},
			subtitle: {
				text: 'Sistem Informasi Penilaian Required Treatment Index Gigi Anak'
			},
			xAxis: {
				categories: <?php echo json_encode($gender_label) ?>,
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Indeks RTI Gigi Tetap'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.0f}%</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Usia 7-10 th',
				data: <?php echo json_encode($array_rti_79) ?>
			}, {
				name: 'Usia 10-12 th',
				data: <?php echo json_encode($array_rti_912) ?>
			}]
		});
		Highcharts.chart('container-report-rti-sulung', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Rekapitulasi Indeks RTI Gigi Sulung Berdasarkan Usia'
			},
			subtitle: {
				text: 'Sistem Informasi Penilaian Required Treatment Index Gigi Anak'
			},
			xAxis: {
				categories: <?php echo json_encode($gender_label) ?>,
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Indeks RTI Gigi Sulung'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.0f}%</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Usia 7-10 th',
				data: <?php echo json_encode($array_rti_sulung_79) ?>
			}, {
				name: 'Usia 10-12 th',
				data: <?php echo json_encode($array_rti_sulung_912) ?>
			}]
		});
	</script>



</body>

</html>