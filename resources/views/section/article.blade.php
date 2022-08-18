<section class="wrapper team section-bg">
  <div class="container-fostrap">
    <div class="section-title">
      <h2 data-aos="fade-up">Artikel</h2>
      <p data-aos="fade-up">Hidup sehat dimulai dengan gigi yang lebih sehat.</p>
    </div>
    <div class="content">
      <div class="container">
        <div class="row">
          @foreach($artikel as $a)
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="card">
              <a class="img-card" href="{{$a->image}}">
                <img src="{{asset($a->image)}}" class="img-fluid" />
              </a>
              <div class="card-content">
                <h4 class="card-title">
                  <a href="{{url('')}}/article/{{$a->link}}"> {{$a->title}}
                  </a>
                </h4>
              </div>
              <div class="card-read-more">
                <a href="{{url('')}}/article/{{$a->link}}" class="btn btn-link btn-block">
                  Baca Selengkapnya
                </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    <br>
    <div class="article-more" style="text-align: center;">
      <a class="btn btn-primary btn-lg" href="/article" role="button">Baca Semua Artikel</a>
    </div>
  </div>
</section>