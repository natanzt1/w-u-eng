@extends('layouts.guest.app')

@section('title')
Universitas Hindu Indonesia
@endsection

@section('content')

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
                        AYURWEDA NEWS
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
                <div class="tabs-container m-t-10" data-content-align="left">
                    <div class="tab__content">
                        <ul class="results-list">
                            @foreach($result_berita as $berita)
                            <li>
                                <a href="{{route('id.detail_berita',[$berita->slug])}}">
                                    <h4>{{$berita->nama_berita}}</h4>
                                </a>
                                <p class="headline-content line-clamp-head">{{ strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",($berita->konten)))}}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!--end of masonry container-->
                <div class="pagination">
                    <ol>
                        {{-- {!! $infos->links();!!} --}}
                    </ol>
                </div>
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

