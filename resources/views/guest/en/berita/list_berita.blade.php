@extends('layouts.guest.app')

@section('title')
Universitas Hindu Indonesia
@endsection

@section('content')
<a id="start"></a>
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
<section style="padding-top: 25px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8">
            <div class="masonry">
                <h2 style="margin-bottom: 1.2em;" class="line-full-width">
                    <span class="span-line">Headline News</span>
                </h2>
                <div class="slider" data-arrows="true" data-paging="true">
                    <ul class="slides">
                        @foreach($headlines as $headline)
                        <li>
                            <a class="block" href="{{ route('id.detail_berita', $headline->slug)}}">
                                <article class="imagebg border--round headline-box" data-scrim-bottom="8">
                                    <div class="background-image-holder">
                                        <img alt="background" src="{{ URL::asset($headline->thumbnail_url) }}" />
                                    </div>
                                    <div class="headline-mark">
                                        <span>Headline</span>
                                    </div>
                                    <div class="article__title headline-bg">
                                        <h4 class="headline-title">{{$headline->nama_berita}}</h4>
                                        <p class="headline-content line-clamp-head">{{ strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",($headline->konten)))}}</p>
                                    </div>
                                </article>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <hr>
                <h3 style="margin-bottom: 1.1em;" class="line-full-width">
                    <span class="span-line">Latest News</span>
                </h3>
                <div class="row">
                    @foreach($beritas as $berita)
                    <div class="col-md-6">
                        <article class="feature feature-1">
                            <a href="{{ route('id.detail_berita', $berita->slug)}}" class="block">
                                <img alt="Image" src="{{ URL::asset($berita->thumbnail_url) }}" />
                            </a>
                            <div class="feature__body boxed boxed--border">
                                <span>{{$berita->tgl_rilis->format('l, d F Y')}}</span>
                                <a class="a-black" href="{{ route('id.detail_berita', $berita->slug)}}">
                                    <h5 class="berita-title">{{$berita->nama_berita}}</h5>
                                </a>                                
                                <p class="berita-content">{{ strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",($berita->konten)))}}</p>
                            </div>
                        </article>
                    </div>
                    @endforeach
                    <!--end item-->
                </div>
                <!--end of masonry container-->
                <div class="pagination">
                    <ol>
                        {!! $beritas->links();!!}
                    </ol>
                </div>
            </div>
            <!--end masonry-->
        </div>
        <div class="col-lg-4 d-none d-sm-block">
            <div class="sidebar boxed boxed--border bg--secondary" style="padding:0px;">
                <div class="sidebar__widget">
                    <h3 class="sidebar-titlehead type--bold">
                        Popular News
                    </h3>
                    @foreach($top_news as $sidebar )
                    <div class="sidebar-content">
                        <a class="a-black" href="{{ route('id.detail_berita', $sidebar->slug)}}">
                            <h5 class="berita-title">{{$sidebar->nama_berita}}</h5>
                        </a>                                
                        <p class="berita-content" style="margin-bottom: 15px;">{{ strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",($sidebar->konten)))}}</p>
                            <span class="date-widget">{{$sidebar->tgl_rilis->format('l, d F Y')}}  |  {{$sidebar->views}} views</span>
                        <hr class="line-hr">
                    </div>
                    @endforeach
                </div>
                <!--end widget-->
            </div>
        </div>
        </div>
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

