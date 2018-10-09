<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Berita;
use App\Slider;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
    	return view('admin.dashboard');
    }

// ----------------------------------------- //

    public function beritaIndex()
    {
        $beritas = Berita::all();
    	return view('admin.berita.index', compact('beritas'));
    }

    public function beritaCreate()
    {
    	return view('admin.berita.create');
    }

    public function beritaStore(Request $req)
    {
    	$validated = $req->validate([
                'nama_berita'   => 'required|unique:tb_berita|max:255',
                'konten_berita' => 'required',
                'thumbnail'      => 'required|image'
            ]);
        
    	$nama_berita = $req->nama_berita;
    	$konten_berita = $req->konten_berita;
        $thumbnail = $req->file('thumbnail');

        $slug = str_replace(' ', '-', $nama_berita);
    	$berita = new Berita();
    	$berita->nama_berita = $nama_berita;
    	$berita->konten = $konten_berita;
        $berita->slug = $slug;
    	$berita->user_id = 1;
    	$berita->status = 0; //otomatis save as draft saat berita masih di preview
    	$berita->save();

        $berita = Berita::where('slug', $slug)->get();
        $id = $berita[0]->id;
        $image_name = $thumbnail->getClientOriginalName();
        $extension = explode('.', $image_name);
        $extension = end($extension);
        $thumbnail_name = $id.'.'.$extension;
        $thumbnail->storeAs('admin/berita/', $thumbnail_name, 'public');
        $thumbnail_url = 'admin/berita/'.$thumbnail_name;
        $berita[0]->thumbnail_url = $thumbnail_url;
        $berita[0]->save();
        $beritas = Berita::where('slug', $slug)->get();
        $source = "create";
    	return view('admin.berita.preview', compact('beritas','slug','source'));
    }

    public function beritaPreview($slug)
    {
        $beritas = Berita::where('slug', $slug)->get();
        return view('admin.berita.preview', compact('beritas','slug'));
    }

    public function beritaActive($slug)
    {
        $berita = Berita::where('slug', $slug)->get();
        $berita[0]->status = 1;
        $berita[0]->save();
        return redirect(route('admin.berita.index'));
    }

    public function beritaNonActive($slug)
    {
        $berita = Berita::where('slug', $slug)->get();
        $berita[0]->status = 0;
        $berita[0]->save();        
        return redirect(route('admin.berita.index'));
    }

    public function beritaEdit($slug)
    {
        $berita = Berita::where('slug', $slug)->get();
    	return view('admin.berita.edit', compact('berita','slug'));
    }

    public function beritaUpdate($slug, Request $req)
    {    
        $beritas = Berita::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_berita'   => 'required|max:255',
                'konten_berita' => 'required'
            ]);    
        
        $nama_berita_new = $req->nama_berita;
        $konten_berita_new = $req->konten_berita;
        $create_slug = str_replace(' ', '-', $nama_berita_new);
        
        if($beritas[0]->nama_berita != $nama_berita_new){
            $validated2 = $req->validate([
                'nama_berita' => 'unique:tb_berita'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = Berita::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $beritas[0]->nama_berita = $nama_berita_new;
        $beritas[0]->slug = $slug_new;
        $beritas[0]->konten = $konten_berita_new;
        if($req->file('thumbnail') != null ){
            $id = $beritas[0]->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/berita/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/berita/'.$thumbnail_name;
            $beritas[0]->thumbnail_url = $thumbnail_url;
        }
        $source = "edit";
        return view('admin.berita.preview', compact('beritas','slug','source'));
    }

    public function beritaSaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_berita = $req->nama_berita;
        $konten = $req->konten;
        $thumbnail_temp = $req->thumbnail_url;
        $thumbnail_url = explode('temp', $thumbnail_temp);
        $thumbnail_url = $thumbnail_url[0].$thumbnail_url[1];
        $rename_file = public_path($thumbnail_url);
        $file = public_path($thumbnail_temp);
        rename($file,$thumbnail_url);        
        
        $berita = Berita::where('slug', $slug_old)->get();
        $berita[0]->nama_berita = $nama_berita;
        $berita[0]->konten = $konten;
        $berita[0]->slug = $slug_new;
        $berita[0]->thumbnail_url = $thumbnail_url;
        $berita[0]->user_id = 1; //Pengedit Berita
        $berita[0]->save();
        return redirect(route('admin.berita.index'));
    }

    /*Cadangan
    public function beritaUpdate2($slug_old, Request $req)
    {    
        $berita_old = Berita::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_berita'   => 'required|max:255',
                'konten_berita' => 'required'
            ]);    
        
        $nama_berita_new = $req->nama_berita;
        $konten_berita_new = $req->konten_berita;
        $create_slug = str_replace(' ', '-', $nama_berita_new);
        
        foreach($berita_old as $berita){
            if($berita->nama_berita != $nama_berita_new){
                $validated2 = $req->validate([
                    'nama_berita' => 'unique:tb_berita'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = Berita::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        Berita::where('slug', $slug_old)
          ->update(['nama_berita' => $nama_berita_new , 'konten' => $konten_berita_new , 'slug' => $slug_new]);
    	return redirect(route('admin.berita.index'));
    }*/

     public function sliderIndex()
    {
        $sliders = Slider::all();
        return view('admin.berita.index', compact('sliders'));
    }

    public function sliderCreate()
    {
        return view('admin.berita.create');
    }
}   
