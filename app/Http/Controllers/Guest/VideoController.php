<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Video;
use App\Http\Traits\FakultasTrait;
use App\Http\Traits\BiroTrait;

class VideoController extends Controller
{
    use FakultasTrait;
    use BiroTrait;
    public function listVideo($slug)
    {
        $video=Video::where('slug',$slug)->first(['id','nama_video','url','slug']);
        $ytb_id = $video->getYoutubeId();            
        // return $ytb_id;

        $videos=Video::latest()->get(['id','nama_video','url','slug']);
        // return $videos;

        // $url_video = $videos->getYoutubeId();            
        // return $url_video;
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.list_video', compact('video','ytb_id','videos','all_fakultas','biro_all'));
    }

}
