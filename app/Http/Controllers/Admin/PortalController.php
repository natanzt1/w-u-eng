<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\portal;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class portalController extends Controller
{
    public function Index()
    {
        $datas = portal::all();
    	return view('admin.portal.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.portal.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_portal'   => 'required|unique:tb_portal|max:255',
                'url_portal' => 'required',
            ]);
        
    	$nama_portal = $req->nama_portal;
    	$url_portal = $req->url_portal;
        $thumbnail = $req->file('thumbnail');

        $slug = str_replace(' ', '-', $nama_portal);
        $slug = str_replace('/', '-', $slug);
    	$portal = new portal();
    	$portal->nama_portal = $nama_portal;
    	$portal->url = $url_portal;
        $portal->slug = $slug;
    	$portal->user_id = 1;
    	$portal->status = 0;
    	$portal->save();

        if(isset($thumbnail)){
            $portal = portal::where('slug', $slug)->get();
            $id = $portal[0]->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/portal/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/portal/'.$thumbnail_name;
            $portal[0]->icon_url = $thumbnail_url;
            $portal[0]->save();    
        }
        
        return redirect(route('admin.portal.index'));
    }

    public function Edit($slug)
    {
        $data = portal::where('slug', $slug)->get();
        return view('admin.portal.edit', compact('data'));
    }

    public function show($slug)
    {
        $datas = portal::where('slug', $slug)->get();
        $source = "show";
        return view('admin.portal.preview', compact('datas','slug','source'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = portal::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_portal'   => 'required|max:255',
                'url_portal' => 'required'
            ]);    
        
        $nama_portal_new = $req->nama_portal;
        $url_new = $req->url_portal;
        $create_slug = str_replace(' ', '-', $nama_portal_new);
        
        if($datas[0]->nama_portal != $nama_portal_new){
            $validated2 = $req->validate([
                'nama_portal' => 'unique:tb_portal'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = portal::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_portal = $nama_portal_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->url = $url_new;
        $datas[0]->save();
        return redirect(route('admin.portal.index'));
    }

    public function Active($slug)
    {
        $portal = portal::where('slug', $slug)->get();
        $portal[0]->status = 1;
        $portal[0]->save();
        return redirect(route('admin.portal.index'));
    }

    public function NonActive($slug)
    {
        $portal = portal::where('slug', $slug)->get();
        $portal[0]->status = 0;
        $portal[0]->save();        
        return redirect(route('admin.portal.index'));
    }

    public function Delete($slug)
    {
        $portal = portal::where('slug', $slug)->get();
        $image_path = $portal[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $portal[0]->delete();
        return redirect(route('admin.portal.index'));
    }

}   
