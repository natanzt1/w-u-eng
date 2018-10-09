<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\agamabudaya;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class AgamaBudayaController extends Controller
{
    public function Index()
    {
        $datas = agamabudaya::all();
    	return view('admin.agamabudaya.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.agamabudaya.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_agamabudaya'   => 'required|unique:tb_agamabudaya|max:255',
                
            ]);
        
    	$nama_agamabudaya = $req->nama_agamabudaya;
    	$konten_agamabudaya = $req->konten_agamabudaya;
        $thumbnail = $req->file('thumbnail');
        $tgl = $req->tanggal;
        $waktu = $req->waktu;

        $rilis = $tgl.' '.$waktu. ':00';

        $slug = str_replace(' ', '-', $nama_agamabudaya);
    	$agamabudaya = new agamabudaya();
    	$agamabudaya->nama_agamabudaya = $nama_agamabudaya;
    	$agamabudaya->konten = $konten_agamabudaya;
        $agamabudaya->slug = $slug;
        $agamabudaya->tgl_rilis = $rilis;
    	$agamabudaya->user_id = 1;
    	$agamabudaya->status = 0; //otomatis save as draft saat agamabudaya masih di preview
    	$agamabudaya->save();

        if(isset($thumbnail)){
            $agamabudaya = agamabudaya::where('slug', $slug)->get();
            $id = $agamabudaya[0]->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/agamabudaya/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/agamabudaya/'.$thumbnail_name;
            $agamabudaya[0]->thumbnail_url = $thumbnail_url;
            $agamabudaya[0]->save();
        }
    	return redirect(route('admin.agamabudaya.index'));
    }

    public function Show($slug)
    {
        $datas = agamabudaya::where('slug', $slug)->get();
        $source = "show";
        return view('admin.agamabudaya.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $data = agamabudaya::where('slug', $slug)->get();
    	return view('admin.agamabudaya.edit', compact('data','slug'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = agamabudaya::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_agamabudaya'   => 'required|max:255',
            ]);    
        
        $nama_agamabudaya_new = $req->nama_agamabudaya;
        $konten_agamabudaya_new = $req->konten_agamabudaya;
        $tgl = $req->tanggal;
        $waktu = $req->waktu;

        $rilis_new = $tgl.' '.$waktu. ':00';
        $create_slug = str_replace(' ', '-', $nama_agamabudaya_new);
        
        if($datas[0]->nama_agamabudaya != $nama_agamabudaya_new){
            $validated2 = $req->validate([
                'nama_agamabudaya' => 'unique:tb_agamabudaya'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = agamabudaya::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_agamabudaya = $nama_agamabudaya_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->tgl_rilis = $rilis_new;

        $datas[0]->konten = $konten_agamabudaya_new;
        if($req->file('thumbnail') != null ){
            $id = $datas[0]->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/agamabudaya/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/agamabudaya/'.$thumbnail_name;
            $datas[0]->thumbnail_url = $thumbnail_url;
        }
        $datas[0]->save();
        return redirect(route('admin.agamabudaya.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_agamabudaya = $req->nama_agamabudaya;
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
                       
        $agamabudaya = agamabudaya::where('slug', $slug_old)->get();
        $agamabudaya[0]->nama_agamabudaya = $nama_agamabudaya;
        $agamabudaya[0]->konten = $konten;
        $agamabudaya[0]->slug = $slug_new;
        $agamabudaya[0]->thumbnail_url = $thumbnail_url;
        $agamabudaya[0]->user_id = 1; //Pengedit agamabudaya
        $agamabudaya[0]->save();
        return redirect(route('admin.agamabudaya.index'));
    }

    public function Active($slug)
    {
        $all = Agamabudaya::where('status','1')->get();
        foreach($all as $one){
            $one->status = 0;
            $one->save();
        }
        $agamabudaya = agamabudaya::where('slug', $slug)->get();
        $agamabudaya[0]->status = 1;
        $agamabudaya[0]->save();
        return redirect(route('admin.agamabudaya.index'));
    }

    public function NonActive($slug)
    {
        $agamabudaya = agamabudaya::where('slug', $slug)->get();
        $agamabudaya[0]->status = 0;
        $agamabudaya[0]->save();        
        return redirect(route('admin.agamabudaya.index'));
    }

    public function Delete($slug)
    {
        $agama = agamabudaya::where('slug', $slug)->get();
        $image_path = $agama[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $agama[0]->delete();
        return redirect(route('admin.agamabudaya.index'));
    }

    /*Cadangan
    public function agamabudayaUpdate2($slug_old, Request $req)
    {    
        $agamabudaya_old = agamabudaya::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_agamabudaya'   => 'required|max:255',
                'konten_agamabudaya' => 'required'
            ]);    
        
        $nama_agamabudaya_new = $req->nama_agamabudaya;
        $konten_agamabudaya_new = $req->konten_agamabudaya;
        $create_slug = str_replace(' ', '-', $nama_agamabudaya_new);
        
        foreach($agamabudaya_old as $agamabudaya){
            if($agamabudaya->nama_agamabudaya != $nama_agamabudaya_new){
                $validated2 = $req->validate([
                    'nama_agamabudaya' => 'unique:tb_agamabudaya'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = agamabudaya::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        agamabudaya::where('slug', $slug_old)
          ->update(['nama_agamabudaya' => $nama_agamabudaya_new , 'konten' => $konten_agamabudaya_new , 'slug' => $slug_new]);
    	return redirect(route('admin.agamabudaya.index'));
    }*/

}   
