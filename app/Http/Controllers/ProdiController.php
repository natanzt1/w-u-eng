<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prodi;
use App\Fakultas;
use App\GalleryProdi;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ProdiController extends Controller
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
        $datas = Prodi::latest()->get();
        $role_id = ProdiController::role_check();
    	return view('admin.prodi.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = ProdiController::role_check();
        $fakultases = Fakultas::where('status', '1')->get();
    	return view('admin.prodi.create', compact('fakultases','role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_prodi'   => 'required|unique:tb_prodi|max:255'
            ]);
        
    	$nama_prodi = $req->nama_prodi;
        $slug = str_replace(' ', '-', $nama_prodi);
        $slug = str_replace('?', '-', $slug);
    	$visi = $req->visi;
        $misi = $req->misi;
        $tujuan = $req->tujuan;
        $sasaran = $req->sasaran;
        $latar_belakang = $req->latar_belakang;
        $akreditasi = $req->akreditasi;
        $profile = $req->profile;
        $fakultas = $req->fakultas;
        $tingkat = $req->tingkat;
        $info_lain = $req->info_lain;
        $dosen = $req->dosen;
        $logo = $req->file('logo');
        $struktur = $req->file('struktur');
        $kurikulum = $req->file('kurikulum');

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
        
    	$prodi = new Prodi();
    	$prodi->nama_prodi = $nama_prodi;
    	$prodi->visi = $visi;
        $prodi->misi = $misi;
        $prodi->tujuan = $tujuan;
        $prodi->sasaran = $sasaran;
        $prodi->latar_belakang = $latar_belakang;
        $prodi->akreditasi = $akreditasi;
        $prodi->info_lain = $info_lain;
        $prodi->dosen_pengajar = $dosen;
        $prodi->slug = $slug;
        $prodi->tingkat = $tingkat;
        $prodi->fakultas_id = $fakultas;
        $prodi->user_nama = $user;
    	$prodi->status = 1;
    	$prodi->save();

        if(isset($logo)){
            $prodi = Prodi::where('slug', $slug)->first();
            $id = $prodi->id;
            $logo_name = $logo->getClientOriginalName();
            $extension = explode('.', $logo_name);
            $extension = end($extension);
            $logo_name = $id.'.'.$extension;
            $logo->storeAs('admin/prodi/logo/', $logo_name, 'public');
            $logo = 'admin/prodi/logo/'.$logo_name;
            $prodi->logo_url = $logo;
            $prodi->save();
        }

        if(isset($struktur)){
            $prodi = Prodi::where('slug', $slug)->first();
            $id = $prodi->id;
            $struktur_name = $struktur->getClientOriginalName();
            $extension = explode('.', $struktur_name);
            $extension = end($extension);
            $struktur_name = $id.'.'.$extension;
            $struktur->storeAs('admin/prodi/struktur/', $struktur_name, 'public');
            $struktur = 'admin/prodi/struktur/'.$struktur_name;
            $prodi->struktur = $struktur;
            $prodi->save();
        }

        if(isset($kurikulum)){
            $prodi = Prodi::where('slug', $slug)->first();
            $id = $prodi->id;
            $kurikulum_name = $kurikulum->getClientOriginalName();
            $extension = explode('.', $kurikulum_name);
            $extension = end($extension);
            $kurikulum_name = $id.'.'.$extension;
            $kurikulum->storeAs('admin/prodi/kurikulum/', $kurikulum_name, 'public');
            $kurikulum = 'admin/prodi/kurikulum/'.$kurikulum_name;
            $prodi->kurikulum = $kurikulum;
            $prodi->save();
        }
        
    	return redirect(route('admin.prodi.index'));
    }

    public function Show($slug)
    {
        $datas = Prodi::where('slug', $slug)->get();
        $source = "show";
        return view('admin.prodi.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $role_id = ProdiController::role_check();
        $data = Prodi::where('slug', $slug)->first();
        $fakultases = Fakultas::where('status', '1')->get();
    	return view('admin.prodi.edit', compact('data','slug','fakultases','role_id'));
    }

    public function Update($slug, Request $req)
    {   
        $datas = Prodi::where('slug', $slug)->first();
        $nama_prodi_new = $req->nama_prodi;
        $visi_new = $req->visi;
        $misi_new = $req->misi;
        $tujuan_new = $req->tujuan;
        $tingkat_new = $req->tingkat;
        $sasaran_new = $req->sasaran;
        $latar_belakang_new = $req->latar_belakang;
        $akreditasi_new = $req->akreditasi;
        $profile_new = $req->profile;
        $dosen_new = $req->dosen;
        $info_lain_new = $req->info_lain;
        $fakultas_new = $req->fakultas;
        $logo_new = $req->file('logo');
        $struktur_new = $req->file('struktur');
        $kurikulum_new = $req->file('kurikulum');

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
                
        if($datas->nama_prodi != $nama_prodi_new){
            $validated2 = $req->validate([
                'nama_prodi' => 'unique:tb_prodi'
            ]);
        }

        $datas->nama_prodi = $nama_prodi_new;
        $datas->visi = $visi_new;
        $datas->misi = $misi_new;
        $datas->tujuan = $tujuan_new;
        $datas->sasaran = $sasaran_new;
        $datas->latar_belakang = $latar_belakang_new;
        $datas->akreditasi = $akreditasi_new;
        $datas->info_lain = $info_lain_new;
        $datas->dosen_pengajar = $dosen_new;
        $datas->fakultas_id = $fakultas_new;
        $datas->tingkat = $tingkat_new;
        $datas->user_nama = $user;
        $datas->status = 1;

        if(isset($logo_new)){
            
            $id = $datas->id;
            $logo_name = $logo_new->getClientOriginalName();
            $extension = explode('.', $logo_name);
            $extension = end($extension);
            $logo_name = $id.'.'.$extension;
            $logo_new->storeAs('admin/prodi/logo/', $logo_name, 'public');
            $logo = 'admin/prodi/logo/'.$logo_name;
            $datas->logo_url = $logo;
        }

        if(isset($struktur_new)){
            
            $id = $datas->id;
            $struktur_name = $struktur_new->getClientOriginalName();
            $extension = explode('.', $struktur_name);
            $extension = end($extension);
            $struktur_name = $id.'.'.$extension;
            $struktur_new->storeAs('admin/prodi/struktur/', $struktur_name, 'public');
            $struktur = 'admin/prodi/struktur/'.$struktur_name;
            $datas->struktur = $struktur;
        }
        

        if(isset($kurikulum_new)){
            $id = $datas->id;
            $kurikulum_name = $kurikulum_new->getClientOriginalName();
            $extension = explode('.', $kurikulum_name);
            $extension = end($extension);
            $kurikulum_name = $id.'.'.$extension;
            $kurikulum_new->storeAs('admin/prodi/kurikulum/', $kurikulum_name, 'public');
            $kurikulum = 'admin/prodi/kurikulum/'.$kurikulum_name;
            $datas->kurikulum = $kurikulum;            
        } 

        $datas->save();
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
                       
        $prodi = Prodi::where('slug', $slug_old)->get();
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
        $prodi = Prodi::where('slug', $slug)->first();
        $prodi->status = 1;
        $prodi->save();
        return redirect(route('admin.prodi.index'));
    }

    public function NonActive($slug)
    {
        $prodi = Prodi::where('slug', $slug)->first();
        $prodi->status = 0;
        $prodi->save();        
        return redirect(route('admin.prodi.index'));
    }

    public function Delete($id)
    {
        $prodi = Prodi::where('id', $id)->first();
        $image_path = $prodi->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $prodi->delete();
        return redirect(route('admin.prodi.index'));
    }

    public function Gallery($slug)
    {
        $role_id = ProdiController::role_check();

        $prodi = Prodi::where('slug', $slug)->first();
        $id = $prodi->id;
        $datas = GalleryProdi::where('tb_prodi_id', $id)->get();
        if(empty($datas[0])){
            $parameter = "null";
        }
        else{
            $parameter = "isset";
        }
        
        return view('admin.prodi.detail', compact('prodi','parameter','datas','slug','role_id'));
    }

    public function StoreGallery($slug, Request $req)
    {
        $prodi = Prodi::where('slug', $slug)->first();
        $prodi_id = $prodi->id;

        $validated = $req->validate([
                'thumbnail'   => 'required|image'
            ]);
        
        $galleries = GalleryProdi::all();
        foreach($galleries as $gallery){
            $id = $gallery->id;
        }
        if(empty($id)){
            $id = 1;
        }
        
        $thumbnail = $req->file('thumbnail');

        $image_name = $thumbnail->getClientOriginalName();
        $extension = explode('.', $image_name);
        $extension = end($extension);
        $thumbnail_name = $id.'.'.$extension;
        $thumbnail->storeAs('admin/prodi/detail/', $thumbnail_name, 'public');
        $thumbnail_url = 'admin/prodi/detail/'.$thumbnail_name;

        $check = GalleryProdi::where('tb_prodi_id', $prodi_id)
                    ->where('status',1)
                    ->first();
        if(empty($check->id)){
            $status = 1;
        }
        else{
            $status = 0;
        }

        $gallery = new Galleryprodi();
        $gallery->tb_prodi_id = $prodi_id;
        $gallery->thumbnail_url = $thumbnail_url;
        $gallery->user_id = Auth::user()->pegawai->pegawai_id;
        $gallery->status = $status;
        $gallery->save();

        return redirect(route('admin.prodi.detail',[$slug]));
    }

    public function DeleteGallery($slug,$id)
    {
        $prodi = GalleryProdi::where('id', $id)->first();
        $image_path = $prodi->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $prodi->delete();
        return redirect(route('admin.prodi.detail',[$slug]));
    }   

}   
