<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portal extends Model
{
    protected $table = "tb_portal";
    
    public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }
}
