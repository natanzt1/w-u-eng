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
                        Executive Council of Student
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
                        <a href="{{ route('id.bem') }}">Logo</a>
                    </li>
                    <li>
                        <a href="{{ route('id.bem.visi_misi') }}">Vission, Mission, and Purpose</a>
                    </li>
                    <li>
                        <a href="{{ route('id.bem.organisasi') }}">Organizational Structure</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-4 order-first">
                <div class="boxed boxed--border bg--secondary">
                    <h2 class="span-line">Vission</h2>
                        {!! $bem->visi !!}
                    <h2 class="span-line">Mission</h2>
                    <ol class="post-content">
                        {!! $bem->misi !!}
                    </ol>
                    <h2 class="span-line">Purpose</h2>
                    <ol class="post-content">
                        {!! $bem->tujuan !!}
                    </ol>
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
