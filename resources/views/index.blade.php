<!DOCTYPE html>
<html lang="en">

@include('layouts.header')

<body>

  @include('layouts.navbar')

  <!-- ======= Hero Section ======= -->

  @include('section.banner')

  <main id="main">

    <!-- ======= Why Us Section ======= -->
    @include('section.fitur')

    <!-- ======= About Section ======= -->
    @include('section.about')

    <!-- ======= F.A.Q Section ======= -->
    @include('section.faq')

    <!-- ======= Services Section ======= -->
    @include('section.step')

    <!-- ======= Testimonials Section ======= -->
    @include('section.register')

    <!-- ======= Team Section ======= -->
    @include('section.article')

    <!-- ======= Portfolio Section ======= -->
    @include('section.gallery')
    
    <!-- ======= Contact Section ======= -->
    @include('section.contact')

  </main><!-- End #main -->

  @include('layouts.footer')

</body>

</html>