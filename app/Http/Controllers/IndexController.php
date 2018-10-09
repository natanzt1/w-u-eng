<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agenda;
use App\Berita;
use App\Pengumuman;
use App\Slider;

class IndexController extends Controller
{
    public function index()
    {
        $agendas = Agenda::where('status', 1)
                ->orderBy('waktu_mulai')
                ->take(4)
                ->get();
        $beritas = Berita::where('status', 1)
                ->orderBy('id','desc')
                ->take(4)
                ->get();
        $pengumumans = Pengumuman::where('status', 1)
                ->orderBy('id','desc')
                ->take(4)
                ->get();
        $sliders = Slider::where('status', 1)
                ->orderBy('id','desc')
                ->get();

        return view('guest.index', compact('agendas','beritas','pengumumans','sliders'));
    }

    public function about()
    {
        return view('guest.about');
    }

    public function listBerita()
    {
        $agendas = Agenda::where('status', 1)
                ->orderBy('waktu_mulai')
                ->take(4)
                ->get();
        $beritas = Berita::where('status', 1)
                ->orderBy('id','desc')
                ->take(4)
                ->get();
        $pengumumans = Pengumuman::where('status', 1)
                ->orderBy('id','desc')
                ->take(4)
                ->get();
        $sliders = Slider::where('status', 1)
                ->orderBy('id','desc')
                ->get();
        $all_berita = Berita::orderBy('id','desc')->get();
        return view('guest.berita.list_berita', compact('agendas','beritas','pengumumans','sliders','all_berita'));
    }

    public function detailBerita($id)
    {
        $agendas = Agenda::where('status', 1)
                ->orderBy('waktu_mulai')
                ->take(4)
                ->get();
        $beritas = Berita::where('status', 1)
                ->orderBy('id','desc')
                ->take(4)
                ->get();
        $pengumumans = Pengumuman::where('status', 1)
                ->orderBy('id','desc')
                ->take(4)
                ->get();
        $sliders = Slider::where('status', 1)
                ->orderBy('id','desc')
                ->get();
        $detail_berita = Berita::find($id);
        return view('guest.detail_berita', compact('agendas','beritas','pengumumans','sliders','detail_berita'));
    }

    public function listPengumuman()
    {
        $agendas = Agenda::where('status', 1)
                ->orderBy('waktu_mulai')
                ->take(4)
                ->get();
        $beritas = Berita::where('status', 1)
                ->orderBy('id','desc')
                ->take(4)
                ->get();
        $pengumumans = Pengumuman::where('status', 1)
                ->orderBy('id','desc')
                ->take(4)
                ->get();
        $sliders = Slider::where('status', 1)
                ->orderBy('id','desc')
                ->get();
        $all_pengumuman = Pengumuman::orderBy('id','desc')->get();
        return view('guest.id.list_pengumuman', compact('agendas','beritas','pengumumans','sliders','all_pengumuman'));
    }

    public function detailPengumuman($id)
    {
        $agendas = Agenda::where('status', 1)
                ->orderBy('waktu_mulai')
                ->take(4)
                ->get();
        $beritas = Berita::where('status', 1)
                ->orderBy('id','desc')
                ->take(4)
                ->get();
        $pengumumans = Pengumuman::where('status', 1)
                ->orderBy('id','desc')
                ->take(4)
                ->get();
        $sliders = Slider::where('status', 1)
                ->orderBy('id','desc')
                ->get();
        $detail_pengumuman = Pengumuman::find($id);
        return view('guest.id.detail_pengumuman', compact('agendas','beritas','pengumumans','sliders','detail_pengumuman'));
    }

    public function listAgenda()
    {
        $agendas = Agenda::where('status', 1)
                ->orderBy('waktu_mulai')
                ->take(4)
                ->get();
        $beritas = Berita::where('status', 1)
                ->orderBy('id','desc')
                ->take(4)
                ->get();
        $pengumumans = Pengumuman::where('status', 1)
                ->orderBy('id','desc')
                ->take(4)
                ->get();
        $sliders = Slider::where('status', 1)
                ->orderBy('id','desc')
                ->get();
        $all_agenda = Agenda::orderBy('id','desc')->get();
        return view('guest.id.list_agenda', compact('agendas','beritas','pengumumans','sliders','all_agenda'));
    }

    public function detailAgenda()
    {
        //
    }
}
