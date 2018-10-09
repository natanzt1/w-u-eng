<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\gallery;
use App\detailgallery;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function Index()
    {
        $datas = gallery::all(); /*Status 1 = Thumbnail*/
    	return view('admin.gallery.index', compact('datas'));
    }

    public function Detail($slug)
    {
        $gallery = gallery::where('slug', $slug)->get(); /*Status 1 = Thumbnail*/
        $id = $gallery[0]->id;
        $datas = detailgallery::where('tb_gallery_id', $id)->get();
        if(empty($datas[0])){
            $parameter = "null";
        }
        else{
            $parameter = "isset";
        }
        
        return view('admin.gallery.detail', compact('datas','parameter','gallery'));
    }

    public function Create()
    {
    	return view('admin.gallery.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_gallery'   => 'required|unique:tb_gallery|max:255'
            ]);
        
    	$nama_gallery = $req->nama_gallery;
        
        $slug = str_replace(' ', '-', $nama_gallery);
        $slug = str_replace('/', '-', $slug);
    	$gallery = new gallery();
    	$gallery->nama_gallery = $nama_gallery;
        $gallery->slug = $slug;
    	$gallery->user_id = 1;
    	$gallery->status = 0;
    	$gallery->save();

        return redirect(route('admin.gallery.index'));
    }

    public function StoreDetail($slug, Request $req)
    {
        $validated = $req->validate([
                'thumbnail'   => 'required|image'
            ]);
        
        $galleries = detailgallery::all();
        foreach($galleries as $gallery){
            $id = $gallery->id;
        }
        if(empty($id)){
            $id = 1;
        }
        $gallery = Gallery::where('slug',$slug)->get();
        $gallery_id = $gallery[0]->id;
        $thumbnail = $req->file('thumbnail');

        $image_name = $thumbnail->getClientOriginalName();
        $extension = explode('.', $image_name);
        $extension = end($extension);
        $thumbnail_name = $id.'.'.$extension;
        $thumbnail->storeAs('admin/gallery/', $thumbnail_name, 'public');
        $thumbnail_url = 'admin/gallery/'.$thumbnail_name;

        $check = detailgallery::where('tb_gallery_id', $gallery_id)
                    ->where('status',1)
                    ->get();
        if(empty($check[0])){
            $status = 1;
        }
        else{
            $status = 0;
        }

        $gallery = new detailgallery();
        $gallery->tb_gallery_id = $gallery_id;
        $gallery->thumbnail_url = $thumbnail_url;
        $gallery->user_id = 1;
        $gallery->status = $status;
        $gallery->save();

        return redirect(route('admin.gallery.detail',[$slug]));
    }

    public function Show($slug)
    {
        $datas = gallery::where('slug', $slug)->get();
        $source = "show";
        return view('admin.gallery.preview', compact('datas','slug','source'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = gallery::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_gallery'   => 'required|max:255',
            ]);    
        
        $nama_gallery_new = $req->nama_gallery;
        $create_slug = str_replace(' ', '-', $nama_gallery_new);
        
        if($datas[0]->nama_gallery != $nama_gallery_new){
            $validated2 = $req->validate([
                'nama_gallery' => 'unique:tb_gallery'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = gallery::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $datas[0]->nama_gallery = $nama_gallery_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->save();
        return redirect(route('admin.gallery.index'));
    }

    public function Thumbnail($slug,$id)
    {
        $all = detailgallery::all();
        foreach($all as $one){
            if($one->gallery->slug == $slug){
                $one->status = 0;
                $one->save();    
            }
        }
        $gallery = detailgallery::where('id', $id)->get();
        $gallery[0]->status = 1;
        $gallery[0]->save();
        return redirect(route('admin.gallery.detail', $slug));
    }

    public function Active($slug)
    {
        $gallery = gallery::where('slug',$slug)->get();
        
        $gallery[0]->status = 1;
        $gallery[0]->save();
        return redirect(route('admin.gallery.index'));
    }

    public function NonActive($slug)
    {
        $gallery = gallery::where('slug', $slug)->get();
        $gallery[0]->status = 0;
        $gallery[0]->save();        
        return redirect(route('admin.gallery.index'));
    }

    public function Delete($slug,$id)
    {
        $foto = detailgallery::find($id);
        if($foto->status == 1 ){
            $gallery = Gallery::where('slug', $slug)->get();
            $gallery_id = $gallery[0]->id;
            $fotos = detailgallery::where('tb_gallery_id',$gallery_id)
                ->where('status',0)
                ->take(1)
                ->get();
            if(isset($fotos[0])){
                $fotos[0]->status = 1;
                $fotos[0]->save();    
            }
            
        }
        $image_path = $foto->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        $foto->delete();
        return redirect(route('admin.gallery.detail', $slug));
    }

}   
