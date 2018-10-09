<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailGallery extends Model
{
    protected $table = "tb_detailgallery";
    
    public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }

    public function Gallery(){
    	return $this->belongsTo('App\gallery', 'tb_gallery_id');
    }
}
