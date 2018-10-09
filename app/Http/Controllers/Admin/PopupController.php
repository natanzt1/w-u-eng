<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\popup;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class PopupController extends Controller
{
    public function Index()
    {
        $datas = popup::all();
    	return view('admin.popup.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.popup.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_popup'   => 'required|unique:tb_popup|max:255',
                'thumbnail'      => 'required|image'
            ]);
        
    	$nama_popup = $req->nama_popup;
    	$thumbnail = $req->file('thumbnail');
        
        $slug = str_replace(' ', '-', $nama_popup);
        $slug = str_replace('/', '-', $slug);
    	$popup = new popup();
    	$popup->nama_popup = $nama_popup;
        $popup->slug = $slug;
    	$popup->user_id = 1;
    	$popup->status = 0;
    	$popup->save();

        if(isset($thumbnail)){
            $popup = popup::where('slug', $slug)->get();
            $id = $popup[0]->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/popup/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/popup/'.$thumbnail_name;
            $popup[0]->thumbnail_url = $thumbnail_url;
            $popup[0]->save();    
        }
        
        return redirect(route('admin.popup.index'));
    }

    public function Show($slug)
    {
        $datas = popup::where('slug', $slug)->get();
        $source = "show";
        return view('admin.popup.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $data = popup::where('slug', $slug)->get();
        return view('admin.popup.edit', compact('data','slug'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = popup::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_popup'   => 'required|max:255',
            ]);    
        
        $nama_popup_new = $req->nama_popup;
        $thumbnail_new = $req->file('thumbnail');
        $create_slug = str_replace(' ', '-', $nama_popup_new);
        
        if($datas[0]->nama_popup != $nama_popup_new){
            $validated2 = $req->validate([
                'nama_popup' => 'unique:tb_popup'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = popup::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_popup = $nama_popup_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->save();

        if(isset($thumbnail)){
            $popup = popup::where('slug', $slug)->get();
            $id = $popup[0]->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/popup/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/popup/'.$thumbnail_name;
            $popup[0]->thumbnail_url = $thumbnail_url;
            $popup[0]->save();    
        }
        return redirect(route('admin.popup.index'));
    }

    public function Active($slug)
    {
        $all = popup::all();
        foreach($all as $one){
            $one->status = 0;
            $one->save();
        }
        $popup = popup::where('slug', $slug)->get();
        $popup[0]->status = 1;
        $popup[0]->save();
        return redirect(route('admin.popup.index'));
    }

    public function NonActive($slug)
    {
        $popup = popup::where('slug', $slug)->get();
        $popup[0]->status = 0;
        $popup[0]->save();        
        return redirect(route('admin.popup.index'));
    }

    public function Delete($slug)
    {
        $popup = popup::where('slug', $slug)->get();
        $image_path = $popup[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $popup[0]->delete();
        return redirect(route('admin.popup.index'));
    }

}   
