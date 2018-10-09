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
                        Bureau
                    </h1>
                </div>
            </div>
        </div><!--end of row-->
    </div><!--end of container-->
</section>
<section class="p-t-30 p-b-20">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-8 m-b-20" style="padding-top: 10px;">
                <div class="boxed boxed--border bg--secondary">
                    <h3 class="line-full-width ">
                        <span class="span-line">{{$biro_pilihan->nama_biro}}</span>
                    </h3>
                    <div class="post-content-p">
                        {!! $biro_pilihan->deskripsi !!}
                    </div>                     
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

