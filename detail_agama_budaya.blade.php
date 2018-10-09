@extends('layouts.guest.app')

@section('title')
Universitas Hindu Indonesia
@endsection

@section('content')
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v3.0&appId=971477629686903&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
{{-- BEGIN: Header --}}
@include('layouts.guest.header')
{{-- END: Header  --}}
<div class="main-container">
<section class="imagebg unpad">
    <div class="background-image-holder" style="height: 280px;">
        <img alt="background" src="{{ URL::asset('guest/img/gallery/pura_unhi.jpg') }}" />
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="headtitle">
                    <h1 class="title">
                        AGAMA BUDAYA
                    </h1>
                </div>
            </div>
        </div><!--end of row-->
    </div><!--end of container-->
</section>
<section style="padding-top: 50px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8">
            <div class="masonry">
                <article class="single-post">
                    <div class="post-heading">
                        <h2 class="post-title">
                            <span>{{$agama_budaya->nama_agamabudaya}}</span>
                        </h2>
                        <ul class="entry-meta">
                            <li class="post-date">{{$agama_budaya->created_at->format('l, d F Y')}}</li>
                            <li class="post-author">{{$agama->user->nama}}</li>
                            <li class="post-reads">{{$agama_budaya->views}}</li>
                        </ul>
                        <hr>
                    </div>
                    <div class="post-content">
                        <img alt="Image" src="{{ URL::asset($agama_budaya->thumbnail_url) }}" />
                        {!!$agama_budaya->konten!!}
                    </div>
                </article>


                <div class="blog-comments">
                    <div class="fb-comments" data-href="http://127.0.0.1:8000/id/berita/detail-berita/{{$agama_budaya->slug}}" data-width="100%" data-numposts="5"></div>
                </div>
            </div>
            <!--end masonry-->
        </div>
        <div class="col-lg-4 hidden-sm">
        <div class="sidebar boxed boxed--border bg--secondary" style="padding:0px;">
            <div class="sidebar__widget">
                <h3 class="sidebar-titlehead type--bold">
                    Agama Budaya
                </h3>
                @foreach($sidebar_agamas as $sidebar )
                <div class="sidebar-content">
                    <a class="a-black" href="{{route('id.detail_agama_budaya', $sidebar->slug)}}">
                        <h5 class="berita-title">{{$sidebar->nama_agamabudaya}}</h5>
                    </a>                                
                    <p class="berita-content" style="margin-bottom: 15px;">{{ strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",($sidebar->konten)))}}</p>
                    <span class="date-widget">{{$sidebar->created_at->format('l, d F Y')}}</span>
                    <hr class="line-hr">
                </div>
                @endforeach
            </div>
            <!--end widget-->
        </div>
    </div>
        </div>
        <!--end of row-->
    </div>
    <!--end of container-->
</section>
        

{{-- BEGIN: Footer --}}
@include('layouts.guest.footer')
</div>
{{-- END: Footer  --}}
@endsection

