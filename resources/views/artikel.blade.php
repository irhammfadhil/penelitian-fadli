<!DOCTYPE html>
<html lang="en">

@include('layouts.header')

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
        <h5>{{date('Y-m-d', strtotime($a->created_at))}}</h5>
        <h4><a href="{{url('')}}/article/{{$a->link}}">{{$a->title}}</a></h4>
        <hr>
        @endforeach

      </div>
    </section><!-- End Team Section -->

  </main><!-- End #main -->

  @include('layouts.footer')

</body>

</html>