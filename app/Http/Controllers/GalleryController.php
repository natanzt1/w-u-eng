<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\DetailGallery;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
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
        $role_id = GalleryController::role_check();
        $datas = Gallery::latest()->get(); /*Status 1 = Thumbnail*/
    	return view('admin.gallery.index', compact('datas','role_id'));
    }

    public function Detail($slug)
    {
        $role_id = GalleryController::role_check();   
        $gallery = Gallery::where('slug', $slug)->first();
        $id = $gallery->id;
        $datas = DetailGallery::where('tb_gallery_id', $id)->get();
        if(empty($datas[0])){
            $parameter = "null";
        }
        else{
            $parameter = "isset";
        }
        
        return view('admin.gallery.detail', compact('datas','parameter','gallery','role_id'));
    }

    public function Create()
    {
        $role_id = GalleryController::role_check();
    	return view('admin.gallery.create',compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_gallery'   => 'required|unique:tb_gallery|max:255'
            ]);
        
    	$nama_gallery = $req->nama_gallery;
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
        
        $slug = str_replace(' ', '-', $nama_gallery);
        $slug = str_replace('/', '-', $slug);
    	$gallery = new Gallery();
    	$gallery->nama_gallery = $nama_gallery;
        $gallery->slug = $slug;
    	$gallery->user_nama = $user;
    	$gallery->status = 0;
    	$gallery->save();

        return redirect(route('admin.gallery.index'));
    }

    public function StoreDetail($slug, Request $req)
    {
        $validated = $req->validate([
                'thumbnail'   => 'required|image'
            ]);
        
        $galleries = DetailGallery::all();
        foreach($galleries as $gallery){
            $id = $gallery->id;
        }
        if(empty($id)){
            $id = 1;
        }
        $gallery = Gallery::where('slug',$slug)->first();
        $gallery_id = $gallery->id;
        $thumbnail = $req->file('thumbnail');

        $image_name = $thumbnail->getClientOriginalName();
        $extension = explode('.', $image_name);
        $extension = end($extension);
        $thumbnail_name = $id.'.'.$extension;
        $thumbnail->storeAs('admin/gallery/', $thumbnail_name, 'public');
        $thumbnail_url = 'admin/gallery/'.$thumbnail_name;

        $check = DetailGallery::where('tb_gallery_id', $gallery_id)
                    ->where('status',1)
                    ->first();
        if(empty($check->id)){
            $status = 1;
        }
        else{
            $status = 0;
        }

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

        $gallery = new DetailGallery();
        $gallery->tb_gallery_id = $gallery_id;
        $gallery->thumbnail_url = $thumbnail_url;
        $gallery->user_nama = $user;
        $gallery->status = $status;
        $gallery->save();

        return redirect(route('admin.gallery.detail',[$slug]));
    }

    public function Show($slug)
    {
        $datas = Gallery::where('slug', $slug)->get();
        $source = "show";
        return view('admin.gallery.preview', compact('datas','slug','source'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Gallery::where('slug', $slug)->first();
        $validated = $req->validate([
                'nama_gallery'   => 'required|max:255',
            ]);    
        
        $nama_gallery_new = $req->nama_gallery;
        $create_slug = str_replace(' ', '-', $nama_gallery_new);
        
        if($datas->nama_gallery != $nama_gallery_new){
            $validated2 = $req->validate([
                'nama_gallery' => 'unique:tb_gallery'
            ]);
            $slug_new = str_replace(' ', '-', $nama_gallery_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        }

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
        
        $datas->nama_gallery = $nama_gallery_new;
        $datas->slug = $slug_new;
        $datas->user_nama = $user;
        $datas->save();
        return redirect(route('admin.gallery.index'));
    }

    public function Thumbnail($slug,$id) //untuk mengubah status foto menjadi aktif
    {
        $gallery = DetailGallery::where('id', $id)->first();
        $gallery->status = 1;
        $gallery->save();
        return redirect(route('admin.gallery.detail', $slug));
    }

    public function Active($slug)
    {
        $gallery = Gallery::where('slug',$slug)->first();
        $detailgallery = DetailGallery::where('tb_gallery_id', $gallery->id)->first();
        if(isset($detailgallery)){
            $gallery->status = 1;
            $gallery->save();    
        }
        
        return redirect(route('admin.gallery.index'));
    }

    public function NonActive($slug)
    {
        $gallery = Gallery::where('slug', $slug)->first();
        $gallery->status = 0;
        $gallery->save();        
        return redirect(route('admin.gallery.index'));
    }

    public function Delete($slug,$id)
    {
        $foto = DetailGallery::find($id);
        if($foto->status == 1 ){
            $gallery = Gallery::where('slug', $slug)->get();
            $gallery_id = $gallery[0]->id;
            $fotos = DetailGallery::where('tb_gallery_id',$gallery_id)
                ->where('status',0)
                ->first();
            if(isset($fotos)){
                $fotos->status = 1;
                $fotos->save();    
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
