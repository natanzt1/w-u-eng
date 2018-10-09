<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\inkubator;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class inkubatorController extends Controller
{
    public function Index()
    {
        $datas = inkubator::all();
    	return view('admin.inkubator.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.inkubator.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_inkubator'   => 'required|unique:tb_inkubator|max:255',
                
            ]);
        
    	$nama_inkubator = $req->nama_inkubator;
    	$konten_inkubator = $req->konten_inkubator;
        $thumbnail = $req->file('thumbnail');
        
        $slug = str_replace(' ', '-', $nama_inkubator);
    	$inkubator = new inkubator();
    	$inkubator->nama_inkubator = $nama_inkubator;
    	$inkubator->konten = $konten_inkubator;
        $inkubator->slug = $slug;
    	$inkubator->status = 1;
    	$inkubator->save();

        if(isset($thumbnail)){
            $inkubator = inkubator::where('slug', $slug)->get();
            $id = $inkubator[0]->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/inkubator/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/inkubator/'.$thumbnail_name;
            $inkubator[0]->thumbnail_url = $thumbnail_url;
            $inkubator[0]->save();
        }
        
    	return redirect(route('admin.inkubator.index'));
    }

    public function Show($slug)
    {
        $datas = inkubator::where('slug', $slug)->get();
        $source = "show";
        return view('admin.inkubator.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $data = inkubator::where('slug', $slug)->get();
    	return view('admin.inkubator.edit', compact('data','slug'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = inkubator::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_inkubator'   => 'required|max:255',
                'konten_inkubator' => 'required'
            ]);    
        
        $nama_inkubator_new = $req->nama_inkubator;
        $konten_inkubator_new = $req->konten_inkubator;
        $create_slug = str_replace(' ', '-', $nama_inkubator_new);
        
        if($datas[0]->nama_inkubator != $nama_inkubator_new){
            $validated2 = $req->validate([
                'nama_inkubator' => 'unique:tb_inkubator'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = inkubator::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_inkubator = $nama_inkubator_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->konten = $konten_inkubator_new;
        if($req->file('thumbnail') != null ){
            $id = $datas[0]->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/inkubator/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/inkubator/'.$thumbnail_name;
            $datas[0]->thumbnail_url = $thumbnail_url;
        }
        $datas[0]->save();
        return redirect(route('admin.inkubator.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_inkubator = $req->nama_inkubator;
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
                       
        $inkubator = inkubator::where('slug', $slug_old)->get();
        $inkubator[0]->nama_inkubator = $nama_inkubator;
        $inkubator[0]->konten = $konten;
        $inkubator[0]->slug = $slug_new;
        $inkubator[0]->thumbnail_url = $thumbnail_url;
        $inkubator[0]->user_id = 1; //Pengedit inkubator
        $inkubator[0]->save();
        return redirect(route('admin.inkubator.index'));
    }

    public function Active($slug)
    {
        $inkubator = inkubator::where('slug', $slug)->get();
        $inkubator[0]->status = 1;
        $inkubator[0]->save();
        return redirect(route('admin.inkubator.index'));
    }

    public function NonActive($slug)
    {
        $inkubator = inkubator::where('slug', $slug)->get();
        $inkubator[0]->status = 0;
        $inkubator[0]->save();        
        return redirect(route('admin.inkubator.index'));
    }

    public function Delete($slug)
    {
        $inkubator = inkubator::where('slug', $slug)->get();
        $image_path = $inkubator[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $inkubator[0]->delete();
        return redirect(route('admin.inkubator.index'));
    }

    /*Cadangan
    public function inkubatorUpdate2($slug_old, Request $req)
    {    
        $inkubator_old = inkubator::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_inkubator'   => 'required|max:255',
                'konten_inkubator' => 'required'
            ]);    
        
        $nama_inkubator_new = $req->nama_inkubator;
        $konten_inkubator_new = $req->konten_inkubator;
        $create_slug = str_replace(' ', '-', $nama_inkubator_new);
        
        foreach($inkubator_old as $inkubator){
            if($inkubator->nama_inkubator != $nama_inkubator_new){
                $validated2 = $req->validate([
                    'nama_inkubator' => 'unique:tb_inkubator'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = inkubator::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        inkubator::where('slug', $slug_old)
          ->update(['nama_inkubator' => $nama_inkubator_new , 'konten' => $konten_inkubator_new , 'slug' => $slug_new]);
    	return redirect(route('admin.inkubator.index'));
    }*/

}   
