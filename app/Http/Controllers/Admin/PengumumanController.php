<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengumuman;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\FakultasTrait;

class PengumumanController extends Controller
{
    use FakultasTrait;
    public function Index()
    {
        $datas = Pengumuman::all();
    	return view('admin.pengumuman.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.pengumuman.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_pengumuman'   => 'required|unique:tb_pengumuman|max:255',
                
            ]);
        
    	$nama_pengumuman = $req->nama_pengumuman;
    	$konten_pengumuman = $req->konten_pengumuman;
        $kontak = $req->kontak;
        $website = $req->website;
        $thumbnail = $req->file('thumbnail');
        $tgl = $req->tanggal;
        $waktu = $req->waktu;

        $rilis = $tgl.' '.$waktu. ':00';

        $slug = str_replace(' ', '-', $nama_pengumuman);
    	$pengumuman = new Pengumuman();
    	$pengumuman->nama_pengumuman = $nama_pengumuman;
    	$pengumuman->konten = $konten_pengumuman;
        $pengumuman->slug = $slug;
        $pengumuman->tgl_rilis = $rilis;
        $pengumuman->kontak = $kontak;
        $pengumuman->website = $website;
    	$pengumuman->user_id = 1;
    	$pengumuman->status = 0; //otomatis save as draft saat pengumuman masih di preview
    	$pengumuman->save();

        if(isset($thumbnail)){
            $pengumuman = Pengumuman::where('slug', $slug)->get();
            $id = $pengumuman[0]->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/pengumuman/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/pengumuman/'.$thumbnail_name;
            $pengumuman[0]->thumbnail_url = $thumbnail_url;
            $pengumuman[0]->save();
        }
        
    	return redirect(route('admin.pengumuman.index'));
    }

    public function Show($slug)
    {
        $datas = Pengumuman::where('slug', $slug)->get();
        $source = "show";
        return view('admin.pengumuman.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $data = Pengumuman::where('slug', $slug)->get();
    	return view('admin.pengumuman.edit', compact('data','slug'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Pengumuman::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_pengumuman'   => 'required|max:255',
            ]);    
        
        $nama_pengumuman_new = $req->nama_pengumuman;
        $konten_pengumuman_new = $req->konten_pengumuman;
        $kontak_new = $req->kontak;
        $website_new = $req->website;
        $tgl = $req->tanggal;
        $waktu = $req->waktu;

        $rilis_new = $tgl.' '.$waktu. ':00';
        $create_slug = str_replace(' ', '-', $nama_pengumuman_new);
        
        if($datas[0]->nama_pengumuman != $nama_pengumuman_new){
            $validated2 = $req->validate([
                'nama_pengumuman' => 'unique:tb_pengumuman'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = pengumuman::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_pengumuman = $nama_pengumuman_new;
        $datas[0]->kontak = $kontak_new;
        $datas[0]->website = $website_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->konten = $konten_pengumuman_new;
        $datas[0]->tgl_rilis = $rilis_new;
        if($req->file('thumbnail') != null ){
            $id = $datas[0]->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/pengumuman/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/pengumuman/'.$thumbnail_name;
            $datas[0]->thumbnail_url = $thumbnail_url;
        }
        $datas[0]->save();
        return redirect(route('admin.pengumuman.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_pengumuman = $req->nama_pengumuman;
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
                       
        $pengumuman = pengumuman::where('slug', $slug_old)->get();
        $pengumuman[0]->nama_pengumuman = $nama_pengumuman;
        $pengumuman[0]->konten = $konten;
        $pengumuman[0]->slug = $slug_new;
        $pengumuman[0]->thumbnail_url = $thumbnail_url;
        $pengumuman[0]->user_id = 1; //Pengedit pengumuman
        $pengumuman[0]->save();
        return redirect(route('admin.pengumuman.index'));
    }

    public function Active($slug)
    {
        $pengumuman = pengumuman::where('slug', $slug)->get();
        $pengumuman[0]->status = 1;
        $pengumuman[0]->save();
        return redirect(route('admin.pengumuman.index'));
    }

    public function NonActive($slug)
    {
        $pengumuman = pengumuman::where('slug', $slug)->get();
        $pengumuman[0]->status = 0;
        $pengumuman[0]->save();        
        return redirect(route('admin.pengumuman.index'));
    }

    public function Delete($slug)
    {

        $pengumuman = pengumuman::where('slug', $slug)->get();
        $image_path = $pengumuman[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }        
        $pengumuman[0]->delete();
        
        return redirect(route('admin.pengumuman.index'));
    }

    /*Cadangan
    public function pengumumanUpdate2($slug_old, Request $req)
    {    
        $pengumuman_old = pengumuman::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_pengumuman'   => 'required|max:255',
                'konten_pengumuman' => 'required'
            ]);    
        
        $nama_pengumuman_new = $req->nama_pengumuman;
        $konten_pengumuman_new = $req->konten_pengumuman;
        $create_slug = str_replace(' ', '-', $nama_pengumuman_new);
        
        foreach($pengumuman_old as $pengumuman){
            if($pengumuman->nama_pengumuman != $nama_pengumuman_new){
                $validated2 = $req->validate([
                    'nama_pengumuman' => 'unique:tb_pengumuman'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = pengumuman::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        pengumuman::where('slug', $slug_old)
          ->update(['nama_pengumuman' => $nama_pengumuman_new , 'konten' => $konten_pengumuman_new , 'slug' => $slug_new]);
    	return redirect(route('admin.pengumuman.index'));
    }*/

}   
