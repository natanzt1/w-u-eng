<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agenda;
use Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\FakultasTrait;

class AgendaController extends Controller
{
    use FakultasTrait;
    Public function role_check()
    {
        $id = Auth::user()->identifier;
        $role = session()->get('role');
        $role_id = $role[0]->brokerrole_id;
        return $role_id;
    }

    public function Index()
    {
        $datas = Agenda::orderBy('tgl_rilis', 'desc')->get();
        $role_id = AgendaController::role_check();
    	return view('admin.agenda.index', compact('datas','role_id'));
    }

    public function Create()
    {
        $role_id = AgendaController::role_check();
    	return view('admin.agenda.create',compact('role_id'));
    }

    public function Store(Request $req)
    {
    	$validated = $req->validate([
                'nama_agenda'   => 'required|unique:tb_agenda|max:255',
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
        $slug = str_replace('/', '-', $nama_agenda);
        $slug = str_replace('?', '-', $nama_agenda);
    	$agenda = new Agenda();
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
    	$agenda->user_nama = $user;
    	$agenda->status = 0; //otomatis save as draft saat agenda masih di preview
    	$agenda->save();
        if(isset($thumbnail)){
            $agenda = Agenda::where('slug', $slug)->first();
            $id = $agenda[0]->id;
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = $id.'.'.$extension;
            $thumbnail->storeAs('admin/agenda/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/agenda/'.$thumbnail_name;
            $agenda->thumbnail_url = $thumbnail_url;
            $agenda->save();
        }
        
    	return redirect(route('admin.agenda.index'));
    }

    public function Show($slug)
    {
        $datas = Agenda::where('slug', $slug)->get();
        $source = "show";
        $all_fakultas = $this->fakultasAll();
        return view('admin.agenda.preview', compact('datas','slug','source','all_fakultas'));
    }

    public function Edit($slug)
    {
        $role_id = AgendaController::role_check();
        $data = Agenda::where('slug', $slug)->first();
    	return view('admin.agenda.edit', compact('data','slug','role_id'));
    }

    public function Update($slug, Request $req)
    {    
        $datas = Agenda::where('slug', $slug)->first();
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

        $rilis_new = $tgl.' '.$waktu. ':00';
        
        if($datas->nama_agenda != $nama_agenda_new){
            $validated2 = $req->validate([
                'nama_agenda' => 'unique:tb_agenda'
            ]);
            $slug_new = str_replace(' ', '-', $nama_agenda_new);
            $slug_new = str_replace('/', '-', $slug_new);
            $slug_new = str_replace('?', '-', $slug_new);
        }
        else{
            $slug_new = $slug;
        }

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

        $datas->nama_agenda = $nama_agenda_new;
        $datas->slug = $slug_new;
        $datas->konten = $konten_agenda_new;
        $datas->waktu_mulai = $mulai;
        $datas->waktu_selesai = $selesai;
        $datas->penyelenggara = $penyelenggara;
        $datas->kontak = $kontak;
        $datas->lokasi = $lokasi;
        $datas->website = $website;
        $datas->tgl_rilis = $rilis_new;
        $datas->user_nama = $user;
        $datas->status = 0;
        if($req->file('thumbnail') != null ){
            $id = $datas->id;
            $thumbnail = $req->file('thumbnail');
            $image_name = $thumbnail->getClientOriginalName();
            $extension = explode('.', $image_name);
            $extension = end($extension);
            $thumbnail_name = 'temp'.$id.'.'.$extension;
            $thumbnail->storeAs('admin/agenda/', $thumbnail_name, 'public');
            $thumbnail_url = 'admin/agenda/'.$thumbnail_name;
            $datas->thumbnail_url = $thumbnail_url;
        }
        $datas->save();
        
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
        
        $agenda = Agenda::where('slug', $slug_old)->get();
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
        $agenda = Agenda::where('slug', $slug)->first();
        $agenda->status = 1;
        $agenda->save();
        return redirect(route('admin.agenda.index'));
    }

    public function NonActive($slug)
    {
        $agenda = Agenda::where('slug', $slug)->first();
        $agenda->status = 0;
        $agenda->save();        
        return redirect(route('admin.agenda.index'));
    }

    public function Delete($slug)
    {
        $agenda = Agenda::where('slug', $slug)->first();
        $image_path = $agenda->thumbnail_url;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        $agenda->delete();
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
