<?php

namespace App\Http\Traits;
use App\Biro;

trait BiroTrait {
    public function biroAll() {
        
        $biro = Biro::where('status', '1')->get(['nama_biro','slug']);

        return $biro;
    }

}