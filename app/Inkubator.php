<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inkubator extends Model
{
	protected $table = "tb_inkubator";
	public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }
}
