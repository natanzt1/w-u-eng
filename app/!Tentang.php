<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tentang extends Model
{
	protected $table = "tb_tentang";

	public function DetailTentang(){
        return $this->hasMany('App\DetailTentang');
    }
}
