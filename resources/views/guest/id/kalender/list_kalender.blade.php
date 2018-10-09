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
                        KALENDER AKADEMIK
                    </h1>
                </div>
            </div>
        </div><!--end of row-->
    </div><!--end of container-->
</section>
<section class="p-t-30 p-b-20">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8" style="padding-top: 10px;">
                <div class="row">
                    @foreach($kalender as $number => $data)
                    <div class="col-md-12">
                        <div class="feature feature-1 boxed boxed--border" style="min-height:auto;">
                        <div class="row">
                            <div class="col-md-1 d-none d-sm-block">
                                <h4 style="padding-top: 15px;">#{{$number+1}}</h4>
                            </div>
                            <div class="col-md-7 col-12 text-center">                                
                                <h4>Kalender Akademik {{$data->tahun_ajaran}}-{{$data->tahun_ajaran+1}}</h4>
                                <span class="type--fade"> <i class="fa fa-clock-o"></i>{{$data->created_at->format('d F Y')}}</span>
                            </div>
                            <div class="col-md-2 col-6 text-center">
                                <span class="h6 type--uppercase m-b-0">Lihat</span>
                                <a href="{{ route('id.see_kalender_akademik',[$data->tahun_ajaran]) }}" target="_blank">
                                    <i class="material-icons">find_in_page</i>
                                </a>
                            </div>
                            <div class="col-md-2 col-6 text-center">
                                <span class="h6 type--uppercase m-b-0">Unduh</span>
                                <a href="/{{ $data->url }}">
                                    <i class="material-icons">get_app</i>
                                </a>
                            </div>
                        </div>
                        </div>
                    </div>
                    @endforeach
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

