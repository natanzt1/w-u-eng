@extends('layouts.guest.app')

@section('title')
Universitas Hindu Indonesia
@endsection

@section('content')
<a id="start"></a>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#active").click(function() {
            var slug = $("#slug").val();
            var link = "/administrator/slider/"+slug+"/active"
            $.get(link, function() {
                alert('Slider Berhasil Diaktifkan');
                location.reload();
            });
        });
        $("#nonactive").click(function() {
            var slug = $("#slug").val();
            var link = "/administrator/slider/"+slug+"/nonactive"
            $.get(link, function() {
                alert('Slider Berhasil Di-nonaktifkan');
                location.reload();
            });
        });
    });
</script>
{{-- BEGIN: Header --}}
@include('layouts.guest.header')
{{-- END: Header  --}}

<div class="main-container">
<section class="cover unpad switchable switchable--switch bg--secondary text-center-xs">
    <div class="row align-items-center justify-content-around">
        <div class="col-12">
            <div class="slider" data-arrows="true" data-paging="true">
                <ul class="slides full-slider">
                        <li >
                            <img class="slider-img" alt="Image" src="{{ URL::asset($datas[0]->thumbnail_url) }}" />
                            <div class="slider-in">
                                <div class="slider-content-title bottom-left">
                                    <div class="slider-title">
                                        {{$datas[0]->nama_slider}}
                                    </div>
                                </div>
                                <div class="slider-content bottom-left">
                                    <div class="entry-content"><p>{!! $datas[0]->konten !!}</p></div>
                                </div>

                                
                            </div>
                        </li>
                </ul>
            </div>
        </div>
    </div>
    <!--end of container-->
</section>