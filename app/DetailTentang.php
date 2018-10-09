<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTentang extends Model
{
	protected $table = "tb_detailtentang";

    public function User(){
    	return $this->belongsTo('App\Pegawai', 'user_id');
    }

    public function Tentang(){
    	return $this->belongsTo('App\Tentang', 'tb_tentang_id');
    }
}
