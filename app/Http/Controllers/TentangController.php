<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tentang;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class TentangController extends Controller
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
        $datas = Tentang::latest()->get();
        $role_id = TentangController::role_check();
    	return view('admin.tentang.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = TentangController::role_check();
    	return view('admin.tentang.create',compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_tentang'   => 'required|unique:tb_tentang|max:255',
            ]);
        
    	$nama_tentang = $req->nama_tentang;
    	$konten_tentang = $req->konten_tentang;
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
        
        $slug = str_replace(' ', '-', $nama_tentang);
    	$tentang = new Tentang();
    	$tentang->nama_tentang = $nama_tentang;
    	$tentang->konten = $konten_tentang;
        $tentang->user_nama = $user;
        $tentang->status = 0;
        $tentang->slug = $slug;
    	$tentang->save();

        if(isset($thumbnail)){
            $tentang = Tentang::where('slug', $slug)->first();
            $id = $tentang->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/tentang/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/tentang/'.$thumbnail_name;
            $tentang->thumbnail_url = $thumbnail_url;
            $tentang->save();
        }
        
    	return redirect(route('admin.tentang.index'));
    }

    public function Show($slug)
    {
        $datas = Tentang::where('slug', $slug)->get();
        $source = "show";
        return view('admin.tentang.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $role_id = TentangController::role_check();
        $data = Tentang::where('slug', $slug)->first();
    	return view('admin.tentang.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Tentang::where('slug', $slug)->first();
        $validated = $req->validate([
                'nama_tentang'   => 'required|max:255',
            ]);    
        
        $nama_tentang_new = $req->nama_tentang;
        $konten_tentang_new = $req->konten_tentang;

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
        
        if($datas->nama_tentang != $nama_tentang_new){
            $validated2 = $req->validate([
                'nama_tentang' => 'unique:tb_tentang'
            ]);
            $slug_new = str_replace(' ', '-', $nama_tentang_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        }

        $datas->nama_tentang = $nama_tentang_new;
        $datas->slug = $slug_new;
        $datas->konten = $konten_tentang_new;
        $datas->user_nama = $user;
        $datas->status = 0;
        if($req->file('thumbnail') != null ){
            $id = $datas->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/tentang/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/tentang/'.$thumbnail_name;
            $datas->thumbnail_url = $thumbnail_url;
        }
        $datas->save();
        return redirect(route('admin.tentang.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_tentang = $req->nama_tentang;
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
                       
        $tentang = Tentang::where('slug', $slug_old)->get();
        $tentang[0]->nama_tentang = $nama_tentang;
        $tentang[0]->konten = $konten;
        $tentang[0]->slug = $slug_new;
        $tentang[0]->thumbnail_url = $thumbnail_url;
        $tentang[0]->user_id = 1; //Pengedit tentang
        $tentang[0]->save();
        return redirect(route('admin.tentang.index'));
    }

    public function Active($slug)
    {
        $tentang = Tentang::where('slug', $slug)->first();
        $tentang->status = 1;
        $tentang->save();
        return redirect(route('admin.tentang.index'));
    }

    public function NonActive($slug)
    {
        $tentang = Tentang::where('slug', $slug)->first();
        $tentang->status = 0;
        $tentang->save();        
        return redirect(route('admin.tentang.index'));
    }

    public function Delete($id)
    {
        $tentang = Tentang::where('id', $id)->first();
        $image_path = $tentang->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $tentang->delete();
        return redirect(route('admin.tentang.index'));
    }

    /*Cadangan
    public function tentangUpdate2($slug_old, Request $req)
    {    
        $tentang_old = Tentang::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_tentang'   => 'required|max:255',
                'konten_tentang' => 'required'
            ]);    
        
        $nama_tentang_new = $req->nama_tentang;
        $konten_tentang_new = $req->konten_tentang;
        $create_slug = str_replace(' ', '-', $nama_tentang_new);
        
        foreach($tentang_old as $tentang){
            if($tentang->nama_tentang != $nama_tentang_new){
                $validated2 = $req->validate([
                    'nama_tentang' => 'unique:tb_tentang'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = Tentang::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        Tentang::where('slug', $slug_old)
          ->update(['nama_tentang' => $nama_tentang_new , 'konten' => $konten_tentang_new , 'slug' => $slug_new]);
    	return redirect(route('admin.tentang.index'));
    }*/

}   
