@extends('layouts.guest.app')

@section('title')
Universitas Hindu Indonesia
@endsection

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#active").click(function() {
            var slug = $("#slug").val();
            var link = "/administrator/agenda/"+slug+"/active"
            $.get(link, function() {
                alert('Konten Berhasil Diaktifkan');
                location.reload();
            });
        });
        $("#nonactive").click(function() {
            var slug = $("#slug").val();
            var link = "/administrator/agenda/"+slug+"/nonactive"
            $.get(link, function() {
                alert('Konten Berhasil Di-nonaktifkan');
                location.reload();
            });
        });
    });
</script>
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
                            <span>{{$datas[0]->nama_agenda}}</span>
                        </h2>
                        <ul class="entry-meta">
                            <li class="post-date">{{date("d M Y (H:i)", strtotime($datas[0]->created_at))}}</li>
                            <li class="post-author">{{$datas[0]->user->name}}</li>
                            <li class="post-reads">{{$datas[0]->views}}</li>
                        </ul>
                        <hr>
                    </div>
                    <div class="post-content">
                        <img alt="Image" src="{{ URL::asset($datas[0]->thumbnail_url) }}" />
                        <div class="boxed boxed--border  bg--secondary" style="margin-top:15px">
                            <table style="margin-bottom: unset;">
                                <tbody>
                                    <tr>
                                        <th>Penyelenggara</th>
                                        <td>:</td>
                                        <td>{{$datas[0]->penyelenggara}}</td>
                                    </tr>
                                    <tr>
                                        <th>Lokasi</th>
                                        <td>:</td>
                                        <td>{{$datas[0]->lokasi}}</td>
                                    </tr>
                                    <tr>
                                        <th>Kontak</th>
                                        <td>:</td>
                                        <td>{{$datas[0]->kontak}}</td>
                                    </tr>
                                    <tr>
                                        <th>Agenda</th>
                                        <td>:</td>
                                        <td>{{date("d M Y (H:i)", strtotime($datas[0]->waktu_mulai))}} - {{date("d M Y (H:i)", strtotime($datas[0]->waktu_selesai))}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {!! $datas[0]->konten !!}
                    </div>
                </article>
            </div>
            <!--end masonry-->
        </div>
        <div class="col-lg-4 hidden-sm">
        <div class="sidebar boxed boxed--border bg--secondary" style="padding:0px;">
            <div class="sidebar__widget">
                <div style="padding: 0 20px">
                    @if($source == "create")
                    <a href="{{route('admin.agenda.active', [$slug])}}"><button class="btn btn-primary" style="width: 100px">Simpan</button></a>
                    @elseif($source == "edit")
                    <form method="POST" action="{{route('admin.agenda.saveUpdate', [$slug])}}">
                        @csrf
                        <h3>Simpan Perubahan?</h3>
                        <input type="hidden" name="nama_agenda" value="{{$datas[0]->nama_agenda}}">
                        <input type="hidden" name="konten" value="{{$datas[0]->konten}}">
                        <input type="hidden" name="new_slug" value="{{$datas[0]->slug}}">
                        <input type="hidden" name="old_slug" value="{{$slug}}">
                        <input type="hidden" name="thumbnail_url" value="{{$datas[0]->thumbnail_url}}">
                        <input type="hidden" name="penyelenggara" value="{{$datas[0]->penyelenggara}}">
                        <input type="hidden" name="lokasi" value="{{$datas[0]->lokasi}}">
                        <input type="hidden" name="website" value="{{$datas[0]->website}}">
                        <input type="hidden" name="kontak" value="{{$datas[0]->kontak}}">
                        <input type="hidden" name="waktu_mulai" value="{{$datas[0]->waktu_mulai}}">
                        <input type="hidden" name="waktu_selesai" value="{{$datas[0]->waktu_selesai}}">
                        <button type="submit" class="btn btn-primary" style="width: 100px; margin-top: 0">Simpan</button>
                    </form>
                    @else
                    <table>
                        <tr>
                            <td>Status</td>
                            @if($datas[0]->status == 0)
                            <td>: Nonaktif</td>
                            @else
                            <td>: Aktif</td>
                            @endif
                        </tr>
                        <tr>
                            <td>Views</td>
                            <td>: 61</td>
                        </tr>
                    </table>
                    <input type="hidden" id="slug" value="{{$datas[0]->slug}}">
                        @if($datas[0]->status == 0)
                    <a href="{{route('admin.agenda.edit', [$datas[0]->slug])}}"><button class="btn btn-info" style="width: 100px">Edit</button></a>
                    <a href="#"><button class="btn btn-primary" id="active" style="width: 100px">Aktifkan</button></a>
                        @else
                    <a href="{{route('admin.agenda.edit', [$datas[0]->slug])}}"><button class="btn btn-info" style="width: 100px">Edit</button></a>
                    <a href="#"><button class="btn btn-danger" id="nonactive" style="width: 100px">Nonaktifkan</button></a>   
                        @endif
                    @endif
                </div>
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

