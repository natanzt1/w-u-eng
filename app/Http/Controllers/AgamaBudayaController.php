<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AgamaBudaya;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class AgamaBudayaController extends Controller
{
    public function role_check()
    {
        $id = Auth::user()->identifier;
        $role = session()->get('role');
        $role_id = $role[0]->brokerrole_id;
        return $role_id;
    }

    public function Index()
    {
        $role_id = AgamaBudayaController::role_check();
        $datas = AgamaBudaya::latest()->get();
    	return view('admin.agamabudaya.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = AgamaBudayaController::role_check();
    	return view('admin.agamabudaya.create', compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_agamabudaya'   => 'required|unique:tb_agamabudaya|max:255',
                
            ]);
        
    	$nama_agamabudaya = $req->nama_agamabudaya;
        $nama_agamabudaya_en = $req->nama_agamabudaya_en;
    	$konten_agamabudaya = $req->konten_agamabudaya;
        $konten_agamabudaya_en = $req->konten_agamabudaya_en;
        $thumbnail = $req->file('thumbnail');
        $tgl = $req->tanggal;
        $waktu = $req->waktu;

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

        $rilis = $tgl.' '.$waktu. ':00';

        $slug = str_replace(' ', '-', $nama_agamabudaya);
        $slug = str_replace('/', '-', $slug);
        $slug = str_replace('?', '-', $slug);

    	$agamabudaya = new AgamaBudaya();
    	$agamabudaya->nama_agamabudaya = $nama_agamabudaya;
    	$agamabudaya->konten = $konten_agamabudaya;
        $agamabudaya->en_nama_agamabudaya = $nama_agamabudaya_en;
        $agamabudaya->en_konten = $konten_agamabudaya_en;
        $agamabudaya->slug = $slug;
        $agamabudaya->tgl_rilis = $rilis;
    	$agamabudaya->user_nama = $user;
    	$agamabudaya->status = 0; //otomatis save as draft saat agamabudaya masih di preview
    	$agamabudaya->save();

        if(isset($thumbnail)){
            $agamabudaya = AgamaBudaya::where('slug', $slug)->first();
            $id = $agamabudaya[0]->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/agamabudaya/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/agamabudaya/'.$thumbnail_name;
            $agamabudaya->thumbnail_url = $thumbnail_url;
            $agamabudaya->save();
        }
    	return redirect(route('admin.agamabudaya.index'));
    }

    public function Show($slug)
    {
        $datas = AgamaBudaya::where('slug', $slug)->get();
        $source = "show";
        return view('admin.agamabudaya.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $role_id = AgamaBudayaController::role_check();
        $data = AgamaBudaya::where('slug', $slug)->first();
    	return view('admin.agamabudaya.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = AgamaBudaya::where('slug', $slug)->first();
        $validated = $req->validate([
                'nama_agamabudaya'   => 'required|max:255',
            ]);    
        
        $nama_agamabudaya_new = $req->nama_agamabudaya;
        $nama_agamabudaya_en_new = $req->nama_agamabudaya_en;
        $konten_agamabudaya_new = $req->konten_agamabudaya;
        $konten_agamabudaya_en_new = $req->konten_agamabudaya_en;
        $tgl = $req->tanggal;
        $waktu = $req->waktu;
        
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

        $rilis_new = $tgl.' '.$waktu. ':00';
        
        if($datas->nama_agamabudaya != $nama_agamabudaya_new){
            $validated2 = $req->validate([
                'nama_agamabudaya' => 'unique:tb_agamabudaya'
            ]);
            $slug_new = str_replace(' ', '-', $nama_agamabudaya_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        }
        
        $datas->nama_agamabudaya = $nama_agamabudaya_new;
        $datas->en_nama_agamabudaya = $nama_agamabudaya_en_new;
        $datas->slug = $slug_new;
        $datas->tgl_rilis = $rilis_new;
        $datas->status = 0;
        $datas->user_nama = $user;

        $datas->konten = $konten_agamabudaya_new;
        $datas->en_konten = $konten_agamabudaya_en_new;
        if($req->file('thumbnail') != null ){
            $id = $datas->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/agamabudaya/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/agamabudaya/'.$thumbnail_name;
            $datas->thumbnail_url = $thumbnail_url;
        }
        $datas->save();
        return redirect(route('admin.agamabudaya.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_agamabudaya = $req->nama_agamabudaya;
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
                       
        $agamabudaya = AgamaBudaya::where('slug', $slug_old)->first();
        $agamabudaya->nama_agamabudaya = $nama_agamabudaya;
        $agamabudaya->konten = $konten;
        $agamabudaya->slug = $slug_new;
        $agamabudaya->thumbnail_url = $thumbnail_url;
        $agamabudaya->user_id = 1; //Pengedit agamabudaya
        $agamabudaya->save();
        return redirect(route('admin.agamabudaya.index'));
    }

    public function Active($slug)
    {
        $agamabudaya = AgamaBudaya::where('slug', $slug)->first();
        $agamabudaya->status = 1;
        $agamabudaya->save();
        return redirect(route('admin.agamabudaya.index'));
    }

    public function NonActive($slug)
    {
        $agamabudaya = AgamaBudaya::where('slug', $slug)->first();
        $agamabudaya->status = 0;
        $agamabudaya->save();        
        return redirect(route('admin.agamabudaya.index'));
    }

    public function ActiveEN($slug)
    {
        $agamabudaya = AgamaBudaya::where('slug', $slug)->first();
        $agamabudaya->en_status = 1;
        $agamabudaya->save();
        return redirect(route('admin.agamabudaya.index'));
    }

    public function NonActiveEN($slug)
    {
        $agamabudaya = AgamaBudaya::where('slug', $slug)->first();
        $agamabudaya->en_status = 0;
        $agamabudaya->save();        
        return redirect(route('admin.agamabudaya.index'));
    }

    public function Delete($slug)
    {
        $agama = AgamaBudaya::where('slug', $slug)->get();
        $image_path = $agama[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $agama[0]->delete();
        return redirect(route('admin.agamabudaya.index'));
    }

    /*Cadangan
    public function agamabudayaUpdate2($slug_old, Request $req)
    {    
        $agamabudaya_old = agamabudaya::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_agamabudaya'   => 'required|max:255',
                'konten_agamabudaya' => 'required'
            ]);    
        
        $nama_agamabudaya_new = $req->nama_agamabudaya;
        $konten_agamabudaya_new = $req->konten_agamabudaya;
        $create_slug = str_replace(' ', '-', $nama_agamabudaya_new);
        
        foreach($agamabudaya_old as $agamabudaya){
            if($agamabudaya->nama_agamabudaya != $nama_agamabudaya_new){
                $validated2 = $req->validate([
                    'nama_agamabudaya' => 'unique:tb_agamabudaya'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = agamabudaya::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        agamabudaya::where('slug', $slug_old)
          ->update(['nama_agamabudaya' => $nama_agamabudaya_new , 'konten' => $konten_agamabudaya_new , 'slug' => $slug_new]);
    	return redirect(route('admin.agamabudaya.index'));
    }*/

}   
