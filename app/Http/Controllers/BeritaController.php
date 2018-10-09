<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Berita;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Date\Date;
use App\Http\Traits\FakultasTrait;


class BeritaController extends Controller
{
    Public function role_check()
    {
        $id = Auth::user()->identifier;
        $role = session()->get('role');
        $role_id = $role[0]->brokerrole_id;
        return $role_id;
    }

    use FakultasTrait;
    public function Index()
    {
        $role_id = BeritaController::role_check();
        $datas = Berita::orderBy('tgl_rilis', 'desc')->get();
        // return $datas;
    	return view('admin.berita.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = BeritaController::role_check();
    	return view('admin.berita.create', compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_berita'   => 'required|unique:tb_berita|max:255',                
            ]);
        
    	$nama_berita = $req->nama_berita;
    	$konten_berita = $req->konten_berita;
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

        $slug = str_replace(' ', '-', $nama_berita);
        $slug = str_replace('/', '-', $slug);
        $slug = str_replace('?', '-', $slug);
    	$berita = new Berita();
    	$berita->nama_berita = $nama_berita;
        $berita->tgl_rilis = $rilis;
    	$berita->konten = $konten_berita;
        $berita->slug = $slug;
    	$berita->user_nama = $user;
    	$berita->status = 0; //otomatis save as draft saat berita masih di preview
    	$berita->save();

        if(isset($thumbnail)){
            $berita = Berita::where('slug', $slug)->first();
            $id = $berita->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/berita/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/berita/'.$thumbnail_name;
            $berita->thumbnail_url = $thumbnail_url;
            $berita->save();   
        }
        
    	return redirect(route('admin.berita.index'));
    }

    public function Show($slug)
    {
        $all_fakultas = $this->fakultasAll();
        $datas = Berita::where('slug', $slug)->get();
        $source = "show";
        return view('admin.berita.preview', compact('datas','slug','source','all_fakultas'));
    }

    public function Edit($slug)
    {
        $role_id = BeritaController::role_check();
        $data = Berita::where('slug', $slug)->first();
    	return view('admin.berita.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Berita::where('slug', $slug)->first();
        $validated = $req->validate([
                'nama_berita'   => 'required|max:255',
            ]);    
        
        $nama_berita_new = $req->nama_berita;
        $konten_berita_new = $req->konten_berita;
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
        $create_slug = str_replace(' ', '-', $nama_berita_new);
        
        if($datas->nama_berita != $nama_berita_new){
            $validated2 = $req->validate([
                'nama_berita' => 'unique:tb_berita'
            ]);
            $slug_new = str_replace(' ', '-', $nama_berita_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        }
       
        $datas->nama_berita = $nama_berita_new;
        $datas->slug = $slug_new;
        $datas->tgl_rilis = $rilis_new;
        $datas->konten = $konten_berita_new;
        $datas->user_nama = $user;
        $datas->status = 0;
        if($req->file('thumbnail') != null ){
            $id = $datas->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/berita/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/berita/'.$thumbnail_name;
            $datas->thumbnail_url = $thumbnail_url;
        }
        $datas->save();
        return redirect(route('admin.berita.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_berita = $req->nama_berita;
        $tgl_rilis = $req->tgl_rilis;
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
        
        $berita = Berita::where('slug', $slug_old)->get();
        $berita[0]->nama_berita = $nama_berita;
        $berita[0]->konten = $konten;
        $berita[0]->slug = $slug_new;
        $berita[0]->thumbnail_url = $thumbnail_url;
        $berita[0]->tgl_rilis = $tgl_rilis;
        $berita[0]->user_id = 1; //Pengedit Berita
        $berita[0]->save();
        return redirect(route('admin.berita.index'));
    }

    public function Active($slug)
    {
        $berita = Berita::where('slug', $slug)->first();
        $berita->status = 1;
        $berita->save();
        return redirect(route('admin.berita.index'));
    }

    public function NonActive($slug)
    {
        $berita = Berita::where('slug', $slug)->first();
        $berita->status = 0;
        $berita->save();        
        return redirect(route('admin.berita.index'));
    }

    public function Thumbnail($slug)
    {
        $berita = Berita::where('slug', $slug)->first();
        $berita->status = 2;
        $berita->save();
        return redirect(route('admin.berita.index', $slug));
    }

    public function NonThumbnail($slug)
    {
        $berita = Berita::where('slug', $slug)->first();
        $berita->status = 1;
        $berita->save();
        return redirect(route('admin.berita.index', $slug));
    }

    public function Delete($slug)
    {
        $berita = Berita::where('slug', $slug)->first();
        $image_path = $berita->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $berita->delete();
        return redirect(route('admin.berita.index'));
    }
    /*Cadangan
    public function beritaUpdate2($slug_old, Request $req)
    {    
        $berita_old = Berita::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_berita'   => 'required|max:255',
                'konten_berita' => 'required'
            ]);    
        
        $nama_berita_new = $req->nama_berita;
        $konten_berita_new = $req->konten_berita;
        $create_slug = str_replace(' ', '-', $nama_berita_new);
        
        foreach($berita_old as $berita){
            if($berita->nama_berita != $nama_berita_new){
                $validated2 = $req->validate([
                    'nama_berita' => 'unique:tb_berita'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = Berita::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        Berita::where('slug', $slug_old)
          ->update(['nama_berita' => $nama_berita_new , 'konten' => $konten_berita_new , 'slug' => $slug_new]);
    	return redirect(route('admin.berita.index'));
    }*/

}   
