<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Agenda;
use App\Http\Traits\FakultasTrait;
use App\Http\Traits\BiroTrait;
use App\Berita;
use Jenssegers\Date\Date;

class AgendaController extends Controller
{
    use FakultasTrait;
    use BiroTrait;

    public function listAgenda()
    {
        $agendas = Agenda::latest()->where('status',1)->paginate(6,['id','nama_agenda','konten','status','thumbnail_url','waktu_mulai','slug','views']);
        // return $agendas;
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.agenda.list_agenda', compact('agendas','all_fakultas','sidebar_beritas','biro_all'));
    }

    public function detailAgenda($slug)
    {
        Date::setLocale('id');
        $agenda = Agenda::where('slug', $slug)->first();
        // return $agenda;
        $sidebar_agendas = Agenda::orderBy('waktu_mulai', 'desc')->where('status',1)->where('slug','!=', $slug)->get()->take(6);
        $agenda->views = $agenda->views + 1;
        $agenda->save();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.agenda.detail_agenda', compact('agenda','all_fakultas','sidebar_agendas','biro_all'));
    }
}
