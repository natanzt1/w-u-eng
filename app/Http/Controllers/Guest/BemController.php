<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\FakultasTrait;
use App\Bem;
use App\Http\Traits\BiroTrait;

class BemController extends Controller
{
    use FakultasTrait;
    use BiroTrait;

    public function bem()
    {
        $bem = Bem::where('status',1)->first();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.kemahasiswaan.bem.logo', compact('all_fakultas','bem','biro_all'));
    }

    public function bemVisiMisi()
    {
        $bem = Bem::where('status',1)->first();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.kemahasiswaan.bem.visi_misi', compact('all_fakultas','bem','biro_all'));
    }

    public function bemOrganisasi()
    {
        $bem = Bem::where('status',1)->first();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.kemahasiswaan.bem.organisasi', compact('all_fakultas','bem','biro_all'));
    }
}
