<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\FakultasTrait;
use App\Berita;
use App\Http\Traits\BiroTrait;
use App\Warta;

class WartaUnhiController extends Controller
{
    use FakultasTrait;
    use BiroTrait;
    public function listWartaUnhi()
    {
        $warta_unhis = Warta::orderBy('updated_at', 'desc')->where('status','1')->get();
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.warta_unhi.list_warta_unhi',compact('all_fakultas','sidebar_beritas','biro_all','warta_unhis'));
    }
    
    public function showWartaUnhi($slug)
    {
        $warta = Warta::where('slug',$slug)->first();
        return response()->file($warta->url);
    }
}
