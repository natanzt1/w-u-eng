<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryFakultas extends Model
{
    protected $table = "tb_gallery_fakultas";
    
    public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }

    public function Fakultas(){
        return $this->belongsTo('App\Fakultas');
    }
}
