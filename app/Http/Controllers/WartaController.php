<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warta;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class WartaController extends Controller
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
        $role_id = WartaController::role_check();
        $datas = Warta::latest()->get();
    	return view('admin.warta.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = WartaController::role_check();
    	return view('admin.warta.create',compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_warta'   => 'required|unique:tb_warta|max:255',
            ]);
        
    	$nama_warta = $req->nama_warta;
    	$file = $req->file('file');

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
        
        $slug = str_replace(' ', '-', $nama_warta);
        $slug = str_replace('/', '-', $slug);
        $slug = str_replace('?', '-', $slug);
    	$warta = new Warta();
    	$warta->nama_warta = $nama_warta;
        $warta->slug = $slug;
    	$warta->user_nama = $user;
        $warta->status = 0;
    	$warta->save();

        if(isset($file)){
            $warta = Warta::where('slug', $slug)->first();
            $id = $warta->id;
            $image_name = $file->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $file_name = $id.'.'.$extension;
            $file->storeAs('admin/warta/', $file_name, 'public');
            $file_url = 'admin/warta/'.$file_name;
            $warta->url = $file_url;
            $warta->save();    
        }
        
        return redirect(route('admin.warta.index'));
    }

    public function Show($slug)
    {
        $datas = Warta::where('slug', $slug)->get();
        $source = "show";
        return view('admin.warta.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $role_id = WartaController::role_check();
        $data = Warta::where('slug', $slug)->first();
        return view('admin.warta.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Warta::where('slug', $slug)->first();
        $validated = $req->validate([
                'nama_warta'   => 'required|max:255',
            ]);    
        
        $nama_warta_new = $req->nama_warta;
        $file = $req->file('file');

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
        
        if($datas->nama_warta != $nama_warta_new){
            $validated2 = $req->validate([
                'nama_warta' => 'unique:tb_warta'
            ]);
            $slug_new = str_replace(' ', '-', $nama_warta_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        }

        $datas->nama_warta = $nama_warta_new;
        $datas->slug = $slug_new;
        $datas->user_nama = $user;
        $datas->status = 0;

        if(isset($file)){
            $id = $datas->id;
            $image_name = $file->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $file_name = $id.'.'.$extension;
            $file->storeAs('admin/warta/', $file_name, 'public');
            $file_url = 'admin/warta/'.$file_name;
            $datas->url = $file_url;
            $datas->save();    
        }
        $datas->save();
        return redirect(route('admin.warta.index'));
    }

    public function Active($slug)
    {
        $warta = Warta::where('slug', $slug)->first();
        $warta->status = 1;
        $warta->save();
        return redirect(route('admin.warta.index'));
    }

    public function NonActive($slug)
    {
        $warta = Warta::where('slug', $slug)->first();
        $warta->status = 0;
        $warta->save();        
        return redirect(route('admin.warta.index'));
    }

    public function Delete($slug)
    {
        $warta = Warta::where('slug', $slug)->first();
        $image_path = $warta->file_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $warta->delete();
        return redirect(route('admin.warta.index'));
    }

}   
