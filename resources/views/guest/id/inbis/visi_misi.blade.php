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
                        Inkubator Bisnis
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
                        <a href="{{ route('id.inbis.latar_belakang') }}">Latar Belakang</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('id.inbis.visi_misi') }}">Visi dan Misi</a>
                    </li>
                    <li >
                        <a href="{{ route('id.inbis.organisasi') }}">Struktur Organisasi</a>
                    </li>
                    <li>
                        <a href="{{ route('id.inbis.pendamping_tenant') }}">Pendamping Tenant</a>
                    </li>
                    <li>
                        <a href="{{ route('id.inbis.tenant_inwall') }}">Tenant Inwall</a>
                    </li>
                    <li>
                        <a href="{{ route('id.inbis.tenant_outwall') }}">Tenant Outwall</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-4 order-first">
                <div class="boxed boxed--border bg--secondary">
                    <h3 style="margin-bottom: 15px;" class="line-full-width">
                        <span class="span-line"> VISI</span>
                    </h3>
                    <div class="post-contet-p">
                        {!! $visi[0]->konten !!}
                    </div>                    
                    <h3 style="margin-bottom: 15px;" class="line-full-width">
                        <span class="span-line"> MISI</span>
                    </h3>
                    <div class="post-contet-p">
                        {!! $misi[0]->konten !!}
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

