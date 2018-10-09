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
                        Galeri Video
                    </h1>
                    </div>
                </div>
            </div>
            <!--end of row-->
        </div>
        <!--end of container-->
    </section>
    <section class="text-center" style="padding-top: 25px; padding-bottom: 50px;">
        <div class="container">
            <h3 style="margin-bottom: 1.1em;" class="line-full-width">
            <span class="span-line"> {{$video->nama_video}}</span>
        </h3>
            <div class="row">
                <div class="col-md-12 col-lg-10">
                    <div class="video-cover border--round">
                        <div class="background-image-holder">
                            <img alt="image" src="https://i.ytimg.com/vi/{{$ytb_id}}/hqdefault.jpg" />
                        </div>
                        <div class="video-play-icon"></div>
                        <iframe data-src="https://www.youtube.com/embed/{{$ytb_id}}?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        {{-- <iframe width="710" height="460" src="https://www.youtube.com/embed/ueDXnBd7TJo" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe> --}}
                    </div>
                    <!--end video cover-->
                </div>
            </div>
            <!--end of row-->
        </div>
        <!--end of container-->
    </section>
    <section class="bg--secondary unpad m-b-30">
        <div class="container">
            <h3 style="margin-bottom: 2em; margin-top: 1.1em;" class="line-full-width">
            <span class="span-line"> List Galeri Video</span>
        </h3>
            <div class="row">
                @foreach($videos as $video)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="project-thumb hover-element list-video">
                        <a href="{{ route('id.list_video',$video->slug)}}">
                            <div class="hover-element__initial">
                                <div class="background-image-holder">
                                    <img alt="background" src="https://i.ytimg.com/vi/{{$video->getYoutubeId()}}/sddefault.jpg" />
                                </div>
                            </div>
                            <div class="hover-element__reveal" data-scrim-top="5">
                                <div class="project-thumb__title">
                                    <h4>{{$video->nama_video}}</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </section>
        
{{-- BEGIN: Footer --}}
@include('layouts.guest.footer')
</div>
{{-- END: Footer  --}}
@endsection


