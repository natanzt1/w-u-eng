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
                        AGENDA
                    </h1>
                </div>
            </div>
        </div><!--end of row-->
    </div><!--end of container-->
</section>
<section style="padding-top: 50px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8">
            <div class="masonry">
                <article class="single-post">
                    <div class="post-heading">
                        <h2 class="post-title">
                            <span>{{$agenda->nama_agenda}}</span>
                        </h2>
                        <ul class="entry-meta">
                            <li class="post-date">{{$agenda->created_at->format('l, d F Y')}}</li>
                            <li class="post-author">Operator</li>
                            <li class="post-reads">{{$agenda->views}}</li>
                        </ul>
                        <hr>
                    </div>
                    <div class="post-content">
                        @if( !empty($agenda->thumbnail_url))
                            <img alt="Image" src="{{ URL::asset($agenda->thumbnail_url) }}" />
                        @else
                            
                        @endif     
                        <div class="boxed boxed--border  bg--secondary" style="margin-top:15px">
                            <table style="margin-bottom: unset;">
                                <tbody>
                                    <tr>
                                        <th>Penyelenggara</th>
                                        <td>:</td>
                                        <td>{{$agenda->penyelenggara}}</td>
                                    </tr>
                                    <tr>
                                        <th>Lokasi</th>
                                        <td>:</td>
                                        <td>{{$agenda->lokasi}}</td>
                                    </tr>
                                    <tr>
                                        <th>Kontak</th>
                                        <td>:</td>
                                        <td>{{$agenda->kontak}}</td>
                                    </tr>
                                    <tr>
                                        <th>Agenda</th>
                                        <td>:</td>
                                        <td>{{$agenda->waktu_mulai->format('l, d F Y')}}  - {{$agenda->waktu_mulai->format('l, d F Y')}} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {!! $agenda->konten !!}
                    </div>
                </article>
            </div>
            <!--end masonry-->
        </div>
        <div class="col-lg-4 d-none d-sm-block">
        <div class="sidebar boxed boxed--border bg--secondary" style="padding:0px;">
            <div class="sidebar__widget">
                <h3 class="sidebar-titlehead type--bold">
                    Agenda Terbaru
                </h3>
                @foreach($sidebar_agendas as $sidebar )
                <div class="sidebar-content">
                    <a class="a-black" href="{{ route('id.detail_agenda', $sidebar->slug)}}">
                        <h5 class="berita-title">{{$sidebar->nama_agenda}}-{{$sidebar->waktu_mulai->format('d M')}}</h5>
                    </a>                                
                    <p class="berita-content" style="margin-bottom: 15px;">{{ strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",($sidebar->konten)))}}</p>
                    <span class="date-widget">{{$sidebar->created_at->format('l, d F Y')}}</span>
                    <hr class="line-hr">
                </div>
                @endforeach
            </div>
            <!--end widget-->
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

