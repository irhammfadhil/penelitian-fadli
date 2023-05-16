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
    <script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.1/tinymce.min.js"></script>
</head>

<body>
	<div class="wrapper">
		@include('layouts.sidebar')

		<div class="main">
			@include('layouts.navbar-login')

			<main class="content">
				<div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Edit Artikel</h1>
					<br>
					<div class="card">
						<div class="card-body">
                            <form action="/admin/artikel/edit" method="post" enctype="multipart/form-data">
                                @csrf
								<input type="hidden" name="id" value="{{ app('request')->input('id') }}">
                                <div class="form-group">
                                    <label for="namajalur">Judul Artikel(*)</label>
                                    <input type="text" name="title" id="title" placeholder="Judul Artikel/Berita" value="{{$article->title}}" class="form-control" required>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="tglbuka">Deskripsi Artikel(*)</label>
                                    <textarea name="deskripsi" rows="10" id="deskripsi" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan deskripsi">{{$article->text}}</textarea>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="tglbuka">Input Ulang Gambar Artikel</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file" name="file">
                                    </div>
                                </div>
                                <br>
                                <input type="submit" class="btn btn-primary btn-user btn-block" value="Submit">
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
		$(document).ready( function () {
			$('#listAnak').DataTable();
		} );
        tinymce.init({
            selector: '#deskripsi',
            height: 300,
            theme: 'modern',
            plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true,
            images_upload_url : '/upload_img'
        });
	</script>
</body>

</html>