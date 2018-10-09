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
                    <li>
                        <a href="{{ route('id.senat') }}">Fakultas Ayurweda</a>
                    </li>
                    <li>
                        <a href="{{ route('id.senat.budaya') }}">Fakultas Agama & Kebudayaan</a>
                    </li>
                    <li>
                        <a href="{{ route('id.senat.seni') }}">Fakultas Agama & Seni</a>
                    </li>
                    <li>
                        <a href="{{ route('id.senat.ekonomi') }}">Fakultas Ekonomi</a>
                    </li>
                    <li>
                        <a href="{{ route('id.senat.teknik') }}">Fakultas Teknik</a>
                    </li>
                    <li>
                        <a href="{{ route('id.senat.mipa') }}">Fakultas MIPA</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-4 order-first">
                <h1 class="type--bold ">Senat Fakultas Ayurweda</h1>
                <div class="boxed boxed--border bg--secondary">
 
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
