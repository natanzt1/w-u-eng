<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\repository;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class repositoryController extends Controller
{
    public function Index()
    {
        $datas = repository::all();
    	return view('admin.repository.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.repository.create');
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

        $slug = str_replace(' ', '-', $nama_repository);
    	$repository = new repository();
    	$repository->nama_repository = $nama_repository;
        $repository->deskripsi_repository = $deskripsi_repository;
    	$repository->url = $url_repository;
        $repository->slug = $slug;
    	$repository->user_id = 1;
    	$repository->status = 0;
    	$repository->save();

        return redirect(route('admin.repository.index'));
    }

    public function Show($slug)
    {
        $datas = repository::where('slug', $slug)->get();
        $source = "show";
        return view('admin.repository.preview', compact('datas','slug','source'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = repository::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_repository'   => 'required|max:255',
                'url_repository' => 'required'
            ]);    
        
        $nama_repository_new = $req->nama_repository;
        $url_new = $req->url_repository;
        $create_slug = str_replace(' ', '-', $nama_repository_new);
        
        if($datas[0]->nama_repository != $nama_repository_new){
            $validated2 = $req->validate([
                'nama_repository' => 'unique:tb_repository'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = repository::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_repository = $nama_repository_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->url = $url_new;
        $datas[0]->save();
        return redirect(route('admin.repository.index'));
    }

    public function Active($slug)
    {
        $repository = repository::where('slug', $slug)->get();
        $repository[0]->status = 1;
        $repository[0]->save();
        return redirect(route('admin.repository.index'));
    }

    public function NonActive($slug)
    {
        $repository = repository::where('slug', $slug)->get();
        $repository[0]->status = 0;
        $repository[0]->save();        
        return redirect(route('admin.repository.index'));
    }

    public function Delete($slug)
    {
        $repository = repository::where('slug', $slug)->get();
        $image_path = $repository[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $repository[0]->delete();
        return redirect(route('admin.repository.index'));
    }

}   
