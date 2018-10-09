<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\fakultas;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class fakultasController extends Controller
{
    public function Index()
    {
        $datas = fakultas::all();
    	return view('admin.fakultas.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.fakultas.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_fakultas'   => 'required|unique:tb_fakultas|max:255'
            ]);
        
    	$nama_fakultas = $req->nama_fakultas;
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
        
        $slug = str_replace(' ', '-', $nama_fakultas);
    	$fakultas = new fakultas();
    	$fakultas->nama_fakultas = $nama_fakultas;
    	$fakultas->visi = $visi;
        $fakultas->misi = $misi;
        $fakultas->tujuan = $tujuan;
        $fakultas->sasaran = $sasaran;
        $fakultas->latar_belakang = $latar_belakang;
        $fakultas->akreditasi = $akreditasi;
        $fakultas->profile = $profile;
        $fakultas->info_lain = $info_lain;
        $fakultas->slug = $slug;
    	$fakultas->status = 0;
    	$fakultas->save();

        if(isset($logo)){
            $fakultas = fakultas::where('slug', $slug)->get();
            $id = $fakultas[0]->id;
            $logo_name = $logo->getClientOriginalName();
            $extension = explode('.', $logo_name);
            $extension = end($extension);
            $logo_name = $id.'.'.$extension;
            $logo->storeAs('admin/fakultas/logo/', $logo_name, 'public');
            $logo = 'admin/fakultas/logo/'.$logo_name;
            $fakultas[0]->logo_url = $logo;
            $fakultas[0]->save();
        }

        if(isset($struktur)){
            $fakultas = fakultas::where('slug', $slug)->get();
            $id = $fakultas[0]->id;
            $struktur_name = $struktur->getClientOriginalName();
            $extension = explode('.', $struktur_name);
            $extension = end($extension);
            $struktur_name = $id.'.'.$extension;
            $struktur->storeAs('admin/fakultas/struktur/', $struktur_name, 'public');
            $struktur = 'admin/fakultas/struktur/'.$struktur_name;
            $fakultas[0]->struktur = $struktur;
            $fakultas[0]->save();
        }

        if(isset($kurikulum)){
            $fakultas = fakultas::where('slug', $slug)->get();
            $id = $fakultas[0]->id;
            $kurikulum_name = $kurikulum->getClientOriginalName();
            $extension = explode('.', $kurikulum_name);
            $extension = end($extension);
            $kurikulum_name = $id.'.'.$extension;
            $kurikulum->storeAs('admin/fakultas/kurikulum/', $kurikulum_name, 'public');
            $kurikulum = 'admin/fakultas/kurikulum/'.$kurikulum_name;
            $fakultas[0]->kurikulum = $kurikulum;
            $fakultas[0]->save();
        }
        
    	return redirect(route('admin.fakultas.index'));
    }

    public function Show($slug)
    {
        $datas = fakultas::where('slug', $slug)->get();
        $source = "show";
        return view('admin.fakultas.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $data = fakultas::where('slug', $slug)->get();
    	return view('admin.fakultas.edit', compact('data','slug'));
    }

    public function Update($slug, Request $req)
    {   
        $datas = fakultas::where('slug', $slug)->get();
        $nama_fakultas_new = $req->nama_fakultas;
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
        
        $create_slug = str_replace(' ', '-', $nama_fakultas_new);      
        
        if($datas[0]->nama_fakultas != $nama_fakultas_new){
            $validated2 = $req->validate([
                'nama_fakultas' => 'unique:tb_fakultas'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = fakultas::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   


        $datas[0]->nama_fakultas = $nama_fakultas_new;
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
            $logo_new->storeAs('admin/fakultas/logo/', $logo_name, 'public');
            $logo = 'admin/fakultas/logo/'.$logo_name;
            $datas[0]->logo_url = $logo;
        }

        if(isset($struktur_new)){
            
            $id = $datas[0]->id;
            $struktur_name = $struktur_new->getClientOriginalName();
            $extension = explode('.', $struktur_name);
            $extension = end($extension);
            $struktur_name = $id.'.'.$extension;
            $struktur_new->storeAs('admin/fakultas/struktur/', $struktur_name, 'public');
            $struktur = 'admin/fakultas/struktur/'.$struktur_name;
            $datas[0]->struktur = $struktur;
        }
        

        if(isset($kurikulum_new)){
            $id = $datas[0]->id;
            $kurikulum_name = $kurikulum_new->getClientOriginalName();
            $extension = explode('.', $kurikulum_name);
            $extension = end($extension);
            $kurikulum_name = $id.'.'.$extension;
            $kurikulum_new->storeAs('admin/fakultas/kurikulum/', $kurikulum_name, 'public');
            $kurikulum = 'admin/fakultas/kurikulum/'.$kurikulum_name;
            $datas[0]->kurikulum = $kurikulum;            
        } 

        $datas[0]->save();
        return redirect(route('admin.fakultas.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_fakultas = $req->nama_fakultas;
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
                       
        $fakultas = fakultas::where('slug', $slug_old)->get();
        $fakultas[0]->nama_fakultas = $nama_fakultas;
        $fakultas[0]->konten = $konten;
        $fakultas[0]->slug = $slug_new;
        $fakultas[0]->thumbnail_url = $thumbnail_url;
        $fakultas[0]->user_id = 1; //Pengedit fakultas
        $fakultas[0]->save();
        return redirect(route('admin.fakultas.index'));
    }

    public function Active($slug)
    {
        $fakultas = fakultas::where('slug', $slug)->get();
        $fakultas[0]->status = 1;
        $fakultas[0]->save();
        return redirect(route('admin.fakultas.index'));
    }

    public function NonActive($slug)
    {
        $fakultas = fakultas::where('slug', $slug)->get();
        $fakultas[0]->status = 0;
        $fakultas[0]->save();        
        return redirect(route('admin.fakultas.index'));
    }

    public function Delete($id)
    {
        $fakultas = fakultas::where('id', $id)->get();
        $image_path = $fakultas[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $fakultas[0]->delete();
        return redirect(route('admin.fakultas.index'));
    }

    /*Cadangan
    public function fakultasUpdate2($slug_old, Request $req)
    {    
        $fakultas_old = fakultas::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_fakultas'   => 'required|max:255',
                'konten_fakultas' => 'required'
            ]);    
        
        $nama_fakultas_new = $req->nama_fakultas;
        $konten_fakultas_new = $req->konten_fakultas;
        $create_slug = str_replace(' ', '-', $nama_fakultas_new);
        
        foreach($fakultas_old as $fakultas){
            if($fakultas->nama_fakultas != $nama_fakultas_new){
                $validated2 = $req->validate([
                    'nama_fakultas' => 'unique:tb_fakultas'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = fakultas::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        fakultas::where('slug', $slug_old)
          ->update(['nama_fakultas' => $nama_fakultas_new , 'konten' => $konten_fakultas_new , 'slug' => $slug_new]);
    	return redirect(route('admin.fakultas.index'));
    }*/

}   
