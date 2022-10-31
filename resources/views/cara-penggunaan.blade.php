<!DOCTYPE html>
<html lang="en">

@include('layouts.header')

<body>

  @include('layouts.navbar')

  <!-- ======= Hero Section ======= -->

  <main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="/">Home</a></li>
          <li>Cara Penggunaan </li>
        </ol>
        <h2>Cara Pendaftaran dan Penggunaan</h2>
      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page pt-3">
      <div class="container">
        <h4>Cara Pendaftaran</h4>
        <ol>
          <li>Klik tombol Daftar di halaman Beranda</li>
          <li>Membuat akun dengan cara mengisi nama, nama pengguna, alamat e-mail dan password</li>
          <li>Setelah mendaftar maka pengguna akan diarahkan ke akun masing-masing</li>
          <li>Jika pengguna sudah terdaftar maka pengguna dapat langsung masuk ke aplikasi Simetri dengan memasukkan nama pengguna dan password kemudian klik tombol Login</li> 
        </ol>
        <hr>
        <h4>Cara Penggunaan</h4>
        <ol>
          <li>Mengisi biodata Anak</li>
          <li>Mengisi biodata Orang tua</li>
          <li>Menandatangani Informed Consent</li>
          <li>Mengunggah foto gigi sesuai video tutorial pengambilan foto gigi yang benar</li>
          <li>Melihat hasil pemeriksaan gigi di halaman laporan setelah dianalisa oleh tim berupa kondisi kesehatan gigi (jumlah gigi decay, hilang dan tumpatan)</li>
        </ol>
        <hr>
        <h4>Cara Pengambilan Foto Gigi yang Benar</h4>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/R10IvWw5Jvs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </section>

  </main><!-- End #main -->

  @include('layouts.footer')

</body>

</html>