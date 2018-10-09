<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tentang extends Model
{
	protected $table = "tb_tentang";

	public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }
}
