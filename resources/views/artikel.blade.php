<!DOCTYPE html>
<html lang="en">

@include('layouts.header')

@php
function tanggal_indo($tanggal)
{
	$bulan = array (1 =>   'Januari',
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
	$split = explode('-', $tanggal);
	return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}
@endphp

<body>

  @include('layouts.navbar')

  <!-- ======= Hero Section ======= -->

  <main id="main">
    <!-- ======= Team Section ======= -->
    <section id="team" class="team section-bg">
      <div class="container">

        <div class="section-title">
          <h2 data-aos="fade-up">Artikel</h2>
          <p data-aos="fade-up">Hidup sehat dimulai dengan gigi yang lebih sehat.</p>
        </div>
        
        @foreach($artikel as $a)
        <h5>@php echo(tanggal_indo(date('Y-m-d', strtotime($a->created_at)))) @endphp</h5>
        <h4><a href="{{url('')}}/article/{{$a->link}}">{{$a->title}}</a></h4>
        <hr>
        @endforeach

      </div>
    </section><!-- End Team Section -->

  </main><!-- End #main -->

  @include('layouts.footer')

</body>

</html>