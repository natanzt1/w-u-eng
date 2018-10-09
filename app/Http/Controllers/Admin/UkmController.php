<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ukm;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ukmController extends Controller
{
    public function Index()
    {
        $datas = ukm::all();
    	return view('admin.ukm.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.ukm.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_ukm'   => 'required|unique:tb_ukm|max:255',
                
            ]);
        
    	$nama_ukm = $req->nama_ukm;
    	$konten_ukm = $req->konten_ukm;
        $thumbnail = $req->file('thumbnail');
        
        $slug = str_replace(' ', '-', $nama_ukm);
    	$ukm = new ukm();
    	$ukm->nama_ukm = $nama_ukm;
    	$ukm->konten = $konten_ukm;
        $ukm->slug = $slug;
    	$ukm->status = 1;
    	$ukm->save();

        if(isset($thumbnail)){
            $ukm = ukm::where('slug', $slug)->get();
            $id = $ukm[0]->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/ukm/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/ukm/'.$thumbnail_name;
            $ukm[0]->thumbnail_url = $thumbnail_url;
            $ukm[0]->save();
        }
        
    	return redirect(route('admin.ukm.index'));
    }

    public function Show($slug)
    {
        $datas = ukm::where('slug', $slug)->get();
        $source = "show";
        return view('admin.ukm.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $data = ukm::where('slug', $slug)->get();
    	return view('admin.ukm.edit', compact('data','slug'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = ukm::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_ukm'   => 'required|max:255',
                'konten_ukm' => 'required'
            ]);    
        
        $nama_ukm_new = $req->nama_ukm;
        $konten_ukm_new = $req->konten_ukm;
        $create_slug = str_replace(' ', '-', $nama_ukm_new);
        
        if($datas[0]->nama_ukm != $nama_ukm_new){
            $validated2 = $req->validate([
                'nama_ukm' => 'unique:tb_ukm'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = ukm::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_ukm = $nama_ukm_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->konten = $konten_ukm_new;
        if($req->file('thumbnail') != null ){
            $id = $datas[0]->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/ukm/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/ukm/'.$thumbnail_name;
            $datas[0]->thumbnail_url = $thumbnail_url;
        }
        $datas[0]->save();
        return redirect(route('admin.ukm.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_ukm = $req->nama_ukm;
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
                       
        $ukm = ukm::where('slug', $slug_old)->get();
        $ukm[0]->nama_ukm = $nama_ukm;
        $ukm[0]->konten = $konten;
        $ukm[0]->slug = $slug_new;
        $ukm[0]->thumbnail_url = $thumbnail_url;
        $ukm[0]->user_id = 1; //Pengedit ukm
        $ukm[0]->save();
        return redirect(route('admin.ukm.index'));
    }

    public function Active($slug)
    {
        $ukm = ukm::where('slug', $slug)->get();
        $ukm[0]->status = 1;
        $ukm[0]->save();
        return redirect(route('admin.ukm.index'));
    }

    public function NonActive($slug)
    {
        $ukm = ukm::where('slug', $slug)->get();
        $ukm[0]->status = 0;
        $ukm[0]->save();        
        return redirect(route('admin.ukm.index'));
    }

    public function Delete($slug)
    {
        $ukm = ukm::where('slug', $slug)->get();
        $image_path = $ukm[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $ukm[0]->delete();
        return redirect(route('admin.ukm.index'));
    }

    /*Cadangan
    public function ukmUpdate2($slug_old, Request $req)
    {    
        $ukm_old = ukm::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_ukm'   => 'required|max:255',
                'konten_ukm' => 'required'
            ]);    
        
        $nama_ukm_new = $req->nama_ukm;
        $konten_ukm_new = $req->konten_ukm;
        $create_slug = str_replace(' ', '-', $nama_ukm_new);
        
        foreach($ukm_old as $ukm){
            if($ukm->nama_ukm != $nama_ukm_new){
                $validated2 = $req->validate([
                    'nama_ukm' => 'unique:tb_ukm'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = ukm::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        ukm::where('slug', $slug_old)
          ->update(['nama_ukm' => $nama_ukm_new , 'konten' => $konten_ukm_new , 'slug' => $slug_new]);
    	return redirect(route('admin.ukm.index'));
    }*/

}   
