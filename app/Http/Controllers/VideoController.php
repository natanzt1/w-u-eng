<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    Public function role_check()
    {
        $id = Auth::user()->identifier;
        $role = session()->get('role');
        $role_id = $role[0]->brokerrole_id;
        return $role_id;
    }


    public function Index()
    {
        $datas = Video::latest()->get();
        $role_id = VideoController::role_check();
    	return view('admin.video.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = VideoController::role_check();
    	return view('admin.video.create',compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_video'   => 'required|unique:tb_video|max:255',
            ]);
        
    	$nama_video = $req->nama_video;
    	$url_video = $req->url_video;

        $jenis_user =  Auth::user()->jenisuser_sso;
        if($jenis_user == 1){
            $user = Auth::user()->mhs->nama;
        }
        elseif($jenis_user == 2){
            $user = Auth::user()->dosen->nama;
        }
        elseif($jenis_user == 3){
            $user = Auth::user()->pegawai->nama;
        }
        else{
            $user = "Operator";
        }

        $slug = str_replace(' ', '-', $nama_video);
        $slug = str_replace('?', '-', $slug);
        $slug = str_replace('/', '-', $slug);
    	$video = new Video();
    	$video->nama_video = $nama_video;
    	$video->url = $url_video;
        $video->slug = $slug;
    	$video->user_nama = $user;
        $video->status = 0;
    	$video->save();

        return redirect(route('admin.video.index'));
    }

    public function Edit($slug)
    {
        $role_id = VideoController::role_check();
        $data = Video::where('slug', $slug)->first();
        return view('admin.video.edit', compact('data','role_id'));
    }

    public function Show($slug)
    {
        $datas = Video::where('slug', $slug)->get();
        $source = "show";
        return view('admin.video.preview', compact('datas','slug','source'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Video::where('slug', $slug)->first();
        $validated = $req->validate([
                'nama_video'   => 'required|max:255',
            ]);    
        
        $nama_video_new = $req->nama_video;
        $url_new = $req->url_video;
        $create_slug = str_replace(' ', '-', $nama_video_new);

        $jenis_user =  Auth::user()->jenisuser_sso;
        if($jenis_user == 1){
            $user = Auth::user()->mhs->nama;
        }
        elseif($jenis_user == 2){
            $user = Auth::user()->dosen->nama;
        }
        elseif($jenis_user == 3){
            $user = Auth::user()->pegawai->nama;
        }
        else{
            $user = "Operator";
        }
        
        if($datas->nama_video != $nama_video_new){
            $validated2 = $req->validate([
                'nama_video' => 'unique:tb_video'
            ]);
            $slug_new = str_replace(' ', '-', $nama_video_new); 
            $slug_new = str_replace('?', '-', $slug_new);
            $slug_new = str_replace('/', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        }

        $datas->nama_video = $nama_video_new;
        $datas->slug = $slug_new;
        $datas->url = $url_new;
        $datas->user_nama = $user;
        $datas->status = 0;
        $datas->save();
        return redirect(route('admin.video.index'));
    }

    public function Active($slug)
    {
        $video = Video::where('slug', $slug)->first();
        $video->status = 1;
        $video->save();
        return redirect(route('admin.video.index'));
    }

    public function NonActive($slug)
    {
        $video = Video::where('slug', $slug)->first();
        $video->status = 0;
        $video->save();        
        return redirect(route('admin.video.index'));
    }

    public function Delete($slug)
    {
        $video = Video::where('slug', $slug)->first();
        $image_path = $video->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $video->delete();
        return redirect(route('admin.video.index'));
    }

}   
