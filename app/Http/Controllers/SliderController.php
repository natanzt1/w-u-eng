<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
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
        $datas = Slider::latest()->get();
        $role_id = SliderController::role_check();
    	return view('admin.slider.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = SliderController::role_check();
    	return view('admin.slider.create',compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_slider'   => 'required|unique:tb_slider|max:255',
                
                
            ]);
        // return dd($req->thumbnail);
    	$nama_slider = $req->nama_slider;
    	$konten_slider = $req->konten_slider;
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

        $slug = str_replace(' ', '-', $nama_slider);
    	$slider = new Slider();
    	$slider->nama_slider = $nama_slider;
    	$slider->konten = $konten_slider;
        $slider->slug = $slug;
    	$slider->user_nama = $user;
    	$slider->status = 0; //otomatis save as draft saat slider masih di preview
    	$slider->save();

        if(isset($slider)){
            $slider = Slider::where('slug', $slug)->first();
            $id = $slider->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/slider/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/slider/'.$thumbnail_name;
            $slider->thumbnail_url = $thumbnail_url;
            $slider->save();    
        }
        
    	return redirect(route('admin.slider.index'));
    }

    public function Show($slug)
    {
        $datas = Slider::where('slug', $slug)->get();
        $source = "show";
        return view('admin.slider.preview', compact('datas','slug','source'));
    }

    public function Edit($slug)
    {
        $role_id = SliderController::role_check();
        $data = Slider::where('slug', $slug)->first();
    	return view('admin.slider.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Slider::where('slug', $slug)->first();
        $validated = $req->validate([
                'nama_slider'   => 'required|max:255',
                
            ]);    
        
        $nama_slider_new = $req->nama_slider;
        $konten_slider_new = $req->konten_slider;

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
        
        if($datas->nama_slider != $nama_slider_new){
            $validated2 = $req->validate([
                'nama_slider' => 'unique:tb_slider'
            ]);
            $slug_new = str_replace(' ', '-', $nama_slider_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        }

        $datas->nama_slider = $nama_slider_new;
        $datas->slug = $slug_new;
        $datas->user_nama = $user;
        $datas->konten = $konten_slider_new;
        if($req->file('thumbnail') != null ){
            $id = $datas->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/slider/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/slider/'.$thumbnail_name;
            $datas->thumbnail_url = $thumbnail_url;
        }
        $datas->save();
        return redirect(route('admin.slider.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_slider = $req->nama_slider;
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
        $slider = Slider::where('slug', $slug_old)->get();
        $slider[0]->nama_slider = $nama_slider;
        $slider[0]->konten = $konten;
        $slider[0]->slug = $slug_new;
        $slider[0]->thumbnail_url = $thumbnail_url;
        $slider[0]->user_id = 1; //Pengedit slider
        $slider[0]->save();
        return redirect(route('admin.slider.index'));
    }

    public function Active($slug)
    {
        $slider = Slider::where('slug', $slug)->first();
        $slider->status = 1;
        $slider->save();
        return redirect(route('admin.slider.index'));
    }

    public function NonActive($slug)
    {
        $slider = Slider::where('slug', $slug)->first();
        $slider->status = 0;
        $slider->save();        
        return redirect(route('admin.slider.index'));
    }

    public function Delete($slug)
    {
        $slider = Slider::where('slug', $slug)->first();
        $image_path = $slider->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $slider->delete();
        return redirect(route('admin.slider.index'));
    }

    /*Cadangan
    public function sliderUpdate2($slug_old, Request $req)
    {    
        $slider_old = Slider::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_slider'   => 'required|max:255',
                'konten_slider' => 'required'
            ]);    
        
        $nama_slider_new = $req->nama_slider;
        $konten_slider_new = $req->konten_slider;
        $create_slug = str_replace(' ', '-', $nama_slider_new);
        
        foreach($slider_old as $slider){
            if($slider->nama_slider != $nama_slider_new){
                $validated2 = $req->validate([
                    'nama_slider' => 'unique:tb_slider'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = Slider::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        Slider::where('slug', $slug_old)
          ->update(['nama_slider' => $nama_slider_new , 'konten' => $konten_slider_new , 'slug' => $slug_new]);
    	return redirect(route('admin.slider.index'));
    }*/

}   
