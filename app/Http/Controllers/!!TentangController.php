<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tentang;
use App\DetailTentang;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class tentangController extends Controller
{
    public function Index()
    {
        $contents = Tentang::all();
        foreach($contents as $i=>$content) {
            $datas[$i] = detailtentang::where('tentang_id', $content->id)->get();
        }
    	return view('admin.tentang.index', compact('datas','contents','i'));
    }

    public function Create()
    {
    	return view('admin.tentang.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_tentang'          => 'required|unique:tb_detailtentang|max:255',
                'konten_tentang'        => 'required',
                'thumbnail'     => 'image'
            ]);
        
    	$nama_tentang = $req->nama_tentang;
    	$konten_tentang = $req->konten_tentang;
        $thumbnail = $req->file('thumbnail');

        $slug = str_replace(' ', '-', $nama_tentang);
    	$tentang = new tentang();
    	$tentang->nama_tentang = $nama_tentang;
    	$tentang->konten = $konten_tentang;
        $tentang->slug = $slug;
    	$tentang->user_id = 1;
    	$tentang->status = 0; //otomatis save as draft saat tentang masih di preview
    	$tentang->save();

        $tentang = tentang::where('slug', $slug)->get();
        $id = $tentang[0]->id;
        $image_name = $thumbnail->getClientOriginalName();
        $extension = explode('.', $image_name);
        $extension = end($extension);
        $thumbnail_name = $id.'.'.$extension;
        $thumbnail->storeAs('admin/tentang/', $thumbnail_name, 'public');
        $thumbnail_url = 'admin/tentang/'.$thumbnail_name;
        $tentang[0]->thumbnail_url = $thumbnail_url;
        $tentang[0]->save();
    	return redirect(route('admin.tentang.show', [$slug]));
    }

    public function Show($slug)
    {
        $datas = tentang::where('slug', $slug)->get();
        $source = "show";
        return view('admin.tentang.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $data = tentang::where('slug', $slug)->get();
    	return view('admin.tentang.edit', compact('data','slug'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = tentang::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_tentang'   => 'required|max:255',
                'konten_tentang' => 'required'
            ]);    
        
        $nama_tentang_new = $req->nama_tentang;
        $konten_tentang_new = $req->konten_tentang;
        $create_slug = str_replace(' ', '-', $nama_tentang_new);
        
        if($datas[0]->nama_tentang != $nama_tentang_new){
            $validated2 = $req->validate([
                'nama_tentang' => 'unique:tb_tentang'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = tentang::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_tentang = $nama_tentang_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->konten = $konten_tentang_new;
        if($req->file('thumbnail') != null ){
            $id = $datas[0]->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/tentang/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/tentang/'.$thumbnail_name;
            $datas[0]->thumbnail_url = $thumbnail_url;
        }
        $source = "edit";
        return view('admin.tentang.preview', compact('datas','slug','source'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_tentang = $req->nama_tentang;
        $konten = $req->konten;
        $thumbnail_temp = $req->thumbnail_url;
        if (strpos($thumbnail_temp, 'temp') == true) {
            $thumbnail_url = explode('temp', $thumbnail_temp);
            $thumbnail_url = $thumbnail_url[0].$thumbnail_url[1];
            $rename_file = public_path($thumbnail_url);
            $file = public_path($thumbnail_temp);
            rename($file,$thumbnail_url); 
        }
        else{
            $thumbnail_url = $thumbnail_temp;
        }
                       
        $tentang = tentang::where('slug', $slug_old)->get();
        $tentang[0]->nama_tentang = $nama_tentang;
        $tentang[0]->konten = $konten;
        $tentang[0]->slug = $slug_new;
        $tentang[0]->thumbnail_url = $thumbnail_url;
        $tentang[0]->user_id = 1; //Pengedit tentang
        $tentang[0]->save();
        return redirect(route('admin.tentang.index'));
    }

    public function Active($slug)
    {
        $tentang = tentang::where('slug', $slug)->get();
        $tentang[0]->status = 1;
        $tentang[0]->save();
        return redirect(route('admin.tentang.index'));
    }

    public function NonActive($slug)
    {
        $tentang = tentang::where('slug', $slug)->get();
        $tentang[0]->status = 0;
        $tentang[0]->save();        
        return redirect(route('admin.tentang.index'));
    }

    /*Cadangan
    public function tentangUpdate2($slug_old, Request $req)
    {    
        $tentang_old = tentang::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_tentang'   => 'required|max:255',
                'konten_tentang' => 'required'
            ]);    
        
        $nama_tentang_new = $req->nama_tentang;
        $konten_tentang_new = $req->konten_tentang;
        $create_slug = str_replace(' ', '-', $nama_tentang_new);
        
        foreach($tentang_old as $tentang){
            if($tentang->nama_tentang != $nama_tentang_new){
                $validated2 = $req->validate([
                    'nama_tentang' => 'unique:tb_tentang'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = tentang::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        tentang::where('slug', $slug_old)
          ->update(['nama_tentang' => $nama_tentang_new , 'konten' => $konten_tentang_new , 'slug' => $slug_new]);
    	return redirect(route('admin.tentang.index'));
    }*/

}   
