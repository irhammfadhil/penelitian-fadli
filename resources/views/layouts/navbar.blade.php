  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center" style="background-color: #1d443f;">
    <div class="container d-flex align-items-center justify-content-between"> 

      <div class="logo">
        <!-- Uncomment below if you prefer to use an image logo -->
       <a href="/"><h1 style="color: #f7eb3a;">SIMETRI</h1></a>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          @if(Route::is('index'))
          <li><a class="nav-link scrollto active" href="/">Beranda</a></li>
          @else
          <li><a class="nav-link scrollto" href="/">Beranda</a></li>
          @endif
          @if(str_contains(url()->current(), '/cara-penggunaan'))
          <li><a class="nav-link scrollto active" href="/cara-penggunaan">Cara Penggunaan</a></li>
          @else
          <li><a class="nav-link scrollto" href="/cara-penggunaan">Cara Penggunaan</a></li>
          @endif
          @if(str_contains(url()->current(), '/article'))
          <li><a class="nav-link scrollto active" href="/article">Artikel</a></li>
          @else
          <li><a class="nav-link scrollto" href="/article">Artikel</a></li>
          @endif
          {{--@if(str_contains(url()->current(), '/tanya-jawab'))
          <li><a class="nav-link scrollto active" href="/tanya-jawab">Tanya Jawab</a></li>
          @else
          <li><a class="nav-link scrollto" href="/tanya-jawab">Tanya Jawab</a></li>
          @endif--}}
          @if(str_contains(url()->current(), '/login') || str_contains(url()->current(), '/register') || str_contains(url()->current(), '/forget-password'))
          <li><a class="nav-link scrollto active" href="/login">Daftar</a></li>
          @else
          <li><a class="nav-link scrollto" href="/login">Daftar</a></li>
          @endif
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->