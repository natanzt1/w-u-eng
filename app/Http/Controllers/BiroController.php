<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Biro;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class BiroController extends Controller
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
        $role_id = BiroController::role_check();
        $datas = Biro::latest()->get();
    	return view('admin.biro.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = BiroController::role_check();
    	return view('admin.biro.create', compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_biro'   => 'required|unique:tb_biro|max:255',
                
            ]);
        
    	$nama_biro = $req->nama_biro;
        $slug = str_replace(' ', '-', $nama_biro);
        $slug = str_replace('?', '-', $slug);
    	$konten_biro = $req->konten_biro;
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

    	$biro = new Biro();
    	$biro->nama_biro = $nama_biro;
        $biro->slug = $slug;
    	$biro->deskripsi = $konten_biro;
    	$biro->user_nama = $user;
    	$biro->status = 0; //otomatis save as draft saat biro masih di preview
    	$biro->save();

    	return redirect(route('admin.biro.index'));
    }

    public function Show($slug)
    {
        $datas = Biro::where('slug', $slug)->get();
        $source = "show";
        return view('admin.biro.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $role_id = BiroController::role_check();
        $data = Biro::where('slug', $slug)->first();
    	return view('admin.biro.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Biro::where('slug', $slug)->first();
        $validated = $req->validate([
                'nama_biro'   => 'required|max:255',
            ]);    
        
        $nama_biro_new = $req->nama_biro;
        $konten_biro_new = $req->konten_biro;

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
        
        if($datas->nama_biro != $nama_biro_new){
            $validated2 = $req->validate([
                'nama_biro' => 'unique:tb_biro'
            ]);
            $slug_new = str_replace(' ', '-', $nama_biro_new);
            $slug_new = str_replace('/', '-', $slug);
            $slug_new = str_replace('?', '-', $slug);
        }
        else{
            $slug_new = $slug;
        }
        
        $datas->nama_biro = $nama_biro_new;
        $datas->status = 0;
        $datas->user_nama = $user;
        $datas->deskripsi = $konten_biro_new;
        $datas->save();
        return redirect(route('admin.biro.index'));
    }

    public function Active($slug)
    {
        $biro = Biro::where('slug', $slug)->first();
        $biro->status = 1;
        $biro->save();
        return redirect(route('admin.biro.index'));
    }

    public function NonActive($slug)
    {
        $biro = Biro::where('slug', $slug)->first();
        $biro->status = 0;
        $biro->save();        
        return redirect(route('admin.biro.index'));
    }

    public function Delete($slug)
    {
        $biro = Biro::where('slug', $slug)->first();
        $image_path = $biro->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $biro->delete();
        return redirect(route('admin.biro.index'));
    }

    /*Cadangan
    public function biroUpdate2($slug_old, Request $req)
    {    
        $biro_old = Biro::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_biro'   => 'required|max:255',
                'konten_biro' => 'required'
            ]);    
        
        $nama_biro_new = $req->nama_biro;
        $konten_biro_new = $req->konten_biro;
        $create_slug = str_replace(' ', '-', $nama_biro_new);
        
        foreach($biro_old as $biro){
            if($biro->nama_biro != $nama_biro_new){
                $validated2 = $req->validate([
                    'nama_biro' => 'unique:tb_biro'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = Biro::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        Biro::where('slug', $slug_old)
          ->update(['nama_biro' => $nama_biro_new , 'konten' => $konten_biro_new , 'slug' => $slug_new]);
    	return redirect(route('admin.biro.index'));
    }*/

}   
