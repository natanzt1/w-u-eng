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
                        {{$prodi->nama_prodi}}
                    </h1>
                </div>
            </div>
        </div><!--end of row-->
    </div><!--end of container-->
</section>
<section class="p-t-30 p-b-20">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <ul class="menu">
                    <li>
                        <a href="{{ route('id.prodi',[$prodi->slug]) }}">Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('id.prodi_visi', [$prodi->slug]) }}">Vission, Mission, and Purpose</a>
                    </li>
                    <li>
                        <a href="{{ route('id.prodi_organisasi', [$prodi->slug]) }}">Organizational Structure</a>
                    </li>
                    <li class="active"> 
                        <a href="{{ route('id.prodi_dosen', [$prodi->slug]) }}">Lecturer</a>
                    </li>
                    <li>
                        <a href="{{ route('id.prodi_gallery', [$prodi->slug]) }}">Gallery</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-4 order-first">
                <div class="boxed boxed--border bg--secondary">
                    <h2 class="line-full-width">
                        <span class="span-line">List of Lecturer</span>
                    </h2>
                    <p class="post-content-p">
                        {!! $prodi->dosen_pengajar !!}
                    </p>
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