<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    protected $table = "tb_popup";
    
    public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }
}
