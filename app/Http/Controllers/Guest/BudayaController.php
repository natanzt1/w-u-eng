<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AgamaBudaya;
use App\Http\Traits\FakultasTrait;
use App\Http\Traits\BiroTrait;

class BudayaController extends Controller
{
    use FakultasTrait;
    use BiroTrait;
    public function listBudaya()
    {
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.agenda.list_agenda','all_fakultas','biro_all');
    }

    public function detailBudaya($slug)
    {
        $agama_budaya = AgamaBudaya::where('slug', $slug)->first();
        // return $agama_budaya;
        $sidebar_agamas = AgamaBudaya::latest()->where('status',1)->where('slug','!=', $slug)->get()->take(6);
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        $agama_budaya->views = $agama_budaya->views + 1;
        $agama_budaya->save();
        return view('guest.id.detail_agama_budaya',compact('agama_budaya','all_fakultas','sidebar_agamas','biro_all'));
    }

    public function listBudayaEnglish()
    {
        $all_fakultas = $this->fakultasAll();
        return view('guest.en.agenda.list_agenda','all_fakultas');
    }

    public function detailBudayaEnglish($slug)
    {
        $agama_budaya = AgamaBudaya::where('slug', $slug)->first();
        // return $agama_budaya;
        $all_fakultas = $this->fakultasAll();
        return view('guest.en.detail_agama_budaya',compact('agama_budaya','all_fakultas'));
    }
}
