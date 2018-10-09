<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\prodi;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class prodiController extends Controller
{
    public function Index()
    {
        $datas = prodi::all();
    	return view('admin.prodi.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.prodi.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_prodi'   => 'required|unique:tb_prodi|max:255'
            ]);
        
    	$nama_prodi = $req->nama_prodi;
    	$visi = $req->visi;
        $misi = $req->misi;
        $tujuan = $req->tujuan;
        $sasaran = $req->sasaran;
        $latar_belakang = $req->latar_belakang;
        $akreditasi = $req->akreditasi;
        $profile = $req->profile;
        $info_lain = $req->info_lain;
        $logo = $req->file('logo');
        $struktur = $req->file('struktur');
        $kurikulum = $req->file('kurikulum');
        
        $slug = str_replace(' ', '-', $nama_prodi);
    	$prodi = new prodi();
    	$prodi->nama_prodi = $nama_prodi;
    	$prodi->visi = $visi;
        $prodi->misi = $misi;
        $prodi->tujuan = $tujuan;
        $prodi->sasaran = $sasaran;
        $prodi->latar_belakang = $latar_belakang;
        $prodi->akreditasi = $akreditasi;
        $prodi->profile = $profile;
        $prodi->info_lain = $info_lain;
        $prodi->slug = $slug;
    	$prodi->status = 0;
    	$prodi->save();

        if(isset($logo)){
            $prodi = prodi::where('slug', $slug)->get();
            $id = $prodi[0]->id;
            $logo_name = $logo->getClientOriginalName();
            $extension = explode('.', $logo_name);
            $extension = end($extension);
            $logo_name = $id.'.'.$extension;
            $logo->storeAs('admin/prodi/logo/', $logo_name, 'public');
            $logo = 'admin/prodi/logo/'.$logo_name;
            $prodi[0]->logo_url = $logo;
            $prodi[0]->save();
        }

        if(isset($struktur)){
            $prodi = prodi::where('slug', $slug)->get();
            $id = $prodi[0]->id;
            $struktur_name = $struktur->getClientOriginalName();
            $extension = explode('.', $struktur_name);
            $extension = end($extension);
            $struktur_name = $id.'.'.$extension;
            $struktur->storeAs('admin/prodi/struktur/', $struktur_name, 'public');
            $struktur = 'admin/prodi/struktur/'.$struktur_name;
            $prodi[0]->struktur = $struktur;
            $prodi[0]->save();
        }

        if(isset($kurikulum)){
            $prodi = prodi::where('slug', $slug)->get();
            $id = $prodi[0]->id;
            $kurikulum_name = $kurikulum->getClientOriginalName();
            $extension = explode('.', $kurikulum_name);
            $extension = end($extension);
            $kurikulum_name = $id.'.'.$extension;
            $kurikulum->storeAs('admin/prodi/kurikulum/', $kurikulum_name, 'public');
            $kurikulum = 'admin/prodi/kurikulum/'.$kurikulum_name;
            $prodi[0]->kurikulum = $kurikulum;
            $prodi[0]->save();
        }
        
    	return redirect(route('admin.prodi.index'));
    }

    public function Show($slug)
    {
        $datas = prodi::where('slug', $slug)->get();
        $source = "show";
        return view('admin.prodi.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $data = prodi::where('slug', $slug)->get();
    	return view('admin.prodi.edit', compact('data','slug'));
    }

    public function Update($slug, Request $req)
    {   
        $datas = prodi::where('slug', $slug)->get();
        $nama_prodi_new = $req->nama_prodi;
        $visi_new = $req->visi;
        $misi_new = $req->misi;
        $tujuan_new = $req->tujuan;
        $sasaran_new = $req->sasaran;
        $latar_belakang_new = $req->latar_belakang;
        $akreditasi_new = $req->akreditasi;
        $profile_new = $req->profile;
        $info_lain_new = $req->info_lain;
        $logo_new = $req->file('logo');
        $struktur_new = $req->file('struktur');
        $kurikulum_new = $req->file('kurikulum');
        
        $create_slug = str_replace(' ', '-', $nama_prodi_new);      
        
        if($datas[0]->nama_prodi != $nama_prodi_new){
            $validated2 = $req->validate([
                'nama_prodi' => 'unique:tb_prodi'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = prodi::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   


        $datas[0]->nama_prodi = $nama_prodi_new;
        $datas[0]->visi = $visi_new;
        $datas[0]->misi = $misi_new;
        $datas[0]->tujuan = $tujuan_new;
        $datas[0]->sasaran = $sasaran_new;
        $datas[0]->latar_belakang = $latar_belakang_new;
        $datas[0]->akreditasi = $akreditasi_new;
        $datas[0]->profile = $profile_new;
        $datas[0]->info_lain = $info_lain_new;
        $datas[0]->slug = $slug_new;

        if(isset($logo_new)){
            
            $id = $datas[0]->id;
            $logo_name = $logo_new->getClientOriginalName();
            $extension = explode('.', $logo_name);
            $extension = end($extension);
            $logo_name = $id.'.'.$extension;
            $logo_new->storeAs('admin/prodi/logo/', $logo_name, 'public');
            $logo = 'admin/prodi/logo/'.$logo_name;
            $datas[0]->logo_url = $logo;
        }

        if(isset($struktur_new)){
            
            $id = $datas[0]->id;
            $struktur_name = $struktur_new->getClientOriginalName();
            $extension = explode('.', $struktur_name);
            $extension = end($extension);
            $struktur_name = $id.'.'.$extension;
            $struktur_new->storeAs('admin/prodi/struktur/', $struktur_name, 'public');
            $struktur = 'admin/prodi/struktur/'.$struktur_name;
            $datas[0]->struktur = $struktur;
        }
        

        if(isset($kurikulum_new)){
            $id = $datas[0]->id;
            $kurikulum_name = $kurikulum_new->getClientOriginalName();
            $extension = explode('.', $kurikulum_name);
            $extension = end($extension);
            $kurikulum_name = $id.'.'.$extension;
            $kurikulum_new->storeAs('admin/prodi/kurikulum/', $kurikulum_name, 'public');
            $kurikulum = 'admin/prodi/kurikulum/'.$kurikulum_name;
            $datas[0]->kurikulum = $kurikulum;            
        } 

        $datas[0]->save();
        return redirect(route('admin.prodi.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_prodi = $req->nama_prodi;
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
                       
        $prodi = prodi::where('slug', $slug_old)->get();
        $prodi[0]->nama_prodi = $nama_prodi;
        $prodi[0]->konten = $konten;
        $prodi[0]->slug = $slug_new;
        $prodi[0]->thumbnail_url = $thumbnail_url;
        $prodi[0]->user_id = 1; //Pengedit prodi
        $prodi[0]->save();
        return redirect(route('admin.prodi.index'));
    }

    public function Active($slug)
    {
        $prodi = prodi::where('slug', $slug)->get();
        $prodi[0]->status = 1;
        $prodi[0]->save();
        return redirect(route('admin.prodi.index'));
    }

    public function NonActive($slug)
    {
        $prodi = prodi::where('slug', $slug)->get();
        $prodi[0]->status = 0;
        $prodi[0]->save();        
        return redirect(route('admin.prodi.index'));
    }

    public function Delete($id)
    {
        $prodi = prodi::where('id', $id)->get();
        $image_path = $prodi[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $prodi[0]->delete();
        return redirect(route('admin.prodi.index'));
    }

    /*Cadangan
    public function prodiUpdate2($slug_old, Request $req)
    {    
        $prodi_old = prodi::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_prodi'   => 'required|max:255',
                'konten_prodi' => 'required'
            ]);    
        
        $nama_prodi_new = $req->nama_prodi;
        $konten_prodi_new = $req->konten_prodi;
        $create_slug = str_replace(' ', '-', $nama_prodi_new);
        
        foreach($prodi_old as $prodi){
            if($prodi->nama_prodi != $nama_prodi_new){
                $validated2 = $req->validate([
                    'nama_prodi' => 'unique:tb_prodi'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = prodi::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        prodi::where('slug', $slug_old)
          ->update(['nama_prodi' => $nama_prodi_new , 'konten' => $konten_prodi_new , 'slug' => $slug_new]);
    	return redirect(route('admin.prodi.index'));
    }*/

}   
