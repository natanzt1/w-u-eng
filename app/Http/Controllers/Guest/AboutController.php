<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Tentang;
use App\DetailTentang;
use App\Http\Controllers\Controller;
use App\Http\Traits\FakultasTrait;
use App\Http\Traits\BiroTrait;

class AboutController extends Controller
{
    use FakultasTrait;
    use BiroTrait;
    public function aboutSejarah()
    {
        $sejarah = Tentang::where('nama_tentang', 'sejarah')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.about.sejarah', compact('sejarah','all_fakultas','biro_all'));
    }

    public function aboutVisiMisi()
    {
        $visi = Tentang::where('nama_tentang', 'Visi')->get();
        $misi = Tentang::where('nama_tentang', 'misi')->get();
        $tujuan = Tentang::where('nama_tentang', 'tujuan')->first();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.about.visi', compact('visi','misi','tujuan','all_fakultas','biro_all'));
    }

    public function aboutMaknaLambang()
    {
        $makna = Tentang::where('nama_tentang', 'Makna Lambang')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.about.makna_lambang', compact('makna','all_fakultas','biro_all'));
    }

    public function aboutRektorUnhi()
    {
        $rektor = Tentang::where('nama_tentang', 'Rektor Unhi')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.about.rektor_unhi', compact('rektor','all_fakultas','biro_all'));
    }

    public function pimpinanUnhi()
    {
        $pimpinan = Tentang::where('nama_tentang', 'Pimpinan Unhi')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.about.pimpinan_unhi', compact('pimpinan','all_fakultas','biro_all'));
    }

    public function organisasiUnhi()
    {
        $org_unhi = Tentang::where('nama_tentang', 'Organisasi Unhi')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.about.organisasi', compact('org_unhi','all_fakultas','biro_all'));
    }


    public function aboutSejarahEnglish()
    {
        $sejarah = Tentang::where('nama_tentang', 'sejarah')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.en.about.sejarah', compact('sejarah','all_fakultas','biro_all'));
    }

    public function aboutVisiMisiEnglish()
    {
        $visi = Tentang::where('nama_tentang', 'Visi')->get();
        $misi = Tentang::where('nama_tentang', 'misi')->get();
        $tujuan = Tentang::where('nama_tentang', 'tujuan')->first();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.en.about.visi', compact('visi','misi','tujuan','all_fakultas','biro_all'));
    }

    public function aboutMaknaLambangEnglish()
    {
        $makna = Tentang::where('nama_tentang', 'Makna Lambang')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.en.about.makna_lambang', compact('makna','all_fakultas','biro_all'));
    }

    public function aboutRektorUnhiEnglish()
    {
        $rektor = Tentang::where('nama_tentang', 'Rektor Unhi')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.en.about.rektor_unhi', compact('rektor','all_fakultas','biro_all'));
    }

    public function pimpinanUnhiEnglish()
    {
        $pimpinan = Tentang::where('nama_tentang', 'Pimpinan Unhi')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.en.about.pimpinan_unhi', compact('pimpinan','all_fakultas','biro_all'));
    }

    public function organisasiUnhiEnglish()
    {
        $org_unhi = Tentang::where('nama_tentang', 'Organisasi Unhi')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.en.about.organisasi', compact('org_unhi','all_fakultas','biro_all'));
    }
}
