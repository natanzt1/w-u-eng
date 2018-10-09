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
                        PROGRAM PENDIDIKAN
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
                <div class="tabs-container text-center" data-content-align="left">
                    <ul class="tabs">
                        <li class="active">
                            <div class="tab__title">
                                <span class="h5">Sarjana</span>
                            </div>
                            <div class="tab__content">
                                <section class="unpad">
                                    <div class="container">
                                        <div class="row">
                                            @foreach($all_prodi_s1 as $prodi_s1)
                                            <div class="col-md-6">
                                                <div class="feature feature-2 boxed boxed--border">
                                                    <div class="row">
                                                        <div class="col-md-3 col-3">
                                                            <div class="text-center" style="padding:5px;">
                                                                @if( !empty($prodi_s1->logo))
                                                                    <img class="logo-prodi" alt="UNHI" src="{{ URL::asset($prodi_s1->logo) }}">
                                                                @else
                                                                    <img class="logo-prodi" alt="UNHI" src="{{ URL::asset('guest/img/lib/unhi.png') }}">
                                                                @endif                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9 col-9"> 
                                                            <a href="{{route('id.prodi',[$prodi_s1->slug])}}">
                                                                <span class="h5">{{$prodi_s1->nama_prodi}}</span>  
                                                            </a>                                                        
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                                <!--end feature-->
                                            </div>
                                            @endforeach
                                        </div>
                                        <!--end of row-->
                                    </div>
                                    <!--end of container-->
                                </section>
                            </div>
                        </li>
                        <li>
                            <div class="tab__title">
                                <span class="h5">S2-Pascasarjana</span>
                            </div>
                            <div class="tab__content">
                                <section class="unpad">
                                    <div class="container">
                                        <div class="row">
                                            @foreach($all_prodi_s2 as $prodi_s2)
                                            <div class="col-md-6">
                                                <div class="feature feature-2 boxed boxed--border">
                                                    <div class="row">
                                                        <div class="col-md-3 col-3">
                                                            <div class="text-center" style="padding:5px;">
                                                                @if( !empty($prodi_s2->logo))
                                                                    <img class="logo-prodi" alt="UNHI" src="{{ URL::asset($prodi_s2->logo) }}">
                                                                @else
                                                                    <img class="logo-prodi" alt="UNHI" src="{{ URL::asset('guest/img/lib/unhi.png') }}">
                                                                @endif                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9 col-9"> 
                                                            <a href="{{route('id.prodi',[$prodi_s2->slug])}}">
                                                                <span class="h5">{{$prodi_s2->nama_prodi}}</span>  
                                                            </a>                                                        
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                                <!--end feature-->
                                            </div>
                                            @endforeach
                                        </div>
                                        <!--end of row-->
                                    </div>
                                    <!--end of container-->
                                </section>
                            </div>
                        </li>
                        <li>
                            <div class="tab__title">
                                <span class="h5">S3-Pascasarjana</span>
                            </div>
                            <div class="tab__content">
                                <section class="unpad">
                                    <div class="container">
                                        <div class="row">
                                            @foreach($all_prodi_s3 as $prodi_s3)
                                            <div class="col-md-6">
                                                <div class="feature feature-2 boxed boxed--border">
                                                    <div class="row">
                                                        <div class="col-md-3 col-3">
                                                            <div class="text-center" style="padding:5px;">
                                                                @if( !empty($prodi_s3->logo))
                                                                    <img class="logo-prodi" alt="UNHI" src="{{ URL::asset($prodi_s3->logo) }}">
                                                                @else
                                                                    <img class="logo-prodi" alt="UNHI" src="{{ URL::asset('guest/img/lib/unhi.png') }}">
                                                                @endif                                                                 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9 col-9"> 
                                                            <a href="{{route('id.prodi',[$prodi_s3->slug])}}">
                                                                <span class="h5">{{$prodi_s3->nama_prodi}}</span>  
                                                            </a>                                                        
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                                <!--end feature-->
                                            </div>
                                            @endforeach
                                        </div>
                                        <!--end of row-->
                                    </div>
                                    <!--end of container-->
                                </section>
                            </div>
                        </li>
                    </ul>
                </div>
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

