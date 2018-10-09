<div class="col-lg-4 d-none d-sm-block">
        <div class="sidebar boxed boxed--border bg--secondary" style="padding:0px;">
            <div class="sidebar__widget">
                <h3 class="sidebar-titlehead">
                    Berita Terbaru
                </h3>
                @foreach($sidebar_beritas as $berita)
                <div class="sidebar-content">
                    <a class="a-black" href="{{ route('id.detail_berita', $berita->slug)}}">
                        <h5 class="berita-title">{{$berita->nama_berita}}</h5>
                    </a>                                
                    <p class="berita-content" style="margin-bottom: 15px;">{{ strip_tags(preg_replace("/&#?[a-z0-9]+;/i","",($berita->konten)))}}</p>
                    <span class="date-widget">{{$berita->tgl_rilis->format('l, d F Y')}}</span>
                    <hr class="line-hr">
                </div>
                @endforeach
                
            </div>
            <!--end widget-->
        </div>
</div>