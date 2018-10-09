<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\FakultasTrait;
use App\Berita;
use App\Prodi;
use App\Http\Traits\BiroTrait;
use App\GalleryProdi;

class ProgramPendidikanController extends Controller
{
    use FakultasTrait;
    use BiroTrait;
    public function programPendidikan()
    {
        $all_prodi_s1 = Prodi::where('status','1')
                        ->where('tingkat','S1')
                        ->get();
        $all_prodi_s2 = Prodi::where('status','1')
                        ->where('tingkat','S2')
                        ->get();
        $all_prodi_s3 = Prodi::where('status','1')
                        ->where('tingkat','S3')
                        ->get();
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.program_sarjana', compact('all_fakultas','sidebar_beritas',
        'all_prodi_s1','all_prodi_s2','all_prodi_s3','biro_all'));
    }

    public function profil($slug)
    {
        $prodi = Prodi::where('slug',$slug)->first();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.prodi.profil',compact('all_fakultas','prodi','biro_all'));
    }

    public function latarBelakang($slug)
    {
        $prodi = Prodi::where('slug',$slug)->first();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.prodi.latar_belakang',compact('all_fakultas','prodi','biro_all'));
    }

    public function organisasi($slug)
    {
        $prodi = Prodi::where('slug',$slug)->first();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.prodi.organisasi',compact('all_fakultas','prodi','biro_all'));
    }

    public function visiMisi($slug)
    {
        $prodi = Prodi::where('slug',$slug)->first();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.prodi.visi',compact('all_fakultas','prodi','biro_all'));
    }

    public function dosen($slug)
    {
        $prodi = Prodi::where('slug',$slug)->first();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.prodi.dosen',compact('all_fakultas','prodi','biro_all'));
    }

    public function gallery($slug)
    {
        $prodi = Prodi::where('slug',$slug)->first();
        $prodi_id = $prodi->id;
        $galleries = GalleryProdi::where('tb_prodi_id',$prodi_id)->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.prodi.gallery',compact('all_fakultas','prodi','biro_all','galleries'));
    }
}
