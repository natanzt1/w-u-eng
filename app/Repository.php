<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $table = "tb_repository";
    
    public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }
}
