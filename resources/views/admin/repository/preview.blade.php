@extends('layouts.guest.app')

@section('title')
Universitas Hindu Indonesia
@endsection

@section('content')
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v3.0&appId=971477629686903&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#active").click(function() {
            var slug = $("#slug").val();
            var link = "/administrator/pengumuman/"+slug+"/active"
            $.get(link, function() {
                alert('Pengumuman Berhasil Diaktifkan');
                location.reload();
            });
        });
        $("#nonactive").click(function() {
            var slug = $("#slug").val();
            var link = "/administrator/pengumuman/"+slug+"/nonactive"
            $.get(link, function() {
                alert('Pengumuman Berhasil Di-nonaktifkan');
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
                        PREVIEW PENGUMUMAN
                    </h1>
                </div>
            </div>
        </div><!--end of row-->
    </div><!--end of container-->
</section>
<section style="padding-top: 50px;">
    <div class="container" id="">
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="masonry">
                    <article class="single-post">
                        <div class="post-heading">
                            <h2 class="post-title">
                                <span>{{$datas[0]->nama_pengumuman}}</span>
                            </h2>
                            <ul class="entry-meta">
                                <li class="post-date">18 Oktober 2018</li>
                                <li class="post-author">Admin</li>
                                <li class="post-reads">90</li>
                            </ul>
                            <hr>
                        </div>
                        <div class="post-content">
                            <img alt="Image" src="{{ URL::asset($datas[0]->thumbnail_url) }}" />
                            {!! $datas[0]->konten !!}
                        </div>
                    </article>


                    <div class="blog-comments">
                        <div class="fb-comments" data-href="http://127.0.0.1:8000/id/pengumuman/detail-pengumuman/slug" data-width="100%" data-numposts="5"></div>
                    </div>
                </div>
                <!--end masonry-->
            </div>
            <div class="col-lg-4 hidden-sm">
                <div class="sidebar boxed boxed--border bg--secondary" style="padding:20px 0 ">
                    <div class="sidebar__widget">
                        <div style="padding: 0 20px">
                            @if($source == "create")
                            <a href="{{route('admin.pengumuman.active', [$slug])}}"><button class="btn btn-primary" style="width: 100px">Simpan</button></a>
                            @elseif($source == "edit")
                            <form method="POST" action="{{route('admin.pengumuman.saveUpdate', [$slug])}}">
                                @csrf
                                <h3>Simpan Perubahan?</h3>
                                <input type="hidden" name="nama_pengumuman" value="{{$datas[0]->nama_pengumuman}}">
                                <input type="hidden" name="konten" value="{{$datas[0]->konten}}">
                                <input type="hidden" name="new_slug" value="{{$datas[0]->slug}}">
                                <input type="hidden" name="old_slug" value="{{$slug}}">
                                <input type="hidden" name="thumbnail_url" value="{{$datas[0]->thumbnail_url}}">
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
                            <a href="{{route('admin.pengumuman.edit', [$datas[0]->slug])}}"><button class="btn btn-info" style="width: 100px">Edit</button></a>
                            <a href="#"><button class="btn btn-primary" id="active" style="width: 100px">Aktifkan</button></a>
                                @else
                            <a href="{{route('admin.pengumuman.edit', [$datas[0]->slug])}}"><button class="btn btn-info" style="width: 100px">Edit</button></a>
                            <a href="#"><button class="btn btn-danger" id="nonactive" style="width: 100px">Nonaktifkan</button></a>   
                                @endif
                            @endif
                        </div>
                    </div>
                    <!--end widget-->
                </div>
            </div>
            <!--end of container-->
        </div>
        <!--end row-->
    <!--end of container-->
    </div>
</section>
        

{{-- BEGIN: Footer --}}
@include('layouts.guest.footer')
</div>
{{-- END: Footer  --}}
@endsection

