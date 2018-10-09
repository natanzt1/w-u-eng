<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\agenda;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\FakultasTrait;

class AgendaController extends Controller
{
    use FakultasTrait;
    public function Index()
    {
        $datas = agenda::all();
    	return view('admin.agenda.index', compact('datas'));
    }

    public function Create()
    {
    	return view('admin.agenda.create');
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_agenda'   => 'required|unique:tb_agenda|max:255',
                
                'tgl_mulai'     => 'required',
                'waktu_mulai'     => 'required',
                'tgl_selesai'     => 'required',
                'waktu_selesai'     => 'required'
            ]);
           
    	$nama_agenda = $req->nama_agenda;
    	$konten_agenda = $req->konten_agenda;
        $thumbnail = $req->file('thumbnail');
        $penyelenggara = $req->penyelenggara;
        $kontak = $req->kontak;
        $website = $req->website;
        $lokasi = $req->lokasi;
        $tgl_mulai = $req->tgl_mulai;
        $waktu_mulai = $req->waktu_mulai;
        $tgl_selesai = $req->tgl_selesai;
        $waktu_selesai = $req->waktu_selesai;
        $tgl = $req->tanggal;
        $waktu = $req->waktu;

        $rilis = $tgl.' '.$waktu. ':00';
        
        $tgl = explode('/',$tgl_mulai);
        $bln = $tgl[0];
        $thn = $tgl[2];
        $tgl = $tgl[1];
        $tgl_mulai = $thn.'-'.$bln.'-'.$tgl;
        
        $mulai = $tgl_mulai.' '.$waktu_mulai. ':00';
        
        $tgl = explode('/',$tgl_selesai);
        $bln = $tgl[0];
        $thn = $tgl[2];
        $tgl = $tgl[1];
        $tgl_selesai = $thn.'-'.$bln.'-'.$tgl;
        
        $selesai = $tgl_selesai.' '.$waktu_selesai. ':00';

        $slug = str_replace(' ', '-', $nama_agenda);
    	$agenda = new agenda();
    	$agenda->nama_agenda = $nama_agenda;
        $agenda->tgl_rilis = $rilis;
    	$agenda->konten = $konten_agenda;
        $agenda->slug = $slug;
        $agenda->waktu_mulai = $mulai;
        $agenda->waktu_selesai = $selesai;
        $agenda->penyelenggara = $penyelenggara;
        $agenda->kontak = $kontak;
        $agenda->lokasi = $lokasi;
        $agenda->website = $website;
    	$agenda->user_id = 1;
    	$agenda->status = 0; //otomatis save as draft saat agenda masih di preview
    	$agenda->save();
        if(isset($thumbnail)){
            $agenda = agenda::where('slug', $slug)->get();
            $id = $agenda[0]->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/agenda/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/agenda/'.$thumbnail_name;
            $agenda[0]->thumbnail_url = $thumbnail_url;
            $agenda[0]->save();
        }
        
    	return redirect(route('admin.agenda.index'));
    }

    public function Show($slug)
    {
        $datas = agenda::where('slug', $slug)->get();
        $source = "show";
        $all_fakultas = $this->fakultasAll();
        return view('admin.agenda.preview', compact('datas','slug','source','all_fakultas'));
    }

    public function Edit($slug)
    {
        $data = agenda::where('slug', $slug)->get();
    	return view('admin.agenda.edit', compact('data','slug'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = agenda::where('slug', $slug)->get();
        $validated = $req->validate([
                'nama_agenda'   => 'required|max:255',
            ]);    
        
        $nama_agenda_new = $req->nama_agenda;
        $konten_agenda_new = $req->konten_agenda;
        $penyelenggara = $req->penyelenggara;
        $kontak = $req->kontak;
        $website = $req->website;
        $lokasi = $req->lokasi;
        $tgl_mulai = $req->tgl_mulai;
        $waktu_mulai = $req->waktu_mulai;
        $tgl_selesai = $req->tgl_selesai;
        $waktu_selesai = $req->waktu_selesai;
        $tgl = $req->tanggal;
        $waktu = $req->waktu;

        $rilis_new = $tgl.' '.$waktu. ':00';
        $create_slug = str_replace(' ', '-', $nama_agenda_new);
        
        if($datas[0]->nama_agenda != $nama_agenda_new){
            $validated2 = $req->validate([
                'nama_agenda' => 'unique:tb_agenda'
            ]);
        }
        
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = agenda::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));   

        $tgl = explode('/',$tgl_mulai);
        $bln = $tgl[0];
        $thn = $tgl[2];
        $tgl = $tgl[1];
        $tgl_mulai = $thn.'-'.$bln.'-'.$tgl;
        
        $mulai = $tgl_mulai.' '.$waktu_mulai. ':00';
        
        $tgl = explode('/',$tgl_selesai);
        $bln = $tgl[0];
        $thn = $tgl[2];
        $tgl = $tgl[1];
        $tgl_selesai = $thn.'-'.$bln.'-'.$tgl;

        $selesai = $tgl_selesai.' '.$waktu_selesai. ':00';

        $datas[0]->nama_agenda = $nama_agenda_new;
        $datas[0]->slug = $slug_new;
        $datas[0]->konten = $konten_agenda_new;
        $datas[0]->waktu_mulai = $mulai;
        $datas[0]->waktu_selesai = $selesai;
        $datas[0]->penyelenggara = $penyelenggara;
        $datas[0]->kontak = $kontak;
        $datas[0]->lokasi = $lokasi;
        $datas[0]->website = $website;
        $datas[0]->tgl_rilis = $rilis_new;
        if($req->file('thumbnail') != null ){
            $id = $datas[0]->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/agenda/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/agenda/'.$thumbnail_name;
            $datas[0]->thumbnail_url = $thumbnail_url;
        }
        $datas[0]->save();
        
        return redirect(route('admin.agenda.index'));
    }

    public function SaveUpdate(Request $req)
    {
        $slug_old = $req->old_slug;
        $slug_new = $req->new_slug;
        $nama_agenda = $req->nama_agenda;
        $konten = $req->konten;
        $penyelenggara = $req->penyelenggara;
        $kontak = $req->kontak;
        $website = $req->website;
        $lokasi = $req->lokasi;
        $mulai = $req->waktu_mulai;
        $selesai = $req->waktu_selesai;
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
        
        $agenda = agenda::where('slug', $slug_old)->get();
        $agenda[0]->nama_agenda = $nama_agenda;
        $agenda[0]->konten = $konten;
        $agenda[0]->slug = $slug_new;
        $agenda[0]->thumbnail_url = $thumbnail_url;
        $agenda[0]->waktu_mulai = $mulai;
        $agenda[0]->waktu_selesai = $selesai;
        $agenda[0]->penyelenggara = $penyelenggara;
        $agenda[0]->kontak = $kontak;
        $agenda[0]->lokasi = $lokasi;
        $agenda[0]->website = $website;
        $agenda[0]->user_id = 1; //Pengedit agenda
        $agenda[0]->save();
        return redirect(route('admin.agenda.index'));
    }

    public function Active($slug)
    {
        $agenda = agenda::where('slug', $slug)->get();
        $agenda[0]->status = 1;
        $agenda[0]->save();
        return redirect(route('admin.agenda.index'));
    }

    public function NonActive($slug)
    {
        $agenda = agenda::where('slug', $slug)->get();
        $agenda[0]->status = 0;
        $agenda[0]->save();        
        return redirect(route('admin.agenda.index'));
    }

    public function Delete($slug)
    {
        $agenda = agenda::where('slug', $slug)->get();
        $image_path = $agenda[0]->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $agenda[0]->delete();
        return redirect(route('admin.agenda.index'));
    }

    /*Cadangan
    public function agendaUpdate2($slug_old, Request $req)
    {    
        $agenda_old = agenda::where('slug', $slug_old)->get();
        $validated = $req->validate([
                'nama_agenda'   => 'required|max:255',
                'konten_agenda' => 'required'
            ]);    
        
        $nama_agenda_new = $req->nama_agenda;
        $konten_agenda_new = $req->konten_agenda;
        $create_slug = str_replace(' ', '-', $nama_agenda_new);
        
        foreach($agenda_old as $agenda){
            if($agenda->nama_agenda != $nama_agenda_new){
                $validated2 = $req->validate([
                    'nama_agenda' => 'unique:tb_agenda'
                ]);
            }
        }
        do {
            $slug_new = $create_slug."-".rand(0,10000);
            $slug_check = agenda::where('slug', $slug_new)->get();
        } while (isset($slug_check[0]));    
        agenda::where('slug', $slug_old)
          ->update(['nama_agenda' => $nama_agenda_new , 'konten' => $konten_agenda_new , 'slug' => $slug_new]);
    	return redirect(route('admin.agenda.index'));
    }*/

}   
