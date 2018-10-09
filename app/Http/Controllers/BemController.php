<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bem;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class BemController extends Controller
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
        $role_id = BemController::role_check();
        $datas = Bem::latest()->get();
        return view('admin.bem.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = BemController::role_check();
        return view('admin.bem.create', compact('role_id'));
    }

    public function Store(Request $req)
    {
        $validated = $req->validate([
                'nama_bem'   => 'required|unique:tb_bem|max:255'
            ]);
        
        $nama_bem = $req->nama_bem;
        $visi = $req->visi;
        $misi = $req->misi;
        $tujuan = $req->tujuan;
        
        $profile = $req->profile;
        $info_lain = $req->info_lain;
        $logo = $req->file('logo');
        $struktur = $req->file('struktur');

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
        
        $slug = str_replace(' ', '-', $nama_bem);
        $slug = str_replace('/', '-', $slug);
        $slug = str_replace('?', '-', $slug);
        $bem = new Bem();
        $bem->nama_bem = $nama_bem;
        $bem->visi = $visi;
        $bem->misi = $misi;
        $bem->tujuan = $tujuan;
        $bem->slug = $slug;
        $bem->status = 0;
        $bem->user_nama = $user;
        $bem->save();

        if(isset($logo)){
            $bem = Bem::where('slug', $slug)->first();
            $id = $bem->id;
            $logo_name = $logo->getClientOriginalName();
            $extension = explode('.', $logo_name);
            $extension = end($extension);
            $logo_name = $id.'.'.$extension;
            $logo->storeAs('admin/bem/logo/', $logo_name, 'public');
            $logo = 'admin/bem/logo/'.$logo_name;
            $bem->logo_url = $logo;
            $bem->save();
        }

        if(isset($struktur)){
            $bem = Bem::where('slug', $slug)->first();
            $id = $bem->id;
            $struktur_name = $struktur->getClientOriginalName();
            $extension = explode('.', $struktur_name);
            $extension = end($extension);
            $struktur_name = $id.'.'.$extension;
            $struktur->storeAs('admin/bem/struktur/', $struktur_name, 'public');
            $struktur = 'admin/bem/struktur/'.$struktur_name;
            $bem->struktur = $struktur;
            $bem->save();
        }
        
        return redirect(route('admin.bem.index'));
    }

    public function Show($slug)
    {
        $datas = Bem::where('slug', $slug)->get();
        $source = "show";
        return view('admin.bem.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $role_id = BemController::role_check();
        $data = Bem::where('slug', $slug)->first();
        return view('admin.bem.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {   
        $datas = Bem::where('slug', $slug)->first();
        $nama_bem_new = $req->nama_bem;
        $visi_new = $req->visi;
        $misi_new = $req->misi;
        $tujuan_new = $req->tujuan;
        $logo_new = $req->file('logo');
        $struktur_new = $req->file('struktur');
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
        
        $create_slug = str_replace(' ', '-', $nama_bem_new);      
        
        if($datas->nama_bem != $nama_bem_new){
            $validated2 = $req->validate([
                'nama_bem' => 'unique:tb_bem'
            ]);
            $slug_new = str_replace(' ', '-', $nama_bem_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        }
        
        $datas->nama_bem = $nama_bem_new;
        $datas->visi = $visi_new;
        $datas->misi = $misi_new;
        $datas->tujuan = $tujuan_new;
        $datas->user_nama = $user;
        $datas->slug = $slug_new;

        if(isset($logo_new)){
            
            $id = $datas->id;
            $logo_name = $logo_new->getClientOriginalName();
            $extension = explode('.', $logo_name);
            $extension = end($extension);
            $logo_name = $id.'.'.$extension;
            $logo_new->storeAs('admin/bem/logo/', $logo_name, 'public');
            $logo = 'admin/bem/logo/'.$logo_name;
            $datas->logo_url = $logo;
        }

        if(isset($struktur_new)){
            
            $id = $datas->id;
            $struktur_name = $struktur_new->getClientOriginalName();
            $extension = explode('.', $struktur_name);
            $extension = end($extension);
            $struktur_name = $id.'.'.$extension;
            $struktur_new->storeAs('admin/bem/struktur/', $struktur_name, 'public');
            $struktur = 'admin/bem/struktur/'.$struktur_name;
            $datas->struktur = $struktur;
        }

        $datas->save();
        return redirect(route('admin.bem.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_bem = $req->nama_bem;
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
                       
        $bem = Bem::where('slug', $slug_old)->get();
        $bem[0]->nama_bem = $nama_bem;
        $bem[0]->konten = $konten;
        $bem[0]->slug = $slug_new;
        $bem[0]->thumbnail_url = $thumbnail_url;
        $bem[0]->user_id = 1; //Pengedit bem
        $bem[0]->save();
        return redirect(route('admin.bem.index'));
    }

    public function Active($slug)
    {
        $bem = Bem::where('slug', $slug)->first();
        $bem->status = 1;
        $bem->save();
        return redirect(route('admin.bem.index'));
    }

    public function NonActive($slug)
    {
        $bem = Bem::where('slug', $slug)->first();
        $bem->status = 0;
        $bem->save();        
        return redirect(route('admin.bem.index'));
    }

    public function Delete($id)
    {
        $bem = Bem::where('id', $id)->first();
        $image_path = $bem->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $bem->delete();
        return redirect(route('admin.bem.index'));
    }

    /*Cadangan
    public function bemUpdate2($slug_old, Request $req)
    {    
        $bem_old = Bem::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_bem'   => 'required|max:255',
                'konten_bem' => 'required'
            ]);    
        
        $nama_bem_new = $req->nama_bem;
        $konten_bem_new = $req->konten_bem;
        $create_slug = str_replace(' ', '-', $nama_bem_new);
        
        foreach($bem_old as $bem){
            if($bem->nama_bem != $nama_bem_new){
                $validated2 = $req->validate([
                    'nama_bem' => 'unique:tb_bem'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = Bem::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        Bem::where('slug', $slug_old)
          ->update(['nama_bem' => $nama_bem_new , 'konten' => $konten_bem_new , 'slug' => $slug_new]);
        return redirect(route('admin.bem.index'));
    }*/

}   
