<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warta extends Model
{
    protected $table = "tb_warta";
    
    public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }
}
