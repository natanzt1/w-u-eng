<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\video;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class videoController extends Controller
{
    public function Index()
    {
        $datas = video::all();
    	return view('admin.video.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.video.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_video'   => 'required|unique:tb_video|max:255',
                'url_video' => 'required',
            ]);
        
    	$nama_video = $req->nama_video;
    	$url_video = $req->url_video;

        $slug = str_replace(' ', '-', $nama_video);
    	$video = new video();
    	$video->nama_video = $nama_video;
    	$video->url = $url_video;
        $video->slug = $slug;
    	$video->user_id = 1;
    	$video->status = 0;
    	$video->save();

        $video = video::where('slug', $slug)->get();
        $id = $video[0]->id;
        return redirect(route('admin.video.index'));
    }

    public function Edit($slug)
    {
        $data = video::where('slug', $slug)->get();
        return view('admin.video.edit', compact('data'));
    }

    public function Show($slug)
    {
        $datas = video::where('slug', $slug)->get();
        $source = "show";
        return view('admin.video.preview', compact('datas','slug','source'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = video::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_video'   => 'required|max:255',
                'url_video' => 'required'
            ]);    
        
        $nama_video_new = $req->nama_video;
        $url_new = $req->url_video;
        $create_slug = str_replace(' ', '-', $nama_video_new);
        
        if($datas[0]->nama_video != $nama_video_new){
            $validated2 = $req->validate([
                'nama_video' => 'unique:tb_video'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = video::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_video = $nama_video_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->url = $url_new;
        $datas[0]->save();
        return redirect(route('admin.video.index'));
    }

    public function Active($slug)
    {
        $all = Video::all();
        foreach($all as $one){
            $one->status = 0;
            $one->save();
        }
        $video = video::where('slug', $slug)->get();
        $video[0]->status = 1;
        $video[0]->save();
        return redirect(route('admin.video.index'));
    }

    public function NonActive($slug)
    {
        $video = video::where('slug', $slug)->get();
        $video[0]->status = 0;
        $video[0]->save();        
        return redirect(route('admin.video.index'));
    }

    public function Delete($slug)
    {
        $video = video::where('slug', $slug)->get();
        $image_path = $video[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $video[0]->delete();
        return redirect(route('admin.video.index'));
    }

}   
