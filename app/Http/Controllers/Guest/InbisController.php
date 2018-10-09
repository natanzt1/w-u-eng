<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Inkubator;
use App\Http\Controllers\Controller;
use App\Http\Traits\FakultasTrait;
use App\Berita;
use App\Http\Traits\BiroTrait;

class InbisController extends Controller
{
    use FakultasTrait;
    use BiroTrait;
    public function latarBelakang()
    {
    	$latar_belakang = Inkubator::where('nama_inkubator', 'Latar Belakang')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        return view('guest.id.inbis.latar_belakang', compact('all_fakultas','latar_belakang','sidebar_beritas','biro_all'));
    }

    public function visiMisi()
    {
    	$visi = Inkubator::where('nama_inkubator', 'Visi')->get();
        $misi = Inkubator::where('nama_inkubator', 'Misi')->get();
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.inbis.visi_misi', compact('all_fakultas','visi','misi','sidebar_beritas','biro_all'));
    }

    public function strukturOrganisasi()
    {
    	$struktur = Inkubator::where('nama_inkubator', 'Struktur Organisasi')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        return view('guest.id.inbis.struktur_organisasi', compact('all_fakultas','struktur','sidebar_beritas','biro_all'));
    }

    public function tenantInwall()
    {
    	$inwall = Inkubator::where('nama_inkubator', 'Tenant Inwall')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        return view('guest.id.inbis.tenant_inwall', compact('all_fakultas','inwall','sidebar_beritas','biro_all'));
    }

    public function tenantOutwall()
    {
    	$outwall = Inkubator::where('nama_inkubator', 'Tenant Outwall')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        return view('guest.id.inbis.tenant_outwall', compact('all_fakultas','outwall','sidebar_beritas','biro_all'));
    }

    public function pendampingTenant()
    {
    	$tenant = Inkubator::where('nama_inkubator', 'Pendamping Tenant')->get();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        $sidebar_beritas = Berita::orderBy('tgl_rilis', 'desc')->where('status',1)->get(['id','nama_berita','status','tgl_rilis','slug','konten'])->take(6);
        return view('guest.id.inbis.pendamping_tenant', compact('all_fakultas','tenant','sidebar_beritas','biro_all'));
    }
}
