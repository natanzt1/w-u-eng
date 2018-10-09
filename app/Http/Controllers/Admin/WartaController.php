<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\warta;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class wartaController extends Controller
{
    public function Index()
    {
        $datas = warta::all();
    	return view('admin.warta.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.warta.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_warta'   => 'required|unique:tb_warta|max:255',
            ]);
        
    	$nama_warta = $req->nama_warta;
    	$thumbnail = $req->file('thumbnail');
        
        $slug = str_replace(' ', '-', $nama_warta);
        $slug = str_replace('/', '-', $slug);
    	$warta = new warta();
    	$warta->nama_warta = $nama_warta;
        $warta->slug = $slug;
    	$warta->user_id = 1;
    	$warta->status = 0;
    	$warta->save();

        $warta = warta::where('slug', $slug)->get();
        $id = $warta[0]->id;
        $image_name = $thumbnail->getClientOriginalName();
        $extension = explode('.', $image_name);
        $extension = end($extension);
        $thumbnail_name = $id.'.'.$extension;
        $thumbnail->storeAs('admin/warta/', $thumbnail_name, 'public');
        $thumbnail_url = 'admin/warta/'.$thumbnail_name;
        $warta[0]->url = $thumbnail_url;
        $warta[0]->save();
        return redirect(route('admin.warta.index'));
    }

    public function Show($slug)
    {
        $datas = warta::where('slug', $slug)->get();
        $source = "show";
        return view('admin.warta.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $data = warta::where('slug', $slug)->get();
        return view('admin.warta.edit', compact('data','slug'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = warta::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_warta'   => 'required|max:255',
            ]);    
        
        $nama_warta_new = $req->nama_warta;
        $thumbnail_new = $req->file('thumbnail');
        $create_slug = str_replace(' ', '-', $nama_warta_new);
        
        if($datas[0]->nama_warta != $nama_warta_new){
            $validated2 = $req->validate([
                'nama_warta' => 'unique:tb_warta'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = warta::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_warta = $nama_warta_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->save();

        if(isset($thumbnail)){
            $warta = warta::where('slug', $slug)->get();
            $id = $warta[0]->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/warta/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/warta/'.$thumbnail_name;
            $warta[0]->thumbnail_url = $thumbnail_url;
            $warta[0]->save();    
        }
        return redirect(route('admin.warta.index'));
    }

    public function Active($slug)
    {
        $all = warta::all();
        foreach($all as $one){
            $one->status = 0;
            $one->save();
        }
        $warta = warta::where('slug', $slug)->get();
        $warta[0]->status = 1;
        $warta[0]->save();
        return redirect(route('admin.warta.index'));
    }

    public function NonActive($slug)
    {
        $warta = warta::where('slug', $slug)->get();
        $warta[0]->status = 0;
        $warta[0]->save();        
        return redirect(route('admin.warta.index'));
    }

    public function Delete($slug)
    {
        $warta = warta::where('slug', $slug)->get();
        $image_path = $warta[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $warta[0]->delete();
        return redirect(route('admin.warta.index'));
    }

}   
