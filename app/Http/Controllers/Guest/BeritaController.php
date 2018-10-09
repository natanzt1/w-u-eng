<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Berita;
use Jenssegers\Date\Date;
use App\Http\Traits\FakultasTrait;
use App\Http\Traits\BiroTrait;

class BeritaController extends Controller
{
    use FakultasTrait;
    use BiroTrait;
    public function listBerita()
    {
        Date::setLocale('id');
        $beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->paginate(6,['id','nama_berita','konten','status','slug','thumbnail_url','tgl_rilis','views']);
        // return $beritas;
        $headlines = Berita::orderBy('tgl_rilis', 'desc')->where('status',2)->get(['id','nama_berita','status','thumbnail_url','konten','tgl_rilis','slug','views'])->take(5);
        // $beritas_random = Berita::inRandomOrder()->where('status',1)->get(['id','nama_berita','status','thumbnail_url','created_at'])->take(6);
        // return $headlines;
        $top_news = Berita::orderBy('views', 'desc')->get(['nama_berita','konten','slug','views','tgl_rilis'])->take(6);
        // return $top_news;
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.berita.list_berita',compact('beritas', 'all_fakultas','headlines','top_news','biro_all'));
    }

    public function detailBerita($slug)
    {
        $berita = Berita::where('slug', $slug)->first();
        // return $berita;
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->where('slug','!=',$slug)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        $berita->views = $berita->views + 1;
        $berita->save();
        return view('guest.id.berita.detail_berita',compact('berita', 'all_fakultas','sidebar_beritas','biro_all'));

    }

}
