<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inkubator;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class InkubatorController extends Controller
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
        $role_id = InkubatorController::role_check();
        $datas = Inkubator::latest()->get();
    	return view('admin.inkubator.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = InkubatorController::role_check();
    	return view('admin.inkubator.create',compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_inkubator'   => 'required|unique:tb_inkubator|max:255',
            ]);
        
    	$nama_inkubator = $req->nama_inkubator;
    	$konten_inkubator = $req->konten_inkubator;
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
        
        $slug = str_replace(' ', '-', $nama_inkubator);
    	$inkubator = new Inkubator();
    	$inkubator->nama_inkubator = $nama_inkubator;
    	$inkubator->konten = $konten_inkubator;
        $inkubator->slug = $slug;
        $inkubator->user_nama = $user;
    	$inkubator->status = 0;
    	$inkubator->save();

        if(isset($thumbnail)){
            $inkubator = Inkubator::where('slug', $slug)->first();
            $id = $inkubator->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/inkubator/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/inkubator/'.$thumbnail_name;
            $inkubator->thumbnail_url = $thumbnail_url;
            $inkubator->save();
        }
        
    	return redirect(route('admin.inkubator.index'));
    }

    public function Show($slug)
    {
        $datas = Inkubator::where('slug', $slug)->get();
        $source = "show";
        return view('admin.inkubator.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $role_id = InkubatorController::role_check();
        $data = Inkubator::where('slug', $slug)->first();
    	return view('admin.inkubator.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Inkubator::where('slug', $slug)->first();
        $validated = $req->validate([
                'nama_inkubator'   => 'required|max:255',
            ]);    
        
        $nama_inkubator_new = $req->nama_inkubator;
        $konten_inkubator_new = $req->konten_inkubator;

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
        
        if($datas->nama_inkubator != $nama_inkubator_new){
            $validated2 = $req->validate([
                'nama_inkubator' => 'unique:tb_inkubator'
            ]);
            $slug_new = str_replace(' ', '-', $nama_inkubator_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        } 

        $datas->nama_inkubator = $nama_inkubator_new;
        $datas->slug = $slug_new;
        $datas->konten = $konten_inkubator_new;
        $datas->user_nama = $user;
        $datas->status = 0;
        if($req->file('thumbnail') != null ){
            $id = $datas->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/inkubator/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/inkubator/'.$thumbnail_name;
            $datas->thumbnail_url = $thumbnail_url;
        }
        $datas->save();
        return redirect(route('admin.inkubator.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_inkubator = $req->nama_inkubator;
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
                       
        $inkubator = Inkubator::where('slug', $slug_old)->get();
        $inkubator[0]->nama_inkubator = $nama_inkubator;
        $inkubator[0]->konten = $konten;
        $inkubator[0]->slug = $slug_new;
        $inkubator[0]->thumbnail_url = $thumbnail_url;
        $inkubator[0]->user_id = 1; //Pengedit inkubator
        $inkubator[0]->save();
        return redirect(route('admin.inkubator.index'));
    }

    public function Active($slug)
    {
        $inkubator = Inkubator::where('slug', $slug)->first();
        $inkubator->status = 1;
        $inkubator->save();
        return redirect(route('admin.inkubator.index'));
    }

    public function NonActive($slug)
    {
        $inkubator = Inkubator::where('slug', $slug)->first();
        $inkubator->status = 0;
        $inkubator->save();        
        return redirect(route('admin.inkubator.index'));
    }

    public function Delete($slug)
    {
        $inkubator = Inkubator::where('slug', $slug)->first();
        $image_path = $inkubator->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $inkubator->delete();
        return redirect(route('admin.inkubator.index'));
    }

    /*Cadangan
    public function inkubatorUpdate2($slug_old, Request $req)
    {    
        $inkubator_old = Inkubator::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_inkubator'   => 'required|max:255',
                'konten_inkubator' => 'required'
            ]);    
        
        $nama_inkubator_new = $req->nama_inkubator;
        $konten_inkubator_new = $req->konten_inkubator;
        $create_slug = str_replace(' ', '-', $nama_inkubator_new);
        
        foreach($inkubator_old as $inkubator){
            if($inkubator->nama_inkubator != $nama_inkubator_new){
                $validated2 = $req->validate([
                    'nama_inkubator' => 'unique:tb_inkubator'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = Inkubator::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        Inkubator::where('slug', $slug_old)
          ->update(['nama_inkubator' => $nama_inkubator_new , 'konten' => $konten_inkubator_new , 'slug' => $slug_new]);
    	return redirect(route('admin.inkubator.index'));
    }*/

}   
