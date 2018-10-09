<?php

namespace App\Http\Traits;
use App\Fakultas;

trait FakultasTrait {
    public function fakultasAll() {
        
        $fakultas = Fakultas::where('status', '1')->get();

        return $fakultas;
    }

    public function ayurweda() {
        
        $ayurweda = Fakultas::where('status',1)->where('nama_fakultas','Kesehatan Ayurweda')->first(['slug']);

        return $ayurweda;
    }
}