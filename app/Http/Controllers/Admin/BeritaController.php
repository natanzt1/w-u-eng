<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Berita;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Date\Date;
use App\Http\Traits\FakultasTrait;


class BeritaController extends Controller
{
    use FakultasTrait;
    public function Index()
    {
        $datas = Berita::latest()->get();
    	return view('admin.berita.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.berita.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_berita'   => 'required|unique:tb_berita|max:255',
                
                'tanggal'     => 'required',
                'waktu'     => 'required'
            ]);
        
    	$nama_berita = $req->nama_berita;
    	$konten_berita = $req->konten_berita;
        $thumbnail = $req->file('thumbnail');
        $tgl = $req->tanggal;
        $waktu = $req->waktu;

        $rilis = $tgl.' '.$waktu. ':00';

        $slug = str_replace(' ', '-', $nama_berita);
    	$berita = new Berita();
    	$berita->nama_berita = $nama_berita;
        $berita->tgl_rilis = $rilis;
    	$berita->konten = $konten_berita;
        $berita->slug = $slug;
    	$berita->user_id = 1;
    	$berita->status = 0; //otomatis save as draft saat berita masih di preview
    	$berita->save();

        if(isset($thumbnail)){
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
        }
        
    	return redirect(route('admin.berita.index'));
    }

    public function Show($slug)
    {
        $all_fakultas = $this->fakultasAll();
        $datas = Berita::where('slug', $slug)->get();
        $source = "show";
        return view('admin.berita.preview', compact('datas','slug','source','all_fakultas'));
    }

    public function Edit($slug)
    {
        $data = Berita::where('slug', $slug)->get();
    	return view('admin.berita.edit', compact('data','slug'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Berita::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_berita'   => 'required|max:255',
                'konten_berita' => 'required',
                'tanggal'     => 'required',
                'waktu'     => 'required'
            ]);    
        
        $nama_berita_new = $req->nama_berita;
        $konten_berita_new = $req->konten_berita;
        $tgl = $req->tanggal;
        $waktu = $req->waktu;

        $rilis_new = $tgl.' '.$waktu. ':00';
        $create_slug = str_replace(' ', '-', $nama_berita_new);
        
        if($datas[0]->nama_berita != $nama_berita_new){
            $validated2 = $req->validate([
                'nama_berita' => 'unique:tb_berita'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = Berita::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_berita = $nama_berita_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->tgl_rilis = $rilis_new;
        $datas[0]->konten = $konten_berita_new;
        if($req->file('thumbnail') != null ){
            $id = $datas[0]->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/berita/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/berita/'.$thumbnail_name;
            $datas[0]->thumbnail_url = $thumbnail_url;
        }
        $datas[0]->save();
        return redirect(route('admin.berita.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_berita = $req->nama_berita;
        $tgl_rilis = $req->tgl_rilis;
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
        
        $berita = Berita::where('slug', $slug_old)->get();
        $berita[0]->nama_berita = $nama_berita;
        $berita[0]->konten = $konten;
        $berita[0]->slug = $slug_new;
        $berita[0]->thumbnail_url = $thumbnail_url;
        $berita[0]->tgl_rilis = $tgl_rilis;
        $berita[0]->user_id = 1; //Pengedit Berita
        $berita[0]->save();
        return redirect(route('admin.berita.index'));
    }

    public function Active($slug)
    {
        $berita = Berita::where('slug', $slug)->get();
        $berita[0]->status = 1;
        $berita[0]->save();
        return redirect(route('admin.berita.index'));
    }

    public function NonActive($slug)
    {
        $berita = Berita::where('slug', $slug)->get();
        $berita[0]->status = 0;
        $berita[0]->save();        
        return redirect(route('admin.berita.index'));
    }

    public function Thumbnail($slug)
    {
        $all = Berita::all();
        foreach($all as $one){
            if($one->status == 1){
                $one->status = 0;
                $one->save();    
            }
        }
        $gallery = detailgallery::where('slug', $slug)->get();
        $gallery[0]->status = 1;
        $gallery[0]->save();
        return redirect(route('admin.berita.index', $slug));
    }

    public function Delete($slug)
    {
        $berita = berita::where('slug', $slug)->get();
        $image_path = $berita[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $berita[0]->delete();
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

}   
