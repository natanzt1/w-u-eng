@extends('layouts.guest.app')

@section('title')
Universitas Hindu Indonesia
@endsection

@section('content')

{{-- BEGIN: Header --}}
@include('layouts.guest.header_english')
{{-- END: Header  --}}
<div class="main-container">
    <section class="text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <h2>Showing results for &ldquo;{{$keywords}}&rdquo;</h2>
                </div>
            </div>
            <!--end of row-->
        </div>
        <!--end of container-->
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8" style="padding-top: 5px;">
                        <div class="tabs-container text-center" data-content-align="left">
                            <ul class="tabs">
                                <li class="active">
                                    <div class="tab__title">
                                        <span class="h5">Berita</span>
                                    </div>
                                    <div class="tab__content">
                                        <ul class="results-list">
                                            @foreach($result_berita as $berita)
                                            <li>
                                                <a href="{{route('id.detail_berita',[$berita->slug])}}">
                                                    <h4>{{$berita->nama_berita}}</h4>
                                                </a>
                                                {{-- <p style="overflow: hidden;">
                                                    <p class="headline-content line-clamp-head">{{ strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",($berita->konten)))}}</p>
                                                </p> --}}
                                                <p class="headline-content line-clamp-head">{{ strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",($berita->konten)))}}</p>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="pagination">
                                            <ol>
                                                {{-- {!! $infos->links();!!} --}}
                                            </ol>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="tab__title">
                                        <span class="h5">Pengumuman</span>
                                    </div>
                                    <div class="tab__content">
                                        <ul class="results-list">
                                            @foreach($result_pengumuman as $pengumuman)
                                            <li>
                                                <a href="{{route('id.detail_pengumuman',[$pengumuman->slug])}}">
                                                    <h4>{{$pengumuman->nama_pengumuman}}</h4>
                                                </a>
                                                
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="tab__title">
                                        <span class="h5">Agenda</span>
                                    </div>
                                    <div class="tab__content">
                                        <ul class="results-list">
                                            @foreach($result_agenda as $agenda)
                                            <li>
                                                <a href="{{route('id.detail_agenda',[$agenda->slug])}}">
                                                    <h4>{{$agenda->nama_agenda}}</h4>
                                                </a>
                                                <p>
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
                                                                <td>Senin,13 Agustus 2018  - Selasa,14 Agustus 2018 </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                </p>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            </ul>
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

