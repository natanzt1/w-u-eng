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
                        PETA KAMPUS
                    </h1>
                </div>
            </div>
        </div><!--end of row-->
    </div><!--end of container-->
</section>
<section class="p-t-30 p-b-20">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6 col-md-7 col-12">
                <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15778.023110990727!2d115.23751142719141!3d-8.643351400622581!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23f9bedcf9601%3A0x308ca0bd284795eb!2sUniversitas+Hindu+Indonesia!5e0!3m2!1sen!2sid!4v1535129750241" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-lg-5 col-md-5">
                <div class="m-b-20">
                    <h4 class="line-full-width m-b-10">
                        <span class="span-line">Informasi</span>
                    </h4>
                    <p class="text-maps">
                        <i class="fa fa-map-pin" aria-hidden="true"></i> Jl. Sangalangit , Tembau , Penatih, Denpasar, Bali 80238
                    </p>
                    <p class="text-maps">
                        <i class="fa fa-envelope"></i> infos1@unhi.ac.id
                    </p>
                    <p class="text-maps">
                        <i class="fa fa-phone"></i> (0361) 464700
                    </p>
                </div>

                <div class="">
                    <h4 class="line-full-width m-b-10">
                        <span class="span-line">Jam Kerja</span>
                    </h4>
                    <p class="text-maps">
                        <span class="type--bold">Senin - Jum'at</span> - 8 pagi sampai 4 sore
                    </p>
                    <p class="text-maps">
                        <span class="type--bold">Sabtu - Minggu</span> - Libur
                    </p>
                </div>

            </div>
        </div>
        <!--end of row-->
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8" style="padding-top: 10px;">

            </div>
            <div class="col-lg-4 hidden-sm">

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

