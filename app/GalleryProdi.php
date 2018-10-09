<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryProdi extends Model
{
    protected $table = "tb_gallery_prodi";
    
    public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }

    public function Prodi(){
        return $this->hasMany('App\Prodi');
    }
}
