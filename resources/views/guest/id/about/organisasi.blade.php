@extends('layouts.guest.app')

@section('title')
Universitas Hindu Indonesia
@endsection

@section('content')
<a id="start"></a>
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
                        Struktur Organisasi UNHI
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
                        <a href="{{ route('id.sejarah') }}">Sejarah</a>
                    </li>
                    <li>
                        <a href="{{ route('id.visi_misi') }}">Visi dan Misi</a>
                    </li>
                    <li>
                        <a href="{{ route('id.makna_lambang') }}">Makna Lambang</a>
                    </li>
                    <li>
                        <a href="{{ route('id.pimpinan_unhi') }}">Pimpinan Unhi</a>
                    </li>
                    <li>
                        <a href="{{ route('id.rektor_unhi') }}">Sambutan Rektor</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('id.organisasi_unhi') }}">Struktur Orgnisasi</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-4 order-first">
                <div class="boxed boxed--border bg--secondary">
                    <h2 class="line-full-width text-center">
                        <span class="span-line">Struktur Organisasi Unhi</span>
                    </h2>
                    <div class="text-center" style="margin-bottom:20px;">
                        <img alt="image" src="{{ URL::asset($org_unhi[0]->thumbnail_url) }}">
                    </div>
                    <div class="post-content-p">
                        {!! $org_unhi[0]->konten !!}
                    </div>                     
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
