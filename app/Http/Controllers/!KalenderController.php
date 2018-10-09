<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\kalender;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class kalenderController extends Controller
{
    public function Index()
    {
        $datas = kalender::all();
    	return view('admin.kalender.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.kalender.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'tahun_ajaran'   => 'required|unique:tb_kalender|max:255'
            ]);
        
    	$nama_kalender = $req->nama_kalender;
    	$tahun_ajaran = $req->tahun_ajaran;

        $slug = str_replace(' ', '-', $nama_kalender);
    	$kalender = new kalender();
    	$kalender->tahun_ajaran = $tahun_ajaran;
    	$kalender->user_id = 1;
    	$kalender->status = 0;
    	$kalender->save();

        $kalender = $req->file('kalender');

        $data = kalender::where('slug', $slug)->get();
        $id = $data[0]->id;

        $kalender_name = $kalender->getClientOriginalName();
        $extension = explode('.', $kalender_name);
        $extension = end($extension);
        $kalender_name = $id.'.'.$extension;
        $kalender->storeAs('admin/kalender/', $kalender_name, 'public');
        $kalender_url = 'admin/kalender/'.$kalender_name;
        $data[0]->url = $kalender_url;
        $data[0]->save();
        
        return redirect(route('admin.kalender.index'));
    }

    public function Show($slug)
    {
        $datas = kalender::where('slug', $slug)->get();
        $source = "show";
        return view('admin.kalender.preview', compact('datas','slug','source'));
    }

    public function Update($tahun_ajaran, Request $req)
    {    
        return "a";
        $datas = kalender::where('tahun_ajaran', $tahun_ajaran)->get();
        $validated = $req->validate([
                'nama_kalender'   => 'required|max:255',
                'url_kalender' => 'required'
            ]);    
        
        if($datas[0]->nama_kalender != $nama_kalender_new){
            $validated2 = $req->validate([
                'nama_kalender' => 'unique:tb_kalender'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = kalender::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_kalender = $nama_kalender_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->url = $url_new;
        $datas[0]->save();
        return redirect(route('admin.kalender.index'));
    }

    public function Active($slug)
    {
        $kalender = kalender::where('slug', $slug)->get();
        $kalender[0]->status = 1;
        $kalender[0]->save();
        return redirect(route('admin.kalender.index'));
    }

    public function NonActive($slug)
    {
        $kalender = kalender::where('slug', $slug)->get();
        $kalender[0]->status = 0;
        $kalender[0]->save();        
        return redirect(route('admin.kalender.index'));
    }

}   
