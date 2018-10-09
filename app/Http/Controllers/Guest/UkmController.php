<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Ukm;
use App\Http\Controllers\Controller;
use App\Http\Traits\FakultasTrait;
use App\Berita;
use App\Http\Traits\BiroTrait;

class UkmController extends Controller
{
    use FakultasTrait;
    use BiroTrait;
    public function ukm()
    {
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
    	$ukms = Ukm::where('status',1)->get();
        return view('guest.id.kemahasiswaan.ukm.index_ukm',compact('all_fakultas', 'ukms','sidebar_beritas','biro_all'));
    }
}
