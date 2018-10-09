<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Kalender;
use App\Http\Controllers\Controller;
use App\Http\Traits\FakultasTrait;
use App\Berita;
use App\Http\Traits\BiroTrait;

class DokumenAkademikController extends Controller
{
    use FakultasTrait;
    use BiroTrait;
    public function listKalender()
    {
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        $kalender = Kalender::where('status',1)->get();
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        return view('guest.id.kalender.list_kalender', compact('all_fakultas','kalender','sidebar_beritas','biro_all'));
    }
    
    public function showKalender($tahun_ajaran)
    {
        $kalender = Kalender::where('tahun_ajaran',$tahun_ajaran)->get();
        return response()->file($kalender[0]->url);
    }
}
