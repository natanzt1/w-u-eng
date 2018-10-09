<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ukm extends Model
{
	protected $table = "tb_ukm";

	public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }
}
