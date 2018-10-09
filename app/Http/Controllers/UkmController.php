<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ukm;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class UkmController extends Controller
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
        $datas = Ukm::latest()->get();
        $role_id = UkmController::role_check();
    	return view('admin.ukm.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = UkmController::role_check();
    	return view('admin.ukm.create',compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_ukm'   => 'required|unique:tb_ukm|max:255',
                
            ]);
        
    	$nama_ukm = $req->nama_ukm;
    	$konten_ukm = $req->konten_ukm;
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
        
        $slug = str_replace(' ', '-', $nama_ukm);
    	$ukm = new Ukm();
    	$ukm->nama_ukm = $nama_ukm;
    	$ukm->konten = $konten_ukm;
        $ukm->slug = $slug;
    	$ukm->user_nama = $user;
        $ukm->status = 0;
    	$ukm->save();

        if(isset($thumbnail)){
            $ukm = Ukm::where('slug', $slug)->first();
            $id = $ukm->id;
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
        $datas = Ukm::where('slug', $slug)->get();
        $source = "show";
        return view('admin.ukm.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $role_id = UkmController::role_check();
        $data = Ukm::where('slug', $slug)->first();
    	return view('admin.ukm.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Ukm::where('slug', $slug)->first();
        $validated = $req->validate([
                'nama_ukm'   => 'required|max:255',
            ]);    
        
        $nama_ukm_new = $req->nama_ukm;
        $konten_ukm_new = $req->konten_ukm;
        $create_slug = str_replace(' ', '-', $nama_ukm_new);

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
        
        if($datas->nama_ukm != $nama_ukm_new){
            $validated2 = $req->validate([
                'nama_ukm' => 'unique:tb_ukm'
            ]);
            $slug_new = str_replace(' ', '-', $nama_ukm_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        }  

        $datas->nama_ukm = $nama_ukm_new;
        $datas->slug = $slug_new;
        $datas->konten = $konten_ukm_new;
        $datas->user_nama = $user;
        $datas->status = 0;
        if($req->file('thumbnail') != null ){
            $id = $datas->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/ukm/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/ukm/'.$thumbnail_name;
            $datas->thumbnail_url = $thumbnail_url;
        }
        $datas->save();
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
                       
        $ukm = Ukm::where('slug', $slug_old)->get();
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
        $ukm = Ukm::where('slug', $slug)->first();
        $ukm->status = 1;
        $ukm->save();
        return redirect(route('admin.ukm.index'));
    }

    public function NonActive($slug)
    {
        $ukm = Ukm::where('slug', $slug)->first();
        $ukm->status = 0;
        $ukm->save();        
        return redirect(route('admin.ukm.index'));
    }

    public function Delete($slug)
    {
        $ukm = Ukm::where('slug', $slug)->first();
        $image_path = $ukm->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $ukm->delete();
        return redirect(route('admin.ukm.index'));
    }

    /*Cadangan
    public function ukmUpdate2($slug_old, Request $req)
    {    
        $ukm_old = Ukm::where('slug', $slug_old)->get();
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
            $slug_check = Ukm::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        Ukm::where('slug', $slug_old)
          ->update(['nama_ukm' => $nama_ukm_new , 'konten' => $konten_ukm_new , 'slug' => $slug_new]);
    	return redirect(route('admin.ukm.index'));
    }*/

}   
