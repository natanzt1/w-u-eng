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
                        Senat Mahasiswa
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
                    @foreach($senats as $senat)
                    <li>
                        <a href="{{ route('id.senat.detail',[$senat->slug]) }}">{{$senat->nama_senat}}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-8 order-md-4 order-first">
                <div class="boxed boxed--border bg--secondary">
                    <h2 class="line-full-width">
                        <span class="span-line">{{$data->nama_senat}}</span>
                    </h2>
                    <div class="post-content-p">
                        {!! $data->konten !!}
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
