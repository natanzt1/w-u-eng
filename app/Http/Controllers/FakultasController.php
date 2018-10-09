<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fakultas;
use App\GalleryFakultas;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class FakultasController extends Controller
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
        $role_id = FakultasController::role_check();
        $datas = Fakultas::latest()->get();
    	return view('admin.fakultas.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = FakultasController::role_check();
    	return view('admin.fakultas.create',compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_fakultas'   => 'required|unique:tb_fakultas|max:255'
            ]);
        
    	$nama_fakultas = $req->nama_fakultas;
        $slug = str_replace(' ', '-', $nama_fakultas);
        $slug = str_replace('?', '-', $slug);
    	$visi = $req->visi;
        $misi = $req->misi;
        $tujuan = $req->tujuan;
        $sasaran = $req->sasaran;
        $latar_belakang = $req->latar_belakang;
        $akreditasi = $req->akreditasi;
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
        
    	$fakultas = new Fakultas();
    	$fakultas->nama_fakultas = $nama_fakultas;
        $fakultas->slug = $slug;
    	$fakultas->visi = $visi;
        $fakultas->misi = $misi;
        $fakultas->tujuan = $tujuan;
        $fakultas->sasaran = $sasaran;
        $fakultas->latar_belakang = $latar_belakang;
        $fakultas->akreditasi = $akreditasi;
        $fakultas->info_lain = $info_lain;
    	$fakultas->status = 1;
        $fakultas->user_nama = $user;
    	$fakultas->save();
        
        if(isset($logo)){
            $fakultas = Fakultas::where('slug', $slug)->first();
            $id = $fakultas->id;
            $logo_name = $logo->getClientOriginalName();
            $extension = explode('.', $logo_name);
            $extension = end($extension);
            $logo_name = $id.'.'.$extension;
            $logo->storeAs('admin/fakultas/logo/', $logo_name, 'public');
            $logo = 'admin/fakultas/logo/'.$logo_name;
            $fakultas->logo_url = $logo;
            $fakultas->save();
        }

        if(isset($struktur)){
            $fakultas = Fakultas::where('slug', $slug)->first();
            $id = $fakultas->id;
            $struktur_name = $struktur->getClientOriginalName();
            $extension = explode('.', $struktur_name);
            $extension = end($extension);
            $struktur_name = $id.'.'.$extension;
            $struktur->storeAs('admin/fakultas/struktur/', $struktur_name, 'public');
            $struktur = 'admin/fakultas/struktur/'.$struktur_name;
            $fakultas->struktur = $struktur;
            $fakultas->save();
        }
        
    	return redirect(route('admin.fakultas.index'));
    }

    public function Show($slug)
    {
        $datas = Fakultas::where('slug', $slug)->get();
        $source = "show";
        return view('admin.fakultas.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $role_id = FakultasController::role_check();
        $data = Fakultas::where('slug', $slug)->first();
    	return view('admin.fakultas.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {   
        $datas = Fakultas::where('slug', $slug)->first();
        $nama_fakultas_new = $req->nama_fakultas;
        $visi_new = $req->visi;
        $misi_new = $req->misi;
        $tujuan_new = $req->tujuan;
        $sasaran_new = $req->sasaran;
        $latar_belakang_new = $req->latar_belakang;
        $akreditasi_new = $req->akreditasi;
        $info_lain_new = $req->info_lain;
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

        if($datas->nama_fakultas != $nama_fakultas_new){
            $validated2 = $req->validate([
                'nama_fakultas' => 'unique:tb_profil_fakultas'
            ]);
            $slug_new = str_replace(' ', '-', $nama_fakultas_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        }
             
        $datas->nama_fakultas = $nama_fakultas_new;
        $datas->slug = $slug_new;
        $datas->visi = $visi_new;
        $datas->misi = $misi_new;
        $datas->tujuan = $tujuan_new;
        $datas->sasaran = $sasaran_new;
        $datas->latar_belakang = $latar_belakang_new;
        $datas->akreditasi = $akreditasi_new;
        $datas->info_lain = $info_lain_new;
        $datas->user_nama = $user;
        $datas->status = 1;

        if(isset($logo_new)){
            $id = $datas->id;
            $logo_name = $logo_new->getClientOriginalName();
            $extension = explode('.', $logo_name);
            $extension = end($extension);
            $logo_name = $id.'.'.$extension;
            $logo_new->storeAs('admin/fakultas/logo/', $logo_name, 'public');
            $logo = 'admin/fakultas/logo/'.$logo_name;
            $datas->logo_url = $logo;
        }

        if(isset($struktur_new)){
            
            $id = $datas->id;
            $struktur_name = $struktur_new->getClientOriginalName();
            $extension = explode('.', $struktur_name);
            $extension = end($extension);
            $struktur_name = $id.'.'.$extension;
            $struktur_new->storeAs('admin/fakultas/struktur/', $struktur_name, 'public');
            $struktur = 'admin/fakultas/struktur/'.$struktur_name;
            $datas->struktur = $struktur;
        }

        $datas->save();
        return redirect(route('admin.fakultas.index'));
    }

    public function Active($slug)
    {
        $fakultas = Fakultas::where('slug', $slug)->first();
        $fakultas->status = 1;
        $fakultas->save();
        return redirect(route('admin.fakultas.index'));
    }

    public function NonActive($slug)
    {
        $fakultas = Fakultas::where('slug', $slug)->first();
        $fakultas->status = 0;
        $fakultas->save();        
        return redirect(route('admin.fakultas.index'));
    }

    public function Delete($id)
    {
        $fakultas = Fakultas::where('id', $id)->first();
        $image_path = $fakultas->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $fakultas->delete();
        return redirect(route('admin.fakultas.index'));
    }

    public function Gallery($slug)
    {
        $role_id = FakultasController::role_check();
        $fakultas = Fakultas::where('slug', $slug)->first();
        $id = $fakultas->id;
        $datas = GalleryFakultas::where('tb_fakultas_id', $id)->get();
        if(empty($datas[0])){
            $parameter = "null";
        }
        else{
            $parameter = "isset";
        }
        
        return view('admin.fakultas.detail', compact('fakultas','parameter','datas','slug','role_id'));
    }

    public function StoreGallery($slug, Request $req)
    {
        $fakultas = Fakultas::where('slug', $slug)->first();
        $fakultas_id = $fakultas->id;

        $validated = $req->validate([
                'thumbnail'   => 'required|image'
            ]);
        
        $galleries = GalleryFakultas::all();
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
        $thumbnail->storeAs('admin/fakultas/detail/', $thumbnail_name, 'public');
        $thumbnail_url = 'admin/fakultas/detail/'.$thumbnail_name;

        $check = GalleryFakultas::where('tb_fakultas_id', $fakultas_id)
                    ->where('status',1)
                    ->first();
        if(empty($check->id)){
            $status = 1;
        }
        else{
            $status = 0;
        }

        $gallery = new GalleryFakultas();
        $gallery->tb_fakultas_id = $fakultas_id;
        $gallery->thumbnail_url = $thumbnail_url;
        $gallery->user_id = Auth::user()->pegawai->pegawai_id;
        $gallery->status = $status;
        $gallery->save();

        return redirect(route('admin.fakultas.detail',[$slug]));
    }

    public function DeleteGallery($slug,$id)
    {
        $fakultas = GalleryFakultas::where('id', $id)->first();
        $image_path = $fakultas->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $fakultas->delete();
        return redirect(route('admin.fakultas.detail',[$slug]));
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
