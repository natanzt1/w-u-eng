<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\FakultasTrait;
use App\Gallery;
use App\DetailGallery;
use App\Http\Traits\BiroTrait;

class GaleriController extends Controller
{
    use FakultasTrait;
    use BiroTrait;
    public function listGallery($slug)
    {
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        $gallery_selected = Gallery::where('slug',$slug)->first();
        $detailgallery_selected = DetailGallery::where('tb_gallery_id',$gallery_selected->id)->get();
        // return $detailgallery_selected[0]->gallery->nama_gallery; 

        $list_gallery = Gallery::latest()->with('detailgallery')->where('status',1)->get();
        // $detailgallery1 = DetailGallery::where('tb_gallery_id',$list_gallery[]->id)->first();
        // return $list_gallery[0]->slug;
        // return $list_gallery[0]->detailgallery[0]->thumbnail_url;
        return view('guest.id.list_gallery',compact('all_fakultas','gallery_selected','detailgallery_selected','list_gallery','biro_all'));
    }
}
