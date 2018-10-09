<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengumuman;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\FakultasTrait;

class PengumumanController extends Controller
{
    use FakultasTrait;
    Public function role_check()
    {
        $id = Auth::user()->identifier;
        $role = session()->get('role');
        $role_id = $role[0]->brokerrole_id;
        return $role_id;
    }

    public function Index()
    {
        $role_id = PengumumanController::role_check();
        $datas = Pengumuman::orderBy('tgl_rilis', 'desc')->get();
    	return view('admin.pengumuman.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = PengumumanController::role_check();
    	return view('admin.pengumuman.create',compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_pengumuman'   => 'required|unique:tb_pengumuman|max:255',
                
            ]);
        
    	$nama_pengumuman = $req->nama_pengumuman;
    	$konten_pengumuman = $req->konten_pengumuman;
        $kontak = $req->kontak;
        $website = $req->website;
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

        $slug = str_replace(' ', '-', $nama_pengumuman);
    	$pengumuman = new Pengumuman();
    	$pengumuman->nama_pengumuman = $nama_pengumuman;
    	$pengumuman->konten = $konten_pengumuman;
        $pengumuman->slug = $slug;
        $pengumuman->tgl_rilis = $rilis;
        $pengumuman->kontak = $kontak;
        $pengumuman->website = $website;
    	$pengumuman->user_nama = $user;
    	$pengumuman->status = 0; 
    	$pengumuman->save();

        if(isset($thumbnail)){
            $pengumuman = Pengumuman::where('slug', $slug)->first();
            $id = $pengumuman->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/pengumuman/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/pengumuman/'.$thumbnail_name;
            $pengumuman->thumbnail_url = $thumbnail_url;
            $pengumuman->save();
        }
        
    	return redirect(route('admin.pengumuman.index'));
    }

    public function Show($slug)
    {
        $datas = Pengumuman::where('slug', $slug)->get();
        $source = "show";
        return view('admin.pengumuman.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $role_id = PengumumanController::role_check();
        $data = Pengumuman::where('slug', $slug)->first();
    	return view('admin.pengumuman.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Pengumuman::where('slug', $slug)->first();
        $validated = $req->validate([
                'nama_pengumuman'   => 'required|max:255',
            ]);    
        
        $nama_pengumuman_new = $req->nama_pengumuman;
        $konten_pengumuman_new = $req->konten_pengumuman;
        $kontak_new = $req->kontak;
        $website_new = $req->website;
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
        
        if($datas->nama_pengumuman != $nama_pengumuman_new){
            $validated2 = $req->validate([
                'nama_pengumuman' => 'unique:tb_pengumuman'
            ]);
            $slug_new = str_replace(' ', '-', $nama_pengumuman_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        } 

        $datas->nama_pengumuman = $nama_pengumuman_new;
        $datas->kontak = $kontak_new;
        $datas->website = $website_new;
        $datas->slug = $slug_new;
        $datas->user_nama = $user;
        $datas->status = 0;
        $datas->konten = $konten_pengumuman_new;
        $datas->tgl_rilis = $rilis_new;
        if($req->file('thumbnail') != null ){
            $id = $datas->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/pengumuman/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/pengumuman/'.$thumbnail_name;
            $datas->thumbnail_url = $thumbnail_url;
        }
        $datas->save();
        return redirect(route('admin.pengumuman.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_pengumuman = $req->nama_pengumuman;
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
                       
        $pengumuman = Pengumuman::where('slug', $slug_old)->get();
        $pengumuman[0]->nama_pengumuman = $nama_pengumuman;
        $pengumuman[0]->konten = $konten;
        $pengumuman[0]->slug = $slug_new;
        $pengumuman[0]->thumbnail_url = $thumbnail_url;
        $pengumuman[0]->user_id = 1; //Pengedit pengumuman
        $pengumuman[0]->save();
        return redirect(route('admin.pengumuman.index'));
    }

    public function Active($slug)
    {
        $pengumuman = Pengumuman::where('slug', $slug)->first();
        $pengumuman->status = 1;
        $pengumuman->save();
        return redirect(route('admin.pengumuman.index'));
    }

    public function NonActive($slug)
    {
        $pengumuman = Pengumuman::where('slug', $slug)->first();
        $pengumuman->status = 0;
        $pengumuman->save();        
        return redirect(route('admin.pengumuman.index'));
    }

    public function Delete($slug)
    {

        $pengumuman = Pengumuman::where('slug', $slug)->first();
        $image_path = $pengumuman->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }        
        $pengumuman->delete();
        
        return redirect(route('admin.pengumuman.index'));
    }

    /*Cadangan
    public function pengumumanUpdate2($slug_old, Request $req)
    {    
        $pengumuman_old = Pengumuman::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_pengumuman'   => 'required|max:255',
                'konten_pengumuman' => 'required'
            ]);    
        
        $nama_pengumuman_new = $req->nama_pengumuman;
        $konten_pengumuman_new = $req->konten_pengumuman;
        $create_slug = str_replace(' ', '-', $nama_pengumuman_new);
        
        foreach($pengumuman_old as $pengumuman){
            if($pengumuman->nama_pengumuman != $nama_pengumuman_new){
                $validated2 = $req->validate([
                    'nama_pengumuman' => 'unique:tb_pengumuman'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = Pengumuman::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        Pengumuman::where('slug', $slug_old)
          ->update(['nama_pengumuman' => $nama_pengumuman_new , 'konten' => $konten_pengumuman_new , 'slug' => $slug_new]);
    	return redirect(route('admin.pengumuman.index'));
    }*/

}   
