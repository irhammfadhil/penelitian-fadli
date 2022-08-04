<section id="team" class="team section-bg">
      <div class="container">

        <div class="section-title">
          <h2 data-aos="fade-up">Artikel</h2>
          <p data-aos="fade-up">Hidup sehat dimulai dengan gigi yang lebih sehat.</p>
        </div>

        <div class="row">

          @foreach($artikel as $a)

          <div class="col-lg-4 col-md-12 d-flex align-items-stretch" data-aos="fade-up">
            <div class="member">
              <div class="member-img" style="height: 15rem;">
                <img src="{{asset($a->image)}}" class="img-fluid" alt="">
              </div>
              <div class="member-info">
                <h4><a href="{{url('')}}/article/{{$a->link}}">{{$a->title}}</a></h4>
                <hr>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <div class="article-more" style="text-align: center;">
          <a class="btn btn-primary btn-lg" href="/article" role="button">Baca Semua Artikel</a>
        </div>

      </div>
    </section><!-- End Team Section -->