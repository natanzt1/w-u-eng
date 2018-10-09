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
                        Galeri
                    </h1>
                </div>
            </div>
        </div><!--end of row-->
    </div><!--end of container-->
</section>
<section style="padding-top: 25px; padding-bottom: 50px;">
    <div class="container">
        <h3 style="margin-bottom: 1.1em;" class="line-full-width">
            <span class="span-line">{{$detailgallery_selected[0]->gallery->nama_gallery}}</span>
        </h3>
        <div class="row">
            <div class="col-md-12 col-lg-12">

            <div class="slider slider--columns" data-arrows="true" data-paging="true">
                <ul class="slides">
                    @foreach($detailgallery_selected as $dtl)
                    <li class="col-12">
                        <a href="{{ URL::asset($dtl->thumbnail_url) }}" data-lightbox="Gallery 1">
                            <img class="slider-gallery" alt="Image" src="{{ URL::asset($dtl->thumbnail_url) }}" />
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!--end masonry-->
        </div>
        </div>

        <!--end of row-->
    </div>
    <!--end of container-->
</section>
<section class="bg--secondary unpad--top">
    <div class="container">
        <h3 style="margin-bottom: 1.1em; margin-top: 1.1em;" class="line-full-width">
            <span class="span-line"> List Galeri</span>
        </h3>
            <div class="row">
                @foreach($list_gallery as $list)
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="project-thumb hover-element border--round list-video">
                            <a href="{{route('id.list_gallery_latest', $list->slug )}}">
                                <div class="hover-element__initial">
                                    <div class="background-image-holder">
                                        <img alt="background" src="{{ URL::asset($list->detailgallery[0]->thumbnail_url ?? '') }}" />
                                    </div>
                                </div>
                                <div class="hover-element__reveal" data-scrim-top="5">
                                    <div class="project-thumb__title">
                                        <h4>{{$list->nama_gallery}}</h4>
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


