<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Popup;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class PopupController extends Controller
{
    Public function role_check()
    {
        $id = Auth::user()->identifier;
        $role = session()->get('role');
        $role_id = $role[0]->brokerrole_id;
        return $role_id;
    }

    public function Index()
    {
        $datas = Popup::latest()->get();
        $role_id = PopupController::role_check();
    	return view('admin.popup.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = PopupController::role_check();
    	return view('admin.popup.create',compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_popup'   => 'required|unique:tb_popup|max:255',
                'thumbnail'      => 'required|image'
            ]);
        
    	$nama_popup = $req->nama_popup;
    	$thumbnail = $req->file('thumbnail');

        $jenis_user =  Auth::user()->jenisuser_sso;
        if($jenis_user == 1){
            $user = Auth::user()->mhs->nama;
        }
        elseif($jenis_user == 2){
            $user = Auth::user()->dosen->nama;
        }
        elseif($jenis_user == 3){
            $user = Auth::user()->pegawai->nama;
        }
        else{
            $user = "Operator";
        }
        
        $slug = str_replace(' ', '-', $nama_popup);
        $slug = str_replace('/', '-', $slug);
    	$popup = new Popup();
    	$popup->nama_popup = $nama_popup;
        $popup->slug = $slug;
    	$popup->user_nama = $user;
    	$popup->status = 0;
    	$popup->save();

        if(isset($thumbnail)){
            $popup = Popup::where('slug', $slug)->first();
            $id = $popup->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/popup/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/popup/'.$thumbnail_name;
            $popup->thumbnail_url = $thumbnail_url;
            $popup->save();    
        }
        
        return redirect(route('admin.popup.index'));
    }

    public function Show($slug)
    {
        $datas = Popup::where('slug', $slug)->get();
        $source = "show";
        return view('admin.popup.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $role_id = PopupController::role_check();
        $data = Popup::where('slug', $slug)->first();
        return view('admin.popup.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Popup::where('slug', $slug)->first();
        $validated = $req->validate([
                'nama_popup'   => 'required|max:255',
            ]);    
        
        $nama_popup_new = $req->nama_popup;
        $thumbnail_new = $req->file('thumbnail');
        $create_slug = str_replace(' ', '-', $nama_popup_new);

        $jenis_user =  Auth::user()->jenisuser_sso;
        if($jenis_user == 1){
            $user = Auth::user()->mhs->nama;
        }
        elseif($jenis_user == 2){
            $user = Auth::user()->dosen->nama;
        }
        elseif($jenis_user == 3){
            $user = Auth::user()->pegawai->nama;
        }
        else{
            $user = "Operator";
        }
        
        if($datas->nama_popup != $nama_popup_new){
            $validated2 = $req->validate([
                'nama_popup' => 'unique:tb_popup'
            ]);
            $slug_new = str_replace(' ', '-', $nama_popup_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        } 

        $datas->nama_popup = $nama_popup_new;
        $datas->slug = $slug_new;
        $datas->status = 0;
        $datas->user_nama = $user;
        $datas->save();

        if(isset($thumbnail)){
            $popup = Popup::where('slug', $slug)->first();
            $id = $popup->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/popup/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/popup/'.$thumbnail_name;
            $popup->thumbnail_url = $thumbnail_url;
            $popup->save();    
        }
        return redirect(route('admin.popup.index'));
    }

    public function Active($slug)
    {
        $all = Popup::all();
        foreach($all as $one){
            $one->status = 0;
            $one->save();
        }
        $popup = Popup::where('slug', $slug)->first();
        $popup->status = 1;
        $popup->save();
        return redirect(route('admin.popup.index'));
    }

    public function NonActive($slug)
    {
        $popup = Popup::where('slug', $slug)->first();
        $popup->status = 0;
        $popup->save();        
        return redirect(route('admin.popup.index'));
    }

    public function Delete($slug)
    {
        $popup = Popup::where('slug', $slug)->get();
        $image_path = $popup->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $popup->delete();
        return redirect(route('admin.popup.index'));
    }

}   
