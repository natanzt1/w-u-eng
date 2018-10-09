<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Senat;
use App\Http\Traits\FakultasTrait;
use App\Http\Traits\BiroTrait;

class SenatController extends Controller
{
    use FakultasTrait;
    use BiroTrait;
    public function senatAll()
    {
    	$senats = Senat::where('status','1')->get();
        $data = Senat::where('status','1')->first();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.kemahasiswaan.senat.senat',compact('all_fakultas','senats', 'data','biro_all'));
    }

    public function senat($slug)
    {
        $senats = Senat::where('status','1')->get();
        $data = Senat::where('slug',$slug)->first();
        $all_fakultas = $this->fakultasAll();
        $biro_all = $this->biroAll();
        return view('guest.id.kemahasiswaan.senat.senat',compact('all_fakultas','senats','data','biro_all'));
    }
}
