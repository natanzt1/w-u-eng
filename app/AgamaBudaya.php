<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgamaBudaya extends Model
{
	protected $table = "tb_agamabudaya";

    public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }
}
