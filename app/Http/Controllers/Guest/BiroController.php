<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\FakultasTrait;
use App\Http\Traits\BiroTrait;
use App\Biro;
use App\Berita;

class BiroController extends Controller
{
    use FakultasTrait;
    use BiroTrait;

    public function biroPilihan($slug)
    {
        $biro_pilihan = Biro::where('slug',$slug)->first();
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.biro.biro_pilihan',compact('all_fakultas','biro_all','biro_pilihan','sidebar_beritas'));
    }
}
