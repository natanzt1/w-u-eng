<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kalender;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class KalenderController extends Controller
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
        $role_id = KalenderController::role_check();
        $datas = Kalender::latest()->get();
    	return view('admin.kalender.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = KalenderController::role_check();
    	return view('admin.kalender.create',compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'tahun_ajaran'   => 'required|unique:tb_kalender|max:255',
                'kalender' => 'required'
            ]);
        
    	$tahun_ajaran = $req->tahun_ajaran;
        
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
        
    	$kalender = new Kalender();
    	$kalender->tahun_ajaran = $tahun_ajaran;
        $kalender->user_nama = $user;
    	$kalender->status = 1;
    	$kalender->save();
        $kalender = $req->file('kalender');
        if(isset($kalender)){
            $data = Kalender::where('tahun_ajaran', $tahun_ajaran)->first();
            $id = $data->id;
            $kalender_name = $kalender->getClientOriginalName();
            $extension = explode('.', $kalender_name);
            $extension = end($extension);
            $kalender_name = $id.'.'.$extension;
            $kalender->storeAs('admin/kalender/', $kalender_name, 'public');
            $url = 'admin/kalender/'.$kalender_name;
            $data->url = $url;
            $data->save();
        }
        
    	return redirect(route('admin.kalender.index'));
    }

    public function Show($tahun_ajaran)
    {
        $datas = Kalender::where('tahun_ajaran', $tahun_ajaran)->get();
        $source = "show";
        return view('admin.kalender.preview', compact('datas','tahun_ajaran','source'));
    }

    public function Edit($tahun_ajaran)
    {
        $role_id = KalenderController::role_check();
        $data = Kalender::where('tahun_ajaran', $tahun_ajaran)->first();
    	return view('admin.kalender.edit', compact('data','tahun_ajaran','role_id'));
    }

    public function Update($tahun_ajaran, Request $req)
    {    
        $datas = Kalender::where('tahun_ajaran', $tahun_ajaran)->first();
        $validated = $req->validate([
                'tahun_ajaran'   => 'required|max:255',
            ]);    
        
        $tahun_ajaran_new = $req->tahun_ajaran;

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
        
        if($datas->tahun_ajaran != $tahun_ajaran_new){
            $validated2 = $req->validate([
                'tahun_ajaran' => 'unique:tb_kalender'
            ]);
            $datas->tahun_ajaran = $tahun_ajaran_new;  
        }     
        
        if($req->file('kalender') != null ){
            $id = $datas->id;
            $kalender = $req->file('kalender');
            $image_name = $kalender->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $kalender_name = 'temp'.$id.'.'.$extension;
            $kalender->storeAs('admin/kalender/', $kalender_name, 'public');
            $url = 'admin/kalender/'.$kalender_name;
            $datas->url = $url;
        }
        $datas->user_nama = $user;
        $datas->save();
        return redirect(route('admin.kalender.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $tahun_ajaran_old = $req->old_tahun_ajaran;
        $tahun_ajaran_new = $req->new_tahun_ajaran;
        $nama_kalender = $req->nama_kalender;
        $konten = $req->konten;
        $kalender_temp = $req->url;
        if (strpos($kalender_temp, 'temp') == true) {
            $url = explode('temp', $kalender_temp);
            $url = $url[0].$url[1];
            $rename_file = public_path($url);
            $file = public_path($kalender_temp);
            rename($file,$url); 
        }
        else{
            $url = $kalender_temp;
        }
                       
        $kalender = Kalender::where('tahun_ajaran', $tahun_ajaran_old)->get();
        $kalender[0]->nama_kalender = $nama_kalender;
        $kalender[0]->konten = $konten;
        $kalender[0]->tahun_ajaran = $tahun_ajaran_new;
        $kalender[0]->url = $url;
        $kalender[0]->user_id = 1; //Pengedit kalender
        $kalender[0]->save();
        return redirect(route('admin.kalender.index'));
    }

    public function Active($tahun_ajaran)
    {
        $kalender = Kalender::where('tahun_ajaran', $tahun_ajaran)->first();
        $kalender->status = 1;
        $kalender->save();
        return redirect(route('admin.kalender.index'));
    }

    public function NonActive($tahun_ajaran)
    {
        $kalender = Kalender::where('tahun_ajaran', $tahun_ajaran)->first();
        $kalender->status = 0;
        $kalender->save();        
        return redirect(route('admin.kalender.index'));
    }

    public function Delete($tahun_ajaran)
    {
        $kalender = Kalender::where('tahun_ajaran', $tahun_ajaran)->first();
        $image_path = $kalender->url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $kalender->delete();
        return redirect(route('admin.kalender.index'));
    }

    /*Cadangan
    public function kalenderUpdate2($tahun_ajaran_old, Request $req)
    {    
        $kalender_old = Kalender::where('tahun_ajaran', $tahun_ajaran_old)->get();
        $validated = $req->validate([
                'nama_kalender'   => 'required|max:255',
                'konten_kalender' => 'required'
            ]);    
        
        $nama_kalender_new = $req->nama_kalender;
        $konten_kalender_new = $req->konten_kalender;
        $create_tahun_ajaran = str_replace(' ', '-', $nama_kalender_new);
        
        foreach($kalender_old as $kalender){
            if($kalender->nama_kalender != $nama_kalender_new){
                $validated2 = $req->validate([
                    'nama_kalender' => 'unique:tb_kalender'
                ]);
            }
        }
        do {
            $tahun_ajaran_new = $create_tahun_ajaran."-".rand(0,10000);
            $tahun_ajaran_check = Kalender::where('tahun_ajaran', $tahun_ajaran_new)->get();
        } while (isset($tahun_ajaran_check[0]));    
        Kalender::where('tahun_ajaran', $tahun_ajaran_old)
          ->update(['nama_kalender' => $nama_kalender_new , 'konten' => $konten_kalender_new , 'tahun_ajaran' => $tahun_ajaran_new]);
    	return redirect(route('admin.kalender.index'));
    }*/

}   
