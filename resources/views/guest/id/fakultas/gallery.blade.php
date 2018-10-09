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
                        {{$profile->nama_fakultas}}
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
                        <a href="{{ route('id.fak', $session) }}">Profil Fakultas</a>
                    </li>
                    <li>
                        <a href="{{ route('id.fak_visi', $session) }}">Visi Misi Tujuan Sasaran</a>
                    </li>
                    <li>
                        <a href="{{ route('id.fak_organisasi', $session) }}">Struktur Organisasi</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('id.fak_gallery', $session) }}">Gallery</a>
                    </li>
                    <li >
                        <a href="{{ route('id.fak_prodi',$session) }}">Program Studi</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-4 order-first m-b-30">
                <div class="row">
                    @foreach($galleries as $gallery)
                    <div class="col-lg-4 col-6" style="text-align: center;">
                        <a href="{{ URL::asset($gallery->thumbnail_url) }}" data-lightbox="true">
                            <img style="max-height: 133px" alt="Image" src="{{ URL::asset($gallery->thumbnail_url) }}" />
                        </a>
                    </div>
                    @endforeach
                </div>
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
