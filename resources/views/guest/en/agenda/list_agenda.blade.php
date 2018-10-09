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
                        AGENDA
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
            <div style="padding-top: 11px;">
                <div class="row">
                    @foreach($agendas as $agenda)
                    <div class="col-md-6">
                        <article class="feature feature-1">
                            <a href="{{ route('id.detail_agenda', $agenda->slug)}}" class="block">
                                <span class="label agenda-list-label type--bold">13 November</span>
                                @if( !empty($agenda->thumbnail_url))
                                    <img class="bg-holder-standard" alt="Image" src="{{ URL::asset($agenda->thumbnail_url) }}" />
                                @else
                                    <img class="bg-holder-standard" alt="Image" src="{{ URL::asset('guest/img/lib/bendera-unhi.png') }}" />
                                @endif                                
                            </a>
                            <div class="feature__body boxed boxed--border">
                                <a class="a-black" href="{{ route('id.detail_agenda', $agenda->slug)}}">
                                    <h5 class="berita-title">{{$agenda->nama_agenda}}</h5>
                                </a>                                
                                <p class="berita-content">{{ strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",($agenda->konten)))}}</p>
                            </div>
                        </article>
                    </div>
                    @endforeach
                    <!--end item-->
                </div>
                <!--end of row-->
                <div class="pagination">
                    <ol>
                        {!! $agendas->links();!!}
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
@include('layouts.guest.footer_english')
</div>
{{-- END: Footer  --}}
@endsection

