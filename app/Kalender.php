<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kalender extends Model
{
    protected $table = "tb_kalender";
    
    public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }
}
