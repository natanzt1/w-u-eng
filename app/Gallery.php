<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = "tb_gallery";
    
    public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }

    public function DetailGallery(){
        return $this->hasMany('App\DetailGallery','tb_gallery_id');
    }
}
