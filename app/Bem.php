<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bem extends Model
{
	protected $table = "tb_bem";
	public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }
}
