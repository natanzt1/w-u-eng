<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Biro extends Model
{
	protected $table = "tb_biro";

    public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }
}
