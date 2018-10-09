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
                        Badan Eksekutif Mahasiswa 
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
                <ul class="menu accordion accordion-1 accordion--oneopen">
                    <li class="active">
                        <a href="{{ route('id.bem') }}">Logo BEM</a>
                    </li>
                    <li>
                        <a href="{{ route('id.bem.visi_misi') }}">Visi, Misi, Tujuan, dan Sasaran</a>
                    </li>
                    <li>
                        <a href="{{ route('id.bem.organisasi') }}">Struktur Organisasi</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-4 order-first">
                <div class="boxed boxed--border bg--secondary">
                    <h2 class="line-full-width text-center">
                        <span class="span-line">Logo BEM</span>
                    </h2>
                    <div class="text-center" style="margin-bottom:20px;">
                        <img class="logo-content" alt="image" src="{{ URL::asset($bem->logo_url) }}">                                            
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

