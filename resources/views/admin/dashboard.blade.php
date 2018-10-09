@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('css')
@endsection
@section('page-name')
Dashboard SAMAWEDA
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.agamabudaya.index')}}">
                            <i class="mdi mdi-file-chart"></i><br>
                            Agama Budaya</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.agenda.index')}}">
                            <i class="mdi mdi-calendar-check"></i><br>
                            Agenda</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                             <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.berita.index')}}">
                            <i class="mdi mdi-newspaper"></i><br>
                            Berita</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.kalender.index')}}">
                            <i class="mdi mdi-calendar"></i><br>
                            Kalender Akademik</a></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.pengumuman.index')}}">
                            <i class="mdi mdi-bullhorn"></i><br>
                            Pengumuman</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.inkubator.index')}}">
                            <i class="mdi mdi-coin"></i><br>
                            Inkubator Bisnis</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.tentang.index')}}">
                            <i class="mdi mdi-account-star"></i><br>
                            Profil UNHI</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.fakultas.index')}}">
                            <i class="mdi mdi-account-network"></i><br>
                            Profil Fakultas</a></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.prodi.index')}}">
                            <i class="mdi mdi-account-card-details"></i><br>
                            Profil Prodi</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.bem.index')}}">
                            <i class="mdi mdi-account-network"></i><br>
                            Profil BEM</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.senat.index')}}">
                            <i class="mdi mdi-account-network"></i><br>
                            Profil Senat</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.ukm.index')}}">
                            <i class="mdi mdi-human-handsup"></i><br>
                            Profil UKM</a></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.repository.index')}}">
                            <i class="mdi mdi-file-chart"></i><br>
                            Repository</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.slider.index')}}">
                            <i class="mdi mdi-file-image"></i><br>
                            Slider</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.video.index')}}">
                            <i class="mdi mdi-video"></i><br>
                            Video</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.warta.index')}}">
                            <i class="mdi mdi-newspaper"></i><br>
                            Warta UNHI</a></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.gallery.index')}}">
                            <i class="mdi mdi-google-photos"></i><br>
                            Gallery</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1><a class="waves-effect waves-dark" aria-expanded="false" href="{{route('admin.biro.index')}}">
                            <i class="mdi mdi-account-network"></i><br>
                            Biro</a></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('js')
@endsection