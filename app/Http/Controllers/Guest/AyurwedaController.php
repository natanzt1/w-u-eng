<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\FakultasTrait;
use App\Berita;
use App\Http\Traits\BiroTrait;

class AyurwedaController extends Controller
{

    use FakultasTrait;
    use BiroTrait;

    public function listBerita()
    {
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        // return $sidebar_berita;
        return view('guest.id.ayurweda.list_berita',compact('all_fakultas','sidebar_beritas','biro_all'));
    }

    public function detailBerita()
    {
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        // return $sidebar_berita;
        return view('guest.id.ayurweda.detail_berita',compact('all_fakultas','sidebar_beritas','biro_all'));
    }
}
