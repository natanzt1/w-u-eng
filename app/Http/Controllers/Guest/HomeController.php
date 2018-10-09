<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Slider;
use App\Agenda;
use App\Berita;
use App\Pengumuman;
use App\AgamaBudaya;
use App\Video;
use App\Tentang;
use App\DetailTentang;
use Jenssegers\Date\Date;
use App\Http\Traits\FakultasTrait;
use App\Http\Traits\BiroTrait;
use App\Gallery;
use App\DetailGallery;
use Illuminate\Support\Facades\Input;


class HomeController extends Controller
{
    use FakultasTrait;
    use BiroTrait;

    public function index()
    {
        
        Date::setLocale('id');
        $sliders = Slider::where('status',1)->get(['id','nama_slider','konten','status','thumbnail_url']);
        // return $sliders;
        $pengumumans = Pengumuman::latest()->where('status',1)->get(['id','nama_pengumuman','status','thumbnail_url','slug'])->take(2);
        // return $pengumumans;
        $pengumuman_mobile = Pengumuman::latest()->where('status',1)->skip(2)->first(['id','nama_pengumuman','status','thumbnail_url','slug']);
        $pengumumans2 = Pengumuman::latest()->where('status',1)->skip(3)->take(2)->get(['id','nama_pengumuman','status','thumbnail_url','created_at','slug','konten']);
        // return $pengumumans2;
        $beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','thumbnail_url','tgl_rilis','slug'])->take(5);
        // return $beritas;
        // return $beritas[2]->created_at->format('l, d F Y');
        $headlines = Berita::orderBy('tgl_rilis', 'desc')->where('status',2)->get(['id','nama_berita','status','thumbnail_url','konten','tgl_rilis','slug'])->take(5);
        // return $headline;
        $agendas = Agenda::where('status',1)->orderBy('waktu_mulai', 'desc')->get(['id','nama_agenda','lokasi','status','waktu_mulai', 'waktu_selesai','slug','created_at'])->take(4);
        // return $agendas;
        $agama_budaya = AgamaBudaya::where('status',1)->first(['nama_agamabudaya','status','thumbnail_url','konten','created_at','slug']);
        // return $agama_budaya;
        $video = Video::where('status', 1)->first(['id','nama_video','url','slug']);


        $gallery1 = Gallery::latest()->where('status','1')->first();
        $detailgallery1 = DetailGallery::where('tb_gallery_id', $gallery1->id)->first();

        $gallery2 = Gallery::latest()->skip(2)->where('status','1')->first();
        // return $gallery2;
        $detailgallery2 = DetailGallery::where('tb_gallery_id', $gallery2->id)->first();

        $gallery3 = Gallery::latest()->skip(3)->where('status','1')->first();
        // return $gallery3;
        $detailgallery3 = DetailGallery::where('tb_gallery_id', $gallery3->id)->first();

        $gallery4 = Gallery::latest()->skip(4)->where('status','1')->first();
        $detailgallery4 = DetailGallery::where('tb_gallery_id', $gallery4->id)->first();

        $url_video = $video->getYoutubeId();
        // return $url_video;

        $ayurweda = $this->ayurweda();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        
        return view('guest.id.index',compact('sliders','pengumumans','agama_budaya','pengumuman_mobile',
        'pengumumans2','beritas','headlines','agendas','url_video','all_fakultas','video', 'detailgallery1',
        'detailgallery2','detailgallery3','detailgallery4','ayurweda','biro_all'));
    }

    public function indexEnglish()
    {
        // Date::setLocale('nl');
        $sliders = Slider::where('status',1)->get(['id','nama_slider','konten','status','thumbnail_url']);
        // return $sliders;
        $pengumumans = Pengumuman::latest()->where('status',1)->get(['id','nama_pengumuman','status','thumbnail_url','slug'])->take(2);
        // return $pengumumans;
        $pengumuman_mobile = Pengumuman::latest()->where('status',1)->skip(2)->first(['id','nama_pengumuman','status','thumbnail_url','slug']);
        $pengumumans2 = Pengumuman::latest()->where('status',1)->skip(3)->take(2)->get(['id','nama_pengumuman','status','thumbnail_url','created_at','slug','konten']);
        // return $pengumumans2;
        $beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','thumbnail_url','tgl_rilis','slug'])->take(5);
        // return $beritas;
        // return $beritas[2]->created_at->format('l, d F Y');
        $headlines = Berita::orderBy('tgl_rilis', 'desc')->where('status',2)->get(['id','nama_berita','status','thumbnail_url','konten','tgl_rilis','slug'])->take(5);
        // return $headline;
        $agendas = Agenda::where('status',1)->orderBy('waktu_mulai', 'desc')->get(['id','nama_agenda','lokasi','status','waktu_mulai', 'waktu_selesai','slug','created_at'])->take(4);
        // return $agendas;
        $agama_budaya = AgamaBudaya::where('status',1)->first(['nama_agamabudaya','status','thumbnail_url','konten','created_at','slug']);
        // return $agama_budaya;
        $video = Video::where('status', 1)->first(['id','nama_video','url','slug']);


        $gallery1 = Gallery::latest()->where('status','1')->first();
        $detailgallery1 = DetailGallery::where('tb_gallery_id', $gallery1->id)->first();
        // return $detailgallery1->gallery->slug;

        $gallery2 = Gallery::latest()->skip(1)->where('status','1')->first();
        $detailgallery2 = DetailGallery::where('tb_gallery_id', $gallery2->id)->first();

        $gallery3 = Gallery::latest()->skip(2)->where('status','1')->first();
       
        $detailgallery3 = DetailGallery::where('tb_gallery_id', $gallery3->id)->first();

        $gallery4 = Gallery::latest()->skip(3)->where('status','1')->first();
        $detailgallery4 = DetailGallery::where('tb_gallery_id', $gallery4->id)->first();

        $url_video = $video->getYoutubeId();
        // return $url_video;

        $ayurweda = $this->ayurweda();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        
        return view('guest.en.index',compact('sliders','pengumumans','agama_budaya','pengumuman_mobile',
        'pengumumans2','beritas','headlines','agendas','url_video','all_fakultas','video', 'detailgallery1',
        'detailgallery2','detailgallery3','detailgallery4','ayurweda','biro_all'));
    }

    public function search()
    {
        $keywords = Input::get('query');
        $result_berita = Berita::where('nama_berita', 'LIKE', "%".$keywords."%")
                        ->orderBy('tgl_rilis','DESC')
                        ->get();
        $result_pengumuman = Pengumuman::where('nama_pengumuman', 'LIKE', "%".$keywords."%")
                        ->orderBy('tgl_rilis','DESC')
                        ->get();
        $result_agenda = Agenda::where('nama_agenda', 'LIKE', "%".$keywords."%")
                        ->orderBy('tgl_rilis','DESC')
                        ->get();

        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.search', compact('all_fakultas','biro_all','sidebar_beritas','result_agenda','result_pengumuman','result_berita','keywords'));
    }

}
