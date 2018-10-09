@extends('layouts.guest.app')

@section('title')
Universitas Hindu Indonesia
@endsection

@section('content')
<a id="start"></a>
{{-- BEGIN: Header --}}
@include('layouts.guest.header')
{{-- END: Header  --}}
<div class="main-container">
<section class="cover unpad switchable switchable--switch bg--secondary text-center-xs">
    <div class="row align-items-center justify-content-around">
        <div class="col-md-12">
            <div class="slider" data-arrows="true" data-paging="true">
                <ul class="slides full-slider">
                    @foreach($sliders as $slider)
                        <li >
                            <img class="slider-img" alt="Image" src="{{ URL::asset($slider->thumbnail_url) }}" />
                            <div class="slider-in">
                                <div class="slider-title">
                                    {{$slider->nama_slider}}
                                </div>
                                <div class="slider-content bottom-left">
                                    <div class="entry-content"><p>{!! $slider->konten !!}</p></div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!--end of container-->
</section>

<section class="section-style">
    <div class="container">
        <div class="row">
            <div class="col-md-8 h" style="margin-top: 0">
                <h2 style="margin-bottom: 1.2em;" class="line-full-width">
                    <span class="span-line">Pengumuman</span>
                </h2>
                <div class="row">
                    @foreach($pengumumans as $i=> $pengumuman)
                    <div class="col-md-4 col-6">
                        <div class="card card-2 m-t-0 m-b-0">
                            <div class="card__top">
                                <a href="{{route('id.detail_pengumuman',$pengumuman->slug)}}">
                                    @if( !empty($pengumuman->thumbnail_url))
                                        <img class="bg-holder-info" alt="Image" src="{{ URL::asset($pengumuman->thumbnail_url) }}" />
                                    @elseif(empty($pengumuman->thumbnail_url)&&$i==0)
                                        <img class="bg-holder-info" alt="Image" src="{{ URL::asset('guest/img/lib/p1.jpg') }}" />
                                    @else
                                        <img class="bg-holder-info" alt="Image" src="{{ URL::asset('guest/img/lib/p2.jpg') }}" />
                                    @endif
                                </a>
                            </div>
                            <div class="card_info">
                                <a class="a-black" href="{{route('id.detail_pengumuman',[$pengumuman->slug])}}">
                                    <h5 class="info-title2 line-clamp">{{$pengumuman->nama_pengumuman}}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-4 col-6 d-none d-sm-block">
                        <div class="card card-2 m-t-0">
                            <div class="card__top">
                                <a href="{{route('id.detail_pengumuman',$pengumuman_mobile->slug)}}">
                                    @if( !empty($pengumuman_mobile->thumbnail_url))
                                        <img class="bg-holder-info" alt="Image" src="{{ URL::asset($pengumuman_mobile->thumbnail_url) }}" />
                                    @else
                                        <img class="bg-holder-info" alt="Image" src="{{ URL::asset('guest/img/lib/p3.jpg') }}" />
                                    @endif
                                </a>
                            </div>
                            <div class="card_info">
                                <a class="a-black" href="{{route('id.detail_pengumuman',[$pengumuman_mobile->slug])}}">
                                    <h5 class="info-title2 line-clamp">{{$pengumuman_mobile->nama_pengumuman}}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                    @foreach($pengumumans2 as $pengumuman2)
                    <div class="col-md-12 ">
                        <div class="boxed boxed--border pengumuman-box">
                            <span class="headline-date">{{$pengumuman2->created_at->format('d F Y')}}</span>
                            <a class="a-black" href="{{route('id.detail_pengumuman',$pengumuman2->slug)}}">
                                <h5 class="info-title">{{$pengumuman2->nama_pengumuman}}</h5>
                            </a>
                            <p class="info-content2">{{ strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",($pengumuman2->konten)))}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a class="btn btn--unhi btn--icon" href="{{ route('id.list_pengumuman')}}" style="margin-top: 10px;">
                    <span class="btn__text"><i class=""></i>Lihat Pengumuman Selengkapnya</span>
                </a>
            </div>
            <div class="col-md-4 agenda-sidebar">
                <h2 style="margin-bottom: 1.2em;" class="line-full-width">
                    <span class="span-line"> Agenda</span>
                </h2>
                <div class="content_agenda ">
                    @foreach($agendas as $tgl => $agenda)
                    <div class="detail-agenda-yellow">
                        <div class="agenda-yellow">
                            <h3>{{$agenda->waktu_mulai->format('d')}}</h3>
                            <h4>{{$agenda->waktu_mulai->format('M')}}</h4>
                        </div>
                        <div class="agenda-contain-yellow">
                            <div class="agenda-contain-description-yellow">
                                <a href="{{route('id.detail_agenda', $agenda->slug)}}" title="{{$agenda->nama_agenda}}">{{$agenda->nama_agenda}}</a>
                                <br>
                                <small><i class="fa fa-clock-o"></i>{{$agenda->waktu_mulai->format('H:i')}} - {{$agenda->waktu_selesai->format('H:i')}} </small>
                                <br>
                                <small><i class="fa fa-map-marker"></i> {{$agenda->lokasi}}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a class="btn btn--unhi btn--icon" href="{{ route('id.list_agenda')}}">
                    <span class="btn__text"><i class=""></i>Lihat Agenda Selengkapnya</span>
                </a>

            </div>

        </div>
        <!--end of row-->
    </div>
    <!--end of container-->
</section>

</section>
<div class="row cta-unhi">
    <div class="col-md-8 space--xs bg--dark bg-blue">
        <div class="cta cta--horizontal text-center-xs p-40">
            <section class="space--xs bg--dark bg-blue p-20 p-l-65 p-r-50">
                <div class="container">
                    <div class="slider">
                        <ul class="slides" data-timing="4000">
                            <li>
                                <a href="http://sruti.unhi.ac.id/" target="_blank">
                                    <div class="project-thumb" >
                                        <img src="{{ URL::asset('guest/img/lib/srutiUnihi.png') }}" alt="SRUTI" class="cta-img-sruti">
                                    </div>                                          
                                </a>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="project-thumb" >
                                            <h4 class="cta-unhi-h4">SRUTI UNHI MOBILE</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <a class="" href="#">
                                            <img class="google-play" src="https://play.google.com/intl/en_us/badges/images/generic/en_badge_web_generic.png" alt="">
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--end of container-->
            </section>
        </div>

    </div>
    <div class="col-md-4 space--xs ">
        <div class="row">
            <div class="col-md-12 bg-red">
                <div class="container">
                    <div class="cta cta--horizontal text-center-xs row">
                        <div class="pojok-unhi">
                            <a href="#" class="a-black">{{-- {{route('id.ayurweda_list')}} --}}
                                <h2 class="cta-unhi-h4 text text-white">Ayurweda</h2>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 bg-white border-btm">
                <div class="container">
                    <div class="cta cta--horizontal text-center-xs row">
                        <div class="pojok-unhi">
                            <a href="{{route('id.list_warta_unhi')}}" class="a-black">
                                <h2 class=" text"><span class="text-blue-white" style="background: #002d69;">koran</span><span class="text-yellow-black">Warta</span><span class="text-red-white" style="text-transform: uppercase;">Unhi</span></h2>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<section  class="bg--secondary section-style">
    <div class="container">
        <h2 style="margin-bottom: 1.2em;" class="line-full-width">
                <span class="span-line">Berita UNHI</span>
            </h2>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8 col-18">
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
                    </div>

                    <div class="col-md-4">
                        @foreach($beritas as $berita)
                        <article class="berita-sidebar">
                            <div class="row">
                                <div class="col-md-4 col-4">
                                    <div class="background-image-holder" style="border-radius: 6px;">
                                        <img alt="background" src="{{ URL::asset($berita->thumbnail_url) }}" />
                                    </div>
                                </div>
                
                                <div class="col-md-8 col-8">
                                    <a class="a-black" href="{{ route('id.detail_berita', $berita->slug)}}">
                                        <h5 class="pengumuman-title line-clamp-secondary">{{$berita->nama_berita}}</h5>
                                    </a>
                                    <p>
                                        {{$berita->tgl_rilis->format('l, d F Y')}}
                                    </p>
                                </div>
                            </div>
                        </article>
                        @endforeach
                        <a class="btn btn--unhi btn--icon" href="{{route('id.list_berita')}}">
                            <span class="btn__text"><i class=""></i>Lihat Berita Selengkapnya</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--end of container-->
</section>

<section class="feature-large section-style" style="padding-bottom: 40px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <h2 style="margin-bottom: 1.2em;">
                    <span class="text-red-white">Agama</span><span class="text-blue-white">Budaya</span>
                </h2>
                <h4 class="info-title">{{$agama_budaya->nama_agamabudaya}}</h4>
                <div class="text-agama">
                    {{ strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",($agama_budaya->konten)))}}
                </div>
                <a class="btn btn--unhi btn--icon" style="margin-bottom:20px" href="{{route('id.detail_agama_budaya', $agama_budaya->slug)}}">
                    <span class="btn__text"><i class=""></i>Lihat Artikel Selengkapnya</span>
                </a>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div>
                    <img class="bg-holder-agama" alt="Image" class="border--round box-shadow-wide" src="{{ URL::asset($agama_budaya->thumbnail_url) }}" />
                </div>                
            </div>
        </div>
        <!--end of row-->
    </div>
    <!--end of container-->
</section>

<section class="bg--secondary section-style" >
    <div class="container">
        <h2 style="margin-bottom: 1.2em;" class="line-full-width">
                    <span class="span-line"> Video & Galeri Foto</span>
                </h2>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="boxed boxed--lg box-video-home">
                    <div class="video-cover">
                        <div class="background-image-holder">
                            <img alt="image" src="https://i.ytimg.com/vi/{{$url_video}}/sddefault.jpg" />
                        </div>
                        <div class="video-play-icon"></div>
                        <iframe data-src="https://www.youtube.com/embed/{{$url_video}}?autoplay=1" allowfullscreen="allowfullscreen"></iframe>
                    </div>
                    <h5>{{$video->nama_video}}</h5>
                </div>
                <!--end video cover-->
                <a class="btn btn--unhi btn--icon" href="{{ route('id.list_video',$video->slug)}}" style="margin-top: 10px; margin-bottom:20px">
                    <span class="btn__text"><i class=""></i>Lihat Video Selengkapnya</span>
                </a>
            </div>
            <div class="col-md-6">
                <div class="masonry masonry--gapless">
                    <div class="masonry__container">
                        <div class="masonry__item col-lg-4 col-md-6 col-6" data-masonry-filter="Digital">
                            <div class="project-thumb hover-element height-50" style="height: 205px;">
                                <a href="{{route('id.list_gallery_latest', [$detailgallery1->gallery->slug] )}}">
                                    <div class="hover-element__initial">
                                        <div class="background-image-holder">
                                            <img alt="background" src="{{ URL::asset($detailgallery1->thumbnail_url) }}" />
                                        </div>
                                    </div>
                                    <div class="hover-element__reveal" data-overlay="9">
                                        <div class="project-thumb__title">
                                            <h5>{{$detailgallery1->gallery->nama_gallery}}</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--end item-->
                        <div class="masonry__item col-lg-8 col-md-6 col-6" data-masonry-filter="Digital">
                            <div class="project-thumb hover-element height-50" style="height: 205px;">
                                <a href="{{route('id.list_gallery_latest', [$detailgallery2->gallery->slug] )}}">
                                    <div class="hover-element__initial">
                                        <div class="background-image-holder">
                                            <img alt="background" src="{{ URL::asset($detailgallery2->thumbnail_url) }}" />
                                        </div>
                                    </div>
                                    <div class="hover-element__reveal" data-overlay="9">
                                        <div class="project-thumb__title">
                                            <h5>{{$detailgallery2->gallery->nama_gallery}}</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--end item-->
                        <div class="masonry__item col-lg-8 col-md-6 col-6" data-masonry-filter="Digital">
                            <div class="project-thumb hover-element height-50" style="height: 205px;">
                                <a href="{{route('id.list_gallery_latest', [$detailgallery3->gallery->slug] )}}">
                                    <div class="hover-element__initial">
                                        <div class="background-image-holder">
                                            <img alt="background" src="{{ URL::asset($detailgallery3->thumbnail_url) }}" />
                                        </div>
                                    </div>
                                    <div class="hover-element__reveal" data-overlay="9">
                                        <div class="project-thumb__title">
                                            <h5>{{$detailgallery3->gallery->nama_gallery}}</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--end item-->
                        <div class="masonry__item col-lg-4 col-md-6 col-6" data-masonry-filter="Digital">
                            <div class="project-thumb hover-element height-50" style="height: 205px;">
                                <a href="{{route('id.list_gallery_latest', [$detailgallery4->gallery->slug] )}}">
                                    <div class="hover-element__initial">
                                        <div class="background-image-holder">
                                            <img alt="background" src="{{ URL::asset($detailgallery4->thumbnail_url) }}" />
                                        </div>
                                    </div>
                                    <div class="hover-element__reveal" data-overlay="9">
                                        <div class="project-thumb__title">
                                            <h5>{{$detailgallery4->gallery->nama_gallery}}</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--end item-->
                    </div>
                    <!--end of masonry container-->
                </div>
                <a class="btn btn--unhi btn--icon" href="{{ route('id.list_gallery_latest', [$detailgallery1->gallery->slug])}}" style="margin-top: 10px;">
                    <span class="btn__text"><i class=""></i>Lihat Foto Selengkapnya</span>
                </a>
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

@section('js')
<script src="{{asset('/guest/js/flickity-imagesloaded.js')}}"></script>
@endsection