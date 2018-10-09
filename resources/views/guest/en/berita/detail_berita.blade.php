@extends('layouts.guest.app')

@section('title')
Universitas Hindu Indonesia
@endsection

@section('content')
<a id="start"></a>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v3.0&appId=971477629686903&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
{{-- BEGIN: Header --}}
@include('layouts.guest.header_english')
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
                        NEWS
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
                            <span>{{$berita->nama_berita}}</span>
                        </h2>
                        <ul class="entry-meta">
                            <li class="post-date">{{$berita->tgl_rilis->format('l, d F Y')}}</li>
                            <li class="post-author">{{$berita->user->nama}}</li>
                            <li class="post-reads">{{$berita->views}}</li>
                        </ul>
                        <hr>
                    </div>
                    <div class="post-content">
                        <img alt="Image" src="{{ URL::asset($berita->thumbnail_url) }}" />
                        {!!$berita->konten!!}
                    </div>
                </article>


                <div class="blog-comments">
                    <div class="fb-comments" data-href="http://127.0.0.1:8000/id/berita/detail-berita/{{$berita->slug}}" data-width="100%" data-numposts="5"></div>
                </div>
            </div>
            <!--end masonry-->
        </div>
        @include('layouts.guest.sidebar_berita')
        </div>
        <!--end of row-->
    </div>
    <!--end of container-->
</section>
        

{{-- BEGIN: Footer --}}
@include('layouts.guest.footer_english')
</div>
{{-- END: Footer  --}}
@endsection

