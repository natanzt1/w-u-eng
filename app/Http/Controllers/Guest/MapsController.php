<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\FakultasTrait;
use App\Http\Traits\BiroTrait;

class MapsController extends Controller
{
    use FakultasTrait;
    use BiroTrait;
    public function petaKampus()
    {
        $biro_all = $this->biroAll();
        $all_fakultas = $this->fakultasAll();
        return view('guest.id.maps', compact('all_fakultas','biro_all'));
    }
}
