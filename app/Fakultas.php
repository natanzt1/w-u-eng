<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
	protected $table = "tb_profil_fakultas";

	public function User(){
    	return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }

    public function Prodi(){
    	return $this->hasMany('App\Prodi');
    }

    public function GalleryFakultas(){
    	return $this->belongsTo('App\GalleryFakultas','fakultas_id');
    }
}
