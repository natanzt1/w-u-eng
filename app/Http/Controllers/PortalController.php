<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Portal;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class PortalController extends Controller
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
        $role_id = PortalController::role_check();
        $datas = Portal::latest()->get();
    	return view('admin.portal.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = PortalController::role_check();
    	return view('admin.portal.create', compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_portal'   => 'required|unique:tb_portal|max:255',
            ]);
        
    	$nama_portal = $req->nama_portal;
    	$url_portal = $req->url_portal;

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

        $slug = str_replace(' ', '-', $nama_portal);
        $slug = str_replace('/', '-', $slug);
        $slug = str_replace('?', '-', $slug);
    	$portal = new Portal();
    	$portal->nama_portal = $nama_portal;
    	$portal->url = $url_portal;
        $portal->slug = $slug;
    	$portal->user_nama = $user;
    	$portal->status = 0;
    	$portal->save();

        if(isset($thumbnail)){
            $portal = Portal::where('slug', $slug)->first();
            $id = $portal->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/portal/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/portal/'.$thumbnail_name;
            $portal->icon_url = $thumbnail_url;
            $portal->save();    
        }
        
        return redirect(route('admin.portal.index'));
    }

    public function Edit($slug)
    {
        $role_id = PortalController::role_check();
        $data = Portal::where('slug', $slug)->first();
        return view('admin.portal.edit', compact('data','role_id'));
    }

    public function show($slug)
    {
        $datas = Portal::where('slug', $slug)->get();
        $source = "show";
        return view('admin.portal.preview', compact('datas','slug','source'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Portal::where('slug', $slug)->first();
        $validated = $req->validate([
                'nama_portal'   => 'required|max:255',
            ]);    
        
        $nama_portal_new = $req->nama_portal;
        $url_new = $req->url_portal;
        
        if($datas->nama_portal != $nama_portal_new){
            $validated2 = $req->validate([
                'nama_portal' => 'unique:tb_portal'
            ]);
            $slug_new = str_replace(' ', '-', $nama_portal_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        }

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

        $datas->nama_portal = $nama_portal_new;
        $datas->slug = $slug_new;
        $datas->url = $url_new;
        $datas->status = 0;
        $datas->user_nama = $user;
        $datas->save();
        return redirect(route('admin.portal.index'));
    }

    public function Active($slug)
    {
        $portal = Portal::where('slug', $slug)->first();
        $portal->status = 1;
        $portal->save();
        return redirect(route('admin.portal.index'));
    }

    public function NonActive($slug)
    {
        $portal = Portal::where('slug', $slug)->first();
        $portal->status = 0;
        $portal->save();        
        return redirect(route('admin.portal.index'));
    }

    public function Delete($slug)
    {
        $portal = Portal::where('slug', $slug)->first();
        $image_path = $portal->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $portal->delete();
        return redirect(route('admin.portal.index'));
    }

}   
