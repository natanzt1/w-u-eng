@extends('layouts.guest.app')

@section('title')
Universitas Hindu Indonesia
@endsection

@section('content')

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
                        PENGUMUMAN
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
            <div class="masonry" style="padding-top: 11px;">
                <div class="row">
                    @foreach($infos as $i=> $info)
                    <div class="col-md-6">
                        <article class="feature feature-1">
                            <a href="{{ route('id.detail_pengumuman', $info->slug)}}" class="block">
                                @if( !empty($info->thumbnail_url))
                                    <img class="bg-holder-list-info" alt="Image" src="{{ URL::asset($info->thumbnail_url) }}" />
                                @elseif(empty($pengumuman->thumbnail_url)&&$i==0||empty($pengumuman->thumbnail_url)&&$i==3)
                                    <img class="bg-holder-list-info" alt="Image" src="{{ URL::asset('guest/img/lib/p1.jpg') }}" />
                                @else
                                    <img class="bg-holder-list-info" alt="Image" src="{{ URL::asset('guest/img/lib/p2.jpg') }}" />
                                @endif                               
                            </a>
                            <div class="feature__body boxed boxed--border">
                                <span class="headline-date">{{$info->created_at->format('l, d F Y')}}</span>
                                <a class="a-black" href="{{ route('id.detail_pengumuman', $info->slug)}}">
                                    <h5 class="berita-title">{{$info->nama_pengumuman}}</h5>
                                </a>                                
                                <p class="berita-content">{{ strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",($info->konten)))}}</p>
                            </div>
                        </article>
                    </div>
                    @endforeach

                </div>
                <!--end of masonry container-->
                <div class="pagination">
                    <ol>
                        {!! $infos->links();!!}
                    </ol>
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
@include('layouts.guest.footer')
</div>
{{-- END: Footer  --}}
@endsection

