<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\FakultasTrait;
use App\Fakultas;
use App\Http\Traits\BiroTrait;
use App\GalleryFakultas;
use App\Prodi;

class FakultasController extends Controller
{
    use FakultasTrait;
    use BiroTrait;
	public function index($slug)
    {
        $profile = Fakultas::where('slug',$slug)->first(['latar_belakang','nama_fakultas','akreditasi','logo_url']);
        // return $profile;
        $session = $slug;
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.fakultas.profil',compact('all_fakultas','profile','session','biro_all'));
    }

    public function latarBelakang()
    {
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.fakultas.latar_belakang',compact('detail', 'all_fakultas','biro_all'));
    }

    public function organisasi($slug)
    {
        $profile = Fakultas::where('slug',$slug)->first(['struktur','nama_fakultas']);
        $session = $slug;
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.fakultas.organisasi',compact('all_fakultas','profile','session','biro_all'));
    }

    public function visiMisi($slug)
    {
        $profile = Fakultas::where('slug',$slug)->first(['visi','misi','tujuan','sasaran','nama_fakultas']);
        $session = $slug;
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.fakultas.visi',compact('all_fakultas','profile','session','biro_all'));
    }

    public function gallery($slug)
    {
        $profile = Fakultas::where('slug',$slug)->first(['struktur','nama_fakultas']);
        $fakultas = Fakultas::where('slug',$slug)->first();
        $fakultas_id = $fakultas->id;
        $galleries = GalleryFakultas::where('tb_fakultas_id',$fakultas_id)->get();
        $session = $slug;
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.fakultas.gallery',compact('all_fakultas','session','biro_all','galleries','profile'));
    }

    public function prodi($slug)
    {
        $profile = Fakultas::where('slug',$slug)->first(['struktur','nama_fakultas']);
        $session = $slug;
        $fakultas = Fakultas::where('slug',$slug)->first();
        $fakultas_id = $fakultas->id;
        $all_prodi = Prodi::where('fakultas_id',$fakultas_id)->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.fakultas.prodi',compact('all_fakultas','session','all_prodi','biro_all','profile'));
    }

}
