<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class RepositoryController extends Controller
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
        $role_id = RepositoryController::role_check();
        $datas = Repository::latest()->get();
    	return view('admin.repository.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = RepositoryController::role_check();
    	return view('admin.repository.create',compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_repository'   => 'required|unique:tb_repository|max:255',
                'url_repository' => 'required'
            ]);
        
    	$nama_repository = $req->nama_repository;
        $deskripsi_repository = $req->deskripsi_repository;
    	$url_repository = $req->url_repository;

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

        $slug = str_replace(' ', '-', $nama_repository);
    	$repository = new Repository();
    	$repository->nama_repository = $nama_repository;
        $repository->deskripsi_repository = $deskripsi_repository;
    	$repository->url = $url_repository;
        $repository->slug = $slug;
    	$repository->user_nama = $user;
    	$repository->status = 0;
    	$repository->save();

        return redirect(route('admin.repository.index'));
    }

    public function Show($slug)
    {
        $datas = Repository::where('slug', $slug)->get();
        $source = "show";
        return view('admin.repository.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $role_id = RepositoryController::role_check();
        $data = Repository::where('slug', $slug)->first();
        return view('admin.repository.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Repository::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_repository'   => 'required|max:255',
                'url_repository' => 'required'
            ]);    
        
        $nama_repository_new = $req->nama_repository;
        $url_new = $req->url_repository;

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
        
        if($datas->nama_repository != $nama_repository_new){
            $validated2 = $req->validate([
                'nama_repository' => 'unique:tb_repository'
            ]);
            $slug_new = str_replace(' ', '-', $nama_repository_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        }

        $datas->nama_repository = $nama_repository_new;
        $datas->slug = $slug_new;
        $datas->url = $url_new;
        $datas->user_nama = $user;
        $datas->save();
        return redirect(route('admin.repository.index'));
    }

    public function Active($slug)
    {
        $repository = Repository::where('slug', $slug)->first();
        $repository->status = 1;
        $repository->save();
        return redirect(route('admin.repository.index'));
    }

    public function NonActive($slug)
    {
        $repository = Repository::where('slug', $slug)->first();
        $repository->status = 0;
        $repository->save();        
        return redirect(route('admin.repository.index'));
    }

    public function Delete($slug)
    {
        $repository = Repository::where('slug', $slug)->first();
        $image_path = $repository->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $repository->delete();
        return redirect(route('admin.repository.index'));
    }

}   
