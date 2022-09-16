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
    {{--@include('section.gallery')--}}

    <!-- ======= Contact Section ======= -->
    {{--@include('section.contact')--}}

  </main><!-- End #main -->

  @include('layouts.footer')

  <style>

    .wrapper {
      display: table;
      height: 100%;
      width: 100%;
    }

    .container-fostrap {
      display: table-cell;
      padding: 1em;
      text-align: center;
      vertical-align: middle;
    }

    .fostrap-logo {
      width: 100px;
      margin-bottom: 15px
    }

    h1.heading {
      color: #fff;
      font-size: 1.15em;
      font-weight: 900;
      margin: 0 0 0.5em;
      color: #505050;
    }

    @media (min-width: 450px) {
      h1.heading {
        font-size: 3.55em;
      }
    }

    @media (min-width: 760px) {
      h1.heading {
        font-size: 3.05em;
      }
    }

    @media (min-width: 900px) {
      h1.heading {
        font-size: 3.25em;
        margin: 0 0 0.3em;
      }
    }

    .card {
      display: block;
      margin-bottom: 20px;
      line-height: 1.42857143;
      background-color: #fff;
      border-radius: 2px;
      box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
      transition: box-shadow .25s;
    }

    .card:hover {
      box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .img-card {
      width: 100%;
      height: 200px;
      border-top-left-radius: 2px;
      border-top-right-radius: 2px;
      display: block;
      overflow: hidden;
    }

    .img-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: all .25s ease;
    }

    .card-content {
      padding: 15px;
      text-align: left;
    }

    .card-title {
      margin-top: 0px;
      font-weight: 700;
      font-size: 1.65em;
      height: 8rem;
    }

    @media screen and (max-width: 767px) {
      .card-title {
        height: 5rem;
      }
    }

    @media screen and (min-width: 1400px) {
      .card-title {
        height: 5rem;
      }
    }

    .card-title a {
      color: #000;
      text-decoration: none !important;
    }

    .card-read-more {
      border-top: 1px solid #D4D4D4;
    }

    .card-read-more a {
      text-decoration: none !important;
      padding: 10px;
      font-weight: 600;
      text-transform: uppercase
    }
  </style>


  <script>
    $(window).scroll(function() {
      $('.fadedfx').each(function() {
        var imagePos = $(this).offset().top;

        var topOfWindow = $(window).scrollTop();
        if (imagePos < topOfWindow + 500) {
          $(this).addClass("fadeIn");
        }
      });
    });
  </script>

</body>

</html>