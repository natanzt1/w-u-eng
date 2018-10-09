<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\senat;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class senatController extends Controller
{
    public function Index()
    {
        $datas = senat::all();
    	return view('admin.senat.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.senat.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_senat'   => 'required|unique:tb_senat|max:255',
                
            ]);
        
    	$nama_senat = $req->nama_senat;
    	$konten_senat = $req->konten_senat;
        $logo = $req->file('logo');
        
        $slug = str_replace(' ', '-', $nama_senat);
    	$senat = new senat();
    	$senat->nama_senat = $nama_senat;
    	$senat->konten = $konten_senat;
        $senat->slug = $slug;
    	$senat->status = 1;
    	$senat->save();

        if(isset($logo)){
            $senat = senat::where('slug', $slug)->get();
            $id = $senat[0]->id;
            $image_name = $logo->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $logo_name = $id.'.'.$extension;
            $logo->storeAs('admin/senat/', $logo_name, 'public');
            $logo_url = 'admin/senat/'.$logo_name;
            $senat[0]->logo_url = $logo_url;
            $senat[0]->save();
        }
        
    	return redirect(route('admin.senat.index'));
    }

    public function Show($slug)
    {
        $datas = senat::where('slug', $slug)->get();
        $source = "show";
        return view('admin.senat.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $data = senat::where('slug', $slug)->get();
    	return view('admin.senat.edit', compact('data','slug'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = senat::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_senat'   => 'required|max:255',
                'konten_senat' => 'required'
            ]);    
        
        $nama_senat_new = $req->nama_senat;
        $konten_senat_new = $req->konten_senat;
        $create_slug = str_replace(' ', '-', $nama_senat_new);
        
        if($datas[0]->nama_senat != $nama_senat_new){
            $validated2 = $req->validate([
                'nama_senat' => 'unique:tb_senat'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = senat::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_senat = $nama_senat_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->konten = $konten_senat_new;
        if($req->file('logo') != null ){
            $id = $datas[0]->id;
            $logo = $req->file('logo');
            $image_name = $logo->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $logo_name = 'temp'.$id.'.'.$extension;
            $logo->storeAs('admin/senat/', $logo_name, 'public');
            $logo_url = 'admin/senat/'.$logo_name;
            $datas[0]->logo_url = $logo_url;
        }
        $datas[0]->save();
        return redirect(route('admin.senat.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_senat = $req->nama_senat;
        $konten = $req->konten;
        $logo_temp = $req->logo_url;
        if (strpos($logo_temp, 'temp') == true) {
            $logo_url = explode('temp', $logo_temp);
            $logo_url = $logo_url[0].$logo_url[1];
            $rename_file = public_path($logo_url);
            $file = public_path($logo_temp);
            rename($file,$logo_url); 
        }
        else{
            $logo_url = $logo_temp;
        }
                       
        $senat = senat::where('slug', $slug_old)->get();
        $senat[0]->nama_senat = $nama_senat;
        $senat[0]->konten = $konten;
        $senat[0]->slug = $slug_new;
        $senat[0]->logo_url = $logo_url;
        $senat[0]->user_id = 1; //Pengedit senat
        $senat[0]->save();
        return redirect(route('admin.senat.index'));
    }

    public function Active($slug)
    {
        $senat = senat::where('slug', $slug)->get();
        $senat[0]->status = 1;
        $senat[0]->save();
        return redirect(route('admin.senat.index'));
    }

    public function NonActive($slug)
    {
        $senat = senat::where('slug', $slug)->get();
        $senat[0]->status = 0;
        $senat[0]->save();        
        return redirect(route('admin.senat.index'));
    }

    public function Delete($slug)
    {
        $senat = senat::where('slug', $slug)->get();
        $image_path = $senat[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $senat[0]->delete();
        return redirect(route('admin.senat.index'));
    }

    /*Cadangan
    public function senatUpdate2($slug_old, Request $req)
    {    
        $senat_old = senat::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_senat'   => 'required|max:255',
                'konten_senat' => 'required'
            ]);    
        
        $nama_senat_new = $req->nama_senat;
        $konten_senat_new = $req->konten_senat;
        $create_slug = str_replace(' ', '-', $nama_senat_new);
        
        foreach($senat_old as $senat){
            if($senat->nama_senat != $nama_senat_new){
                $validated2 = $req->validate([
                    'nama_senat' => 'unique:tb_senat'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = senat::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        senat::where('slug', $slug_old)
          ->update(['nama_senat' => $nama_senat_new , 'konten' => $konten_senat_new , 'slug' => $slug_new]);
    	return redirect(route('admin.senat.index'));
    }*/

}   
