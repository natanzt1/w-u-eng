<footer class="footer-6 unpad--bottom  bg--dark bg-blue p-t-40 footer-unhi">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4 col-12">
                <img class="logo-footer" alt="UNHI" src="{{ URL::asset('guest/img/lib/unhi_footer.png') }}" />
                <h6 class="type--uppercase" style="margin-bottom: 10px;">Universitas Hindu Indonesia Denpasar</h6>
                <ul class="list--hover">
                    <li>Jl. Sangalangit , Tembau , Penatih, Denpasar, Bali 80238</li>
                    <li>
                            <i class="fa fa-envelope"></i>&nbsp;&nbsp;
                            <a href="emailto: infos1@unhi.ac.id">infos1@unhi.ac.id</a>
                    </li>
                    <li>
                            <i class="fa fa-phone"></i>&nbsp;&nbsp;(0361) 464700
                    </li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-2 col-12 d-none d-sm-block m-t-20 ">
                <h6 class="type--uppercase m-b-0">Tentang Unhi</h6>
                <ul class="list--hover">
                    <li>
                        <a href="{{ route('id.sejarah') }}">Sejarah</a>
                    </li>
                    <li>
                        <a href="{{ route('id.visi_misi') }}">Visi dan Misi</a>
                    </li>
                    <li>
                        <a href="{{ route('id.makna_lambang') }}">Makna Lambang</a>
                    </li>
                    <li>
                        <a href="{{ route('id.pimpinan_unhi') }}">Pimpinan UNHI</a>
                    </li>
                    <li>
                        <a href="{{ route('id.rektor_unhi') }}">Sambutan Rektor</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-3 col-12 m-t-20">
                <h6 class="type--uppercase m-b-0">Informasi Pilihan</h6>
                <ul class="list--hover">
                    <li><a href="https://scimagojr.com/">SRUTI</a></li>
                    <li><a href="https://www.scopus.com/home.uri">e-Perpus</a></li>
                    <li><a href="http://ristekdikti.go.id/">Kalender Akademik</a></li>
                    <li><a href="{{route('id.list_warta_unhi')}}">Warta UNHI</a></li>
                    <li><a href="https://www.lpdp.kemenkeu.go.id/">Repository</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-3 col-12 m-t-20">
                <h6 class="type--uppercase m-b-0">Informasi Eksternal</h6>
                <ul class="list--hover">
                    <li><a href="https://scimagojr.com/" target="_blank">Scimago Journal & Country Rank</a></li>
                    <li><a href="https://www.scopus.com/home.uri" target="_blank">Scopus</a></li>
                    <li><a href="http://ristekdikti.go.id/" target="_blank">Kemenristek &amp; Dikti</a></li>
                    <li><a href="https://www.lpdp.kemenkeu.go.id/" target="_blank">LPDP KEMENKEU</a></li>
                </ul>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-md-12 text-center m-t-20">
                <span class="text-red-white">S</span></span>istem Inform<span class="text-red-white">a</span>si <span class="text-red-white">Ma</span>najemen <span class="text-red-white">We</span>bsite Universitas Hin<span class="text-red-white">d</span>u Denp<span class="text-red-white">a</span>sar</span>
            </div>
        </div> --}}
    </div>
    <!--end of container-->
    <div class="footer__lower text-center-xs ">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <span class="text-blue">&copy;
                        <span class="update-year text-blue"></span> | SAMA WEDA | <span class="type--bold text-red">S</span>istem Inform<span class="type--bold text-red">a</span>si <span class="type--bold text-red">Ma</span>najemen <span class="type--bold text-red">We</span>bsite Universitas Hin<span class="type--bold text-red">d</span>u Denp<span class="type--bold text-red">a</span>sar
                    </span>
                </div>
                <div class="col-md-4 text-right social-unhi">
                    <ul class="social-list list-inline list--hover">
                        <li>
                            <a href="https://twitter.com/officialunhi" target="_blank">
                                <i class="socicon socicon-twitter icon icon--xs text-blue"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.facebook.com/unhidenpasar/" target="_blank">
                                <i class="socicon socicon-facebook icon icon--xs text-blue"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/unhidenpasar/" target="_blank">
                                <i class="socicon socicon-instagram icon icon--xs text-blue"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--end of row-->
        </div>
        <!--end of container-->
    </div>

</footer>