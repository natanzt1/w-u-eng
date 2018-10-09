<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
	protected $table = "tb_profil_prodi";

	public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }

    public function GalleryProdi(){
    	return $this->hasMany('App\GalleryProdi');
    }

    public function Fakultas(){
    	return $this->belongsTo('App\Fakultas');
    }
}
