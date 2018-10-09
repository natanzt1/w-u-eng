<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\bem;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class bemController extends Controller
{
    public function Index()
    {
        $datas = bem::all();
    	return view('admin.bem.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.bem.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_bem'   => 'required|unique:tb_bem|max:255',
                
            ]);
        
    	$nama_bem = $req->nama_bem;
    	$konten_bem = $req->konten_bem;
        $logo = $req->file('logo');
        
        $slug = str_replace(' ', '-', $nama_bem);
    	$bem = new bem();
    	$bem->nama_bem = $nama_bem;
    	$bem->konten = $konten_bem;
        $bem->slug = $slug;
    	$bem->status = 1;
    	$bem->save();

        if(isset($logo)){
            $bem = bem::where('slug', $slug)->get();
            $id = $bem[0]->id;
            $image_name = $logo->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $logo_name = $id.'.'.$extension;
            $logo->storeAs('admin/bem/', $logo_name, 'public');
            $logo_url = 'admin/bem/'.$logo_name;
            $bem[0]->logo_url = $logo_url;
            $bem[0]->save();
        }
        
    	return redirect(route('admin.bem.index'));
    }

    public function Show($slug)
    {
        $datas = bem::where('slug', $slug)->get();
        $source = "show";
        return view('admin.bem.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $data = bem::where('slug', $slug)->get();
    	return view('admin.bem.edit', compact('data','slug'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = bem::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_bem'   => 'required|max:255',
                'konten_bem' => 'required'
            ]);    
        
        $nama_bem_new = $req->nama_bem;
        $konten_bem_new = $req->konten_bem;
        $create_slug = str_replace(' ', '-', $nama_bem_new);
        
        if($datas[0]->nama_bem != $nama_bem_new){
            $validated2 = $req->validate([
                'nama_bem' => 'unique:tb_bem'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = bem::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_bem = $nama_bem_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->konten = $konten_bem_new;
        if($req->file('logo') != null ){
            $id = $datas[0]->id;
            $logo = $req->file('logo');
            $image_name = $logo->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $logo_name = 'temp'.$id.'.'.$extension;
            $logo->storeAs('admin/bem/', $logo_name, 'public');
            $logo_url = 'admin/bem/'.$logo_name;
            $datas[0]->logo_url = $logo_url;
        }
        $datas[0]->save();
        return redirect(route('admin.bem.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_bem = $req->nama_bem;
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
                       
        $bem = bem::where('slug', $slug_old)->get();
        $bem[0]->nama_bem = $nama_bem;
        $bem[0]->konten = $konten;
        $bem[0]->slug = $slug_new;
        $bem[0]->logo_url = $logo_url;
        $bem[0]->user_id = 1; //Pengedit bem
        $bem[0]->save();
        return redirect(route('admin.bem.index'));
    }

    public function Active($slug)
    {
        $bem = bem::where('slug', $slug)->get();
        $bem[0]->status = 1;
        $bem[0]->save();
        return redirect(route('admin.bem.index'));
    }

    public function NonActive($slug)
    {
        $bem = bem::where('slug', $slug)->get();
        $bem[0]->status = 0;
        $bem[0]->save();        
        return redirect(route('admin.bem.index'));
    }

    public function Delete($slug)
    {
        $bem = bem::where('slug', $slug)->get();
        $image_path = $bem[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $bem[0]->delete();
        return redirect(route('admin.bem.index'));
    }

    /*Cadangan
    public function bemUpdate2($slug_old, Request $req)
    {    
        $bem_old = bem::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_bem'   => 'required|max:255',
                'konten_bem' => 'required'
            ]);    
        
        $nama_bem_new = $req->nama_bem;
        $konten_bem_new = $req->konten_bem;
        $create_slug = str_replace(' ', '-', $nama_bem_new);
        
        foreach($bem_old as $bem){
            if($bem->nama_bem != $nama_bem_new){
                $validated2 = $req->validate([
                    'nama_bem' => 'unique:tb_bem'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = bem::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        bem::where('slug', $slug_old)
          ->update(['nama_bem' => $nama_bem_new , 'konten' => $konten_bem_new , 'slug' => $slug_new]);
    	return redirect(route('admin.bem.index'));
    }*/

}   
