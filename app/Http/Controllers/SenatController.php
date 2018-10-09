<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Senat;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class SenatController extends Controller
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
        $role_id = SenatController::role_check();
        $datas = Senat::latest()->get();
    	return view('admin.senat.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = SenatController::role_check();
    	return view('admin.senat.create',compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_senat'   => 'required|unique:tb_senat|max:255',
                
            ]);
        
    	$nama_senat = $req->nama_senat;
    	$konten_senat = $req->konten_senat;
        $logo = $req->file('logo');

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
        
        $slug = str_replace(' ', '-', $nama_senat);
    	$senat = new Senat();
    	$senat->nama_senat = $nama_senat;
    	$senat->konten = $konten_senat;
        $senat->slug = $slug;
        $senat->user_nama = $user;
    	$senat->status = 0;
    	$senat->save();

        if(isset($logo)){
            $senat = Senat::where('slug', $slug)->first();
            $id = $senat->id;
            $image_name = $logo->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $logo_name = $id.'.'.$extension;
            $logo->storeAs('admin/senat/', $logo_name, 'public');
            $logo_url = 'admin/senat/'.$logo_name;
            $senat->logo_url = $logo_url;
            $senat->save();
        }
        
    	return redirect(route('admin.senat.index'));
    }

    public function Show($slug)
    {
        $datas = Senat::where('slug', $slug)->get();
        $source = "show";
        return view('admin.senat.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $role_id = SenatController::role_check();
        $data = Senat::where('slug', $slug)->first();
    	return view('admin.senat.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Senat::where('slug', $slug)->first();
        $validated = $req->validate([
                'nama_senat'   => 'required|max:255',
            ]);    
        
        $nama_senat_new = $req->nama_senat;
        $konten_senat_new = $req->konten_senat;
        
        if($datas->nama_senat != $nama_senat_new){
            $validated2 = $req->validate([
                'nama_senat' => 'unique:tb_senat'
            ]);
            $slug_new = str_replace(' ', '-', $nama_senat_new);
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

        $datas->nama_senat = $nama_senat_new;
        $datas->slug = $slug_new;
        $datas->konten = $konten_senat_new;
        $datas->user_nama = $user;
        $datas->status = 0;
        if($req->file('logo') != null ){
            $id = $datas->id;
            $logo = $req->file('logo');
            $image_name = $logo->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $logo_name = 'temp'.$id.'.'.$extension;
            $logo->storeAs('admin/senat/', $logo_name, 'public');
            $logo_url = 'admin/senat/'.$logo_name;
            $datas->logo_url = $logo_url;
        }
        $datas->save();
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
                       
        $senat = Senat::where('slug', $slug_old)->get();
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
        $senat = Senat::where('slug', $slug)->first();
        $senat->status = 1;
        $senat->save();
        return redirect(route('admin.senat.index'));
    }

    public function NonActive($slug)
    {
        $senat = Senat::where('slug', $slug)->first();
        $senat->status = 0;
        $senat->save();        
        return redirect(route('admin.senat.index'));
    }

    public function Delete($slug)
    {
        $senat = Senat::where('slug', $slug)->first();
        $image_path = $senat->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $senat->delete();
        return redirect(route('admin.senat.index'));
    }

    /*Cadangan
    public function senatUpdate2($slug_old, Request $req)
    {    
        $senat_old = Senat::where('slug', $slug_old)->get();
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
            $slug_check = Senat::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        Senat::where('slug', $slug_old)
          ->update(['nama_senat' => $nama_senat_new , 'konten' => $konten_senat_new , 'slug' => $slug_new]);
    	return redirect(route('admin.senat.index'));
    }*/

}   
