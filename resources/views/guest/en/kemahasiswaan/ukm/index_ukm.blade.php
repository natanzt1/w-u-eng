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
                        Students Unit Activity
                    </h1>
                </div>
            </div>
        </div><!--end of row-->
    </div><!--end of container-->
</section>
<section class="p-t-30 p-b-20">
    <div class="container">
        <div class="row">            
            <div class="col-md-12 col-lg-8" style="padding-top: 10px;">
                {{-- <p>Unit Kegiatan Mahasiswa (UKM) adalah wadah aktivitas kemahasiswaan untuk mengembangkan minat, bakat dan keahlian tertentu bagi para anggota-anggotanya. lembaga ini merupakan partner organisasi kemahasiswaan intra kampus lainnya seperti Badan Eksekutif Mahasiswa. Lembaga ini bersifat otonom, dan bukan merupakan bagian dari Badan Eksekutif Mahasiswa.</p> --}}
                <div class="row">
                    @foreach($ukms as $ukm)
                    <div class="col-md-6 col-6">                                            
                        <div class="feature feature-7 boxed text-center imagebg" data-overlay="3">
                            <div class="background-image-holder">
                                <img alt="background" src="{{ URL::asset($ukm->thumbnail_url) }}" />
                            </div>
                            <h4 class="pos-vertical-center">{{$ukm->nama_ukm}}</h4>
                        </div>                                            
                    </div>
                    @endforeach
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

