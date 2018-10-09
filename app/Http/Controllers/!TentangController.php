<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tentang;
use App\detailtentang;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class tentangController extends Controller
{
    public function Index()
    {
        $datas = tentang::all(); /*Status 1 = Thumbnail*/
    	return view('admin.tentang.index', compact('datas'));
    }

    public function Detail($slug)
    {
        $tentang = tentang::where('slug', $slug)->get(); /*Status 1 = Thumbnail*/
        $id = $tentang[0]->id;
        $datas = detailtentang::where('tb_tentang_id', $id)->get();
        if(empty($datas[0])){
            $parameter = "null";
        }
        else{
            $parameter = "isset";
        }
        
        return view('admin.tentang.detail', compact('datas','parameter','tentang'));
    }

    public function Create()
    {
    	return view('admin.tentang.create');
    }

    public function Edit($slug,$id)
    {
        $data = detailtentang::where('id',$id)->get();
        return view('admin.tentang.edit', compact('data','slug'));
    }

    public function Store($slug, Request $req)
    {

    	$validated = $req->validate([
                'nama_tentang'   => 'required|max:255',
                'deskripsi' => 'required',
                'thumbnail'      => 'required|image'
            ]);
        
        $nama_tentang = $req->nama_tentang;
        $deskripsi = $req->deskripsi;
        $thumbnail = $req->file('thumbnail');

        $jenis = Tentang::where('slug',$slug)->get();
        $jenis_id = $jenis[0]->id;

        $tentang = new detailtentang();
        $tentang->nama = $nama_tentang;
        $tentang->tb_tentang_id = $jenis_id;
        $tentang->deskripsi = $deskripsi;
        $tentang->user_id = 1;
        $tentang->status = 0; //otomatis save as draft saat tentang masih di preview
        $tentang->save();

        $tentang = detailtentang::all()->last();
        $id = $tentang->id;
        $image_name = $thumbnail->getClientOriginalName();
        $extension = explode('.', $image_name);
        $extension = end($extension);
        $thumbnail_name = $id.'.'.$extension;
        $thumbnail->storeAs('admin/tentang/', $thumbnail_name, 'public');
        $thumbnail_url = 'admin/tentang/'.$thumbnail_name;
        $tentang->thumbnail_url = $thumbnail_url;
        $tentang->save();
        return redirect(route('admin.tentang.detail', [$slug]));
    }

    public function StoreDetail($slug, Request $req)
    {
        $validated = $req->validate([
                'thumbnail'   => 'required|image'
            ]);
        
        $galleries = detailtentang::all();
        foreach ($galleries as $tentang){
            $id = $tentang->id;
        }
        $id = $id+1;
        $tentang = tentang::where('slug',$slug)->get();
        $tentang_id = $tentang[0]->id;
        $thumbnail = $req->file('thumbnail');

        $image_name = $thumbnail->getClientOriginalName();
        $extension = explode('.', $image_name);
        $extension = end($extension);
        $thumbnail_name = $id.'.'.$extension;
        $thumbnail->storeAs('admin/tentang/', $thumbnail_name, 'public');
        $thumbnail_url = 'admin/tentang/'.$thumbnail_name;

        $check = detailtentang::where('tb_tentang_id', $tentang_id)
                    ->where('status',1)
                    ->get();
        if(empty($check[0])){
            $status = 1;
        }
        else{
            $status = 0;
        }

        $tentang = new detailtentang();
        $tentang->tb_tentang_id = $tentang_id;
        $tentang->thumbnail_url = $thumbnail_url;
        $tentang->user_id = 1;
        $tentang->status = $status;
        $tentang->save();

        return redirect(route('admin.tentang.detail',[$slug]));
    }

    public function Show($slug)
    {
        $datas = tentang::where('slug', $slug)->get();
        $source = "show";
        return view('admin.tentang.preview', compact('datas','slug','source'));
    }

    public function Update($slug, $id, Request $req)
    {    
        $datas = detailtentang::where('id', $id)->get();
        $validated = $req->validate([
                'nama_tentang'   => 'required|max:255',
                'deskripsi'     => 'required'
            ]);    
        
        $nama_tentang_new = $req->nama_tentang;
        $deskripsi_new = $req->deskripsi;
        $create_slug = str_replace(' ', '-', $nama_tentang_new);
        
        if($datas[0]->nama_tentang != $nama_tentang_new){
            $validated2 = $req->validate([
                'nama_tentang' => 'unique:tb_tentang'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = tentang::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        if($req->file('thumbnail') != null ){
            $id = $datas[0]->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/agamabudaya/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/agamabudaya/'.$thumbnail_name;
            $datas[0]->thumbnail_url = $thumbnail_url;
        }

        $datas[0]->nama = $nama_tentang_new;
        $datas[0]->deskripsi = $deskripsi_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->save();
        return redirect(route('admin.tentang.detail', $slug));
    }

    public function Thumbnail($slug,$id)
    {
        $all = detailtentang::all();
        foreach($all as $one){
            if($one->tentang->slug == $slug){
                $one->status = 0;
                $one->save();    
            }
        }
        $tentang = detailtentang::where('id', $id)->get();
        $tentang[0]->status = 1;
        $tentang[0]->save();
        return redirect(route('admin.tentang.detail', $slug));
    }

    public function Active($slug)
    {
        $tentang = tentang::where('slug',$slug)->get();
        
        $tentang[0]->status = 1;
        $tentang[0]->save();
        return redirect(route('admin.tentang.index'));
    }

    public function NonActive($slug)
    {
        $tentang = tentang::where('slug', $slug)->get();
        $tentang[0]->status = 0;
        $tentang[0]->save();        
        return redirect(route('admin.tentang.index'));
    }

    public function Delete($slug,$id)
    {
        $data = detailtentang::find($id);

        $data->delete();
        return redirect(route('admin.tentang.detail', $slug));
    }

}   
