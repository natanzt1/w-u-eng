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
                        Symbol Meaning
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
                        <a href="{{ route('id.sejarah') }}">History</a>
                    </li>
                    <li>
                        <a href="{{ route('id.visi_misi') }}">Vission and Mission</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('id.makna_lambang') }}">Symbol Meaning</a>
                    </li>
                    <li>
                        <a href="{{ route('id.pimpinan_unhi') }}">Leader Unhi</a>
                    </li>
                    <li>
                        <a href="{{ route('id.rektor_unhi') }}">Rector's Welcome</a>
                    </li>
                    <li>
                        <a href="{{ route('id.organisasi_unhi') }}">Organizational Structure</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-4 order-first">
                <div class="boxed boxed--border bg--secondary">
                    <h2 class="line-full-width text-center">
                        <span class="span-line">Symbol Meaning</span>
                    </h2>
                    <div class="text-center" style="margin-bottom:20px;">
                        <img class="logo-content" alt="image" src="{{ URL::asset($makna[0]->thumbnail_url) }}">
                    </div>
                    <div class="post-content-p">
                        {!! $makna[0]->konten !!}
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
