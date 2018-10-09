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
                    <li class="active">
                        <a href="{{ route('id.fak',$session) }}">Faculty Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('id.fak_visi',$session) }}">Vission, Mission & Purpose</a>
                    </li>
                    <li>
                        <a href="{{ route('id.fak_organisasi', $session) }}">Organizational Structure</a>
                    </li>
                    <li>
                        <a href="{{ route('id.fak_gallery',$session) }}">Gallery</a>
                    </li>
                    <li >
                        <a href="{{ route('id.fak_prodi',$session) }}">Study Program</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-4 order-first">
                <div class="boxed boxed--border bg--secondary">
                    <h2 class="line-full-width">
                        <span class="span-line">Profile</span>
                    </h2>
                    @if( !empty($profile->logo_url))
                         <div class="text-center" style="margin-bottom:20px;">
                            <img class="logo-content" alt="logo-fakultas" src="{{ URL::asset($profile->logo_url) }}">
                        </div>
                    @else

                    @endif
                    <div class="post-content-p">
                        {!!$profile->latar_belakang!!}
                    </div>                                         
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
