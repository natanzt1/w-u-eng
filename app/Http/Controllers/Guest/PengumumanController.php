<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pengumuman;
use App\Http\Traits\FakultasTrait;
use App\Berita;
use App\Http\Traits\BiroTrait;

class PengumumanController extends Controller
{
    use FakultasTrait;
    use BiroTrait;

    public function listPengumuman()
    {
        $infos = Pengumuman::latest()->where('status',1)->paginate(6,['id','nama_pengumuman','konten','status','slug','thumbnail_url','created_at']);
        // return $infos;
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        // return $sidebar_berita;
        return view('guest.id.pengumuman.list_info',compact('infos','all_fakultas','sidebar_beritas','biro_all'));
    }

    public function detailPengumuman($slug)
    {
        $info = Pengumuman::where('slug', $slug)->first();
        // return $info;
        $sidebar_infos = Pengumuman::latest()->where('status',1)->where('slug','!=', $slug)->get()->take(6);
        // return $sidebar_info;
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        $info->views = $info->views + 1;
        $info->save();

        return view('guest.id.pengumuman.detail_info',compact('info','all_fakultas','sidebar_infos','biro_all'));

    }
}
