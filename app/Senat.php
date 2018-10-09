<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Senat extends Model
{
	protected $table = "tb_senat";

	public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }
}
