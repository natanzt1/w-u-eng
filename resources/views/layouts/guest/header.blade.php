<section class="bar bar-3 bar--sm bg-blue p-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-right text-left-xs text-left-sm">
                <div class="bar__module">
                    <div class="modal-instance sruti-box" style="
                    float: left;">
                        <a class="a-blue sruti" href="http://sruti.unhi.ac.id/">    
                            <span class="">SRUTI</span>
                        </a>
                    </div>
                    {{-- <span class="text-sama-weda m-b-0"> <span class="text-yellow">S</span>istem Inform<span class="text-yellow">a</span>si <span class="text-yellow">Ma</span>najemen <span class="text-yellow">We</span>bsite Universitas Hin<span class="text-yellow">d</span>u Denp<span class="text-yellow">a</span>sar</span> --}}
                    <ul class="menu-horizontal">
                        <li>
                            <div class="modal-instance">
                                <a class="a-white" href="{{route('id.peta_kampus')}}"><i class="fa fa-map-marker"></i> Peta Kampus</a>
                            </div>
                        </li>
                        <li>
                            <a href="#" data-notification-link="search-box" style="opacity: unset;">
                                <i class="stack-search a-white"></i>
                            </a>
                        </li>
                        <li class="dropdown dropdown--absolute">
                            <span class="dropdown__trigger span-lang" >
                                <img alt="Image" class="flag" src="{{ URL::asset('guest/img/lib/in.gif') }}">
                            </span>
                            {{-- <div class="dropdown__container">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-2 dropdown__content bg--dark bg-blue" style="left: 1093.23px;padding: 1.23em 1.23em;">
                                            <ul class="menu-vertical text-left">
                                                <li>
                                                    <a href="{{route('en.home')}}">
                                                        <img class="unmarg--bottom" src="{{ URL::asset('guest/img/lib/en.gif') }}">
                                                        <span class="hidden-xs" style="margin-left:0.3em;">English</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--end of row-->
    </div>
    <!--end of container-->
</section>
<!--end bar-->

<div class="notification pos-top pos-right search-box bg--white border--bottom" data-animation="from-top" data-notification-link="search-box">
    <form action="{{route('id.search')}}/" method="GET">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <input type="search" name="query" placeholder="Ketik sesuatu kemudian tekan enter" />
            </div>
        </div>
        <!--end of row-->
    </form>
</div>
<!--end of notification-->
<div class="nav-container bg-yellow">
    <div class="bar bar--sm visible-xs">
        <div class="container">
            <div class="row">
                <div class="col-3 col-md-2">
                    <a href="{{ route('id.home')}}">
                        <img class="logo logo-dark" alt="logo" src="{{ URL::asset('guest/img/lib/logo_navbar.png') }}" />
                    </a>
                </div>
                <div class="col-9 col-md-10 text-right">
                    <a href="#" class="hamburger-toggle" data-toggle-class="#menu1;hidden-xs">
                        <i class="icon icon--sm stack-interface stack-menu" style="padding-top: 8px;"></i>
                    </a>
                </div>
            </div>
            <!--end of row-->
        </div>
        <!--end of container-->
    </div>
    <!--end bar-->
    <nav id="menu1" class="bar bar--sm bar-1 hidden-xs bg-yellow">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 hidden-xs">
                    <div class="bar__module">
                        <a href="{{ route('id.home')}}">
                            <img class="logo logo-dark" alt="logo" src="{{ URL::asset('guest/img/lib/logo_navbar.png') }}" />
                        </a>
                    </div>
                    <!--end module-->
                </div>
                <div class="col-lg-10 col-md-12 text-right text-left-xs text-left-sm">
                    <div class="bar__module m-b-20">
                        <ul class="menu-horizontal text-left">  
                            <li class="dropdown">
                                <span class="dropdown__trigger">Pendidikan</span>
                                <div class="dropdown__container">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-8 dropdown__content dropdown__content--lg bg--dark bg-blue-trans">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <h5>Program</h5>
                                                        <ul class="menu-vertical">
                                                            <li>
                                                                <a href="{{route ('id.program_pendidikan')}}">
                                                                    Sarjana & Pascasarjana
                                                                </a>
                                                            </li>                                                                    
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h5>Fakultas</h5>
                                                        <ul class="menu-vertical">
                                                            @foreach($all_fakultas as $fakultas)
                                                            <li>
                                                                <a href="{{route('id.fak', $fakultas->slug)}}">
                                                                    {{$fakultas->nama_fakultas}}
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h5>Dokumen Akademik</h5>
                                                        <ul class="menu-vertical">
                                                            <li>
                                                                <a href="{{ route('id.list_kalender')}}">
                                                                    Kalender Akademik
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end dropdown content-->
                                        </div>
                                    </div>
                                </div>
                                <!--end dropdown container-->
                            </li>
                            <li class="dropdown">
                                <span class="dropdown__trigger">Kemahasiswaan</span>
                                <div class="dropdown__container">
                                    <div class="container">
                                        <div class="row">
                                            <div class="dropdown__content col-lg-3 col-md-4 bg--dark bg-blue-trans">
                                                <ul class="menu-vertical">
                                                    <li>
                                                        <a href="{{ route('id.bem')}}">BEM UNHI</a>
                                                        <!--end dropdown container-->
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('id.senat')}}">Senat Mahasiswa</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('id.ukm')}}">Unit Kegiatan Mahasiswa</a>
                                                    </li>                                                    
                                                </ul>
                                            </div>
                                            <!--end dropdown content-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                </div>
                                <!--end dropdown container-->
                            </li>
                            <li class="dropdown">
                                <span class="dropdown__trigger">Unit</span>
                                <div class="dropdown__container">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-7 dropdown__content dropdown__content--lg bg--dark bg-blue-trans">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h5>Biro</h5>
                                                        <ul class="menu-vertical">
                                                            @foreach($biro_all as $biro)
                                                            <li>
                                                                <a href="{{route('id.biro', $biro->slug)}}">
                                                                    {{$biro->nama_biro}}
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                                                       
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h5>Unit</h5>
                                                        <ul class="menu-vertical">
                                                            <li>
                                                                <a href="{{route ('id.inbis.latar_belakang')}}">
                                                                    Inkubator Bisnis
                                                                </a>
                                                            </li>  
                                                        </ul>
                                                    </div>

                                                </div>
                                            </div>
                                            <!--end dropdown content-->
                                        </div>
                                    </div>
                                </div>
                                <!--end dropdown container-->
                            </li>
                            <li class="dropdown">
                                <span class="dropdown__trigger">Layanan</span>
                                <div class="dropdown__container">
                                    <div class="container">
                                        <div class="row">
                                            <div class="dropdown__content col-lg-3 col-md-4 bg--dark bg-blue-trans">
                                                <ul class="menu-vertical">
                                                    <li>
                                                        <a href="http://ejournal.unhi.ac.id" target="_blank">Open Jurnal Sistem (OJS) UNHI</a>
                                                        <!--end dropdown container-->
                                                    </li>                                                                                         
                                                </ul>
                                            </div>
                                            <!--end dropdown content-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                </div>
                                <!--end dropdown container-->
                            </li>  
                            <li>
                                <a href="{{ route('id.sejarah')}}">Tentang Unhi</a>
                                <!--end dropdown container-->
                            </li>
                        </ul>
                    </div>
                    <!--end module-->
                </div>
            </div>
            <!--end of row-->
        </div>
        <!--end of container-->
    </nav>
    <!--end bar-->
</div>