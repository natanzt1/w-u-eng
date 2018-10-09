<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/admin/assets/images/favicon.png')}}">
    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    @yield('css')
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('admin/css/blue.css')}}" id="theme" rel="stylesheet">

</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{route('admin.dashboard')}}">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{asset('/admin/assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="{{asset('/admin/assets/images/logo-light-icon.png')}}" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         SAMAWEDA
                         <!-- Light Logo text -->
                         <img src="{{asset('/admin/assets/images/logo-light-text.png')}}" class="light-logo" alt="homepage" /></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->

                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        {{-- @if( Auth::user()->active_role != 2 )
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" title="Ubah Role" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{ Auth::user()->role->role_name }} {{(Auth::user()->active_role == 3 ) ? Auth::user()->userrole->prodi->jenjangprodi->jenjang.' '.Auth::user()->userrole->prodi->nama_prodi .' '. Auth::user()->userrole->program->nama_program : ''}}</a>

                            @if(Auth::user()->active_role == 1 || Auth::user()->active_role == 4)
                                <div class="dropdown-menu dropdown-menu-right scale-up" style="width: 300px;">
                                    <span class="dropdown-item" style="color: #1a76d2; font-size: 12px;">FAKULTAS</span>

                                    <div class="dropdown-item">
                                        <select class="form-control form-control-sm" name="semester_id" required="">
                                            <option value="">--Pilih Fakultas--</option>
                                            @foreach($fakultas as $fak)
                                                <option value="{{ $fak->fakultas_id }}">{{ $fak->nama_fakultas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if(!empty($available_role) && count($available_role) > 0)
                                        <span class="dropdown-item" style="color: #1a76d2; font-size: 12px;">ROLE TERSEDIA</span>
                                        @foreach($available_role as $role)
                                            <a class="dropdown-item" href="#"><i class="icon icon-user"></i> {{$role->role->role_name}}</a>
                                        @endforeach
                                    @endif
                                </div>
                            @else
                                @if(!empty($available_role) && count($available_role) > 0)
                                    <div class="dropdown-menu dropdown-menu-right scale-up" style="width: 300px;">
                                        <span class="dropdown-item" style="color: #1a76d2; font-size: 12px;">ROLE TERSEDIA</span>
                                        @foreach($available_role as $role)
                                            <a class="dropdown-item" href="#"><i class="icon icon-user"></i> {{$role->role->role_name}}</a>
                                        @endforeach
                                    </div>
                                @endif
                            @endif --}}

                        </li>
                        {{-- @endif --}}
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="/admin/assets/images/users/1.jpg" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li><a href="http://sruti.unhi.ac.id/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.agamabudaya.index')}}"><i class="mdi mdi-file-chart"></i><span class="hide-menu">Agama Budaya</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.agenda.index')}}"><i class="mdi mdi-calendar-check"></i><span class="hide-menu">Agenda</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.berita.index')}}"><i class="mdi mdi-newspaper"></i><span class="hide-menu">Berita</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.gallery.index')}}"><i class="mdi mdi-google-photos"></i><span class="hide-menu">Gallery</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.kalender.index')}}"><i class="mdi mdi-calendar"></i><span class="hide-menu">Kalender Akademik</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.pengumuman.index')}}"><i class="mdi mdi-bullhorn"></i><span class="hide-menu">Pengumuman</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.inkubator.index')}}"><i class="mdi mdi-coin"></i><span class="hide-menu">Inkubator Bisnis</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.biro.index')}}"><i class="mdi mdi-account-network"></i><span class="hide-menu">Biro</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.tentang.index')}}"><i class="mdi mdi-account-star"></i><span class="hide-menu">Profil UNHI</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.fakultas.index')}}"><i class="mdi mdi-account-network"></i><span class="hide-menu">Profil Fakultas</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.prodi.index')}}"><i class="mdi mdi-account-card-details"></i><span class="hide-menu">Profil Prodi</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.bem.index')}}"><i class="mdi mdi-account-network"></i><span class="hide-menu">Profil BEM</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.senat.index')}}"><i class="mdi mdi-account-network"></i><span class="hide-menu">Profil Senat</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.ukm.index')}}"><i class="mdi mdi-human-handsup"></i><span class="hide-menu">UKM</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.repository.index')}}"><i class="mdi mdi-file-chart"></i><span class="hide-menu">Repository</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.slider.index')}}"><i class="mdi mdi-file-image"></i><span class="hide-menu">Slider</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.video.index')}}"><i class="mdi mdi-video"></i><span class="hide-menu">Video</span></a></li>
                        <li><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.warta.index')}}"><i class="mdi mdi-video"></i><span class="hide-menu">Warta Unhi</span></a></li>
                    
                    
                        {{-- <!-- menu admin-->
                        @if(Auth::user()->active_role == 1)
                            @include('layouts.menu-admin')
                        @endif
                        <!-- menu admin-->

                        <!-- menu mahasiswa-->
                        @if(Auth::user()->active_role == 2)
                            @include('layouts.menu-mhs')
                        @endif
                        <!-- menu mahasiswa-->

                        <!-- menu operator-->
                        @if(Auth::user()->active_role == 3)
                            @include('layouts.menu-operator')
                        @endif
                        <!-- menu operator-->

                        <!-- menu baa-->
                        @if(Auth::user()->active_role == 4)
                            @include('layouts.menu-baa')
                        @endif
                        <!-- menu baa-->

                        <!-- menu dosen-->
                        @if(Auth::user()->active_role == 8)
                            @include('layouts.menu-dosen')
                        @endif
                        <!-- menu dosen--> --}}

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->

        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">@yield('page-name')</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        @yield('breadcrumb')

                    </ol>
                </div>

            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                @yield('content')

                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> © 2018 Universitas Hindu Indonesia </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('/admin/js/popper.min.js')}}"></script>
    <script src="{{asset('/admin/js/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('/admin/js/jquery.slimscroll.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('/admin/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('/admin/js/sidebarmenu.js')}}"></script>
    <!--stickey kit -->
    <script src="{{asset('/admin/js/sticky-kit.min.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('/admin/js/custom.min.js')}}"></script>
    <script src="{{asset('/admin/assets/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=63b8cfqj2mfzb9duba83x4l6jtvn7uvcbctiwhfaa5a6krhy"></script>
    <script>
        $(document).ready(function() {
            tinymce.init({
                selector: "textarea",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            });
        });
    </script>
    @yield('js')
</body>

</html>