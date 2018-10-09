<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
	protected $table = "tb_pegawai";

	public function AgamaBudaya(){
    	return $this->hasMany('App\AgamaBudaya');
    }

    public function Agenda(){
    	return $this->hasMany('App\Agenda');
    }

    public function Bem(){
    	return $this->hasMany('App\Bem');
    }

    public function DetailGallery(){
    	return $this->hasMany('App\DetailGallery');
    }

    public function Fakultas(){
    	return $this->hasMany('App\Fakultas');
    }
    public function Gallery(){
    	return $this->hasMany('App\Gallery');
    }

    public function Inkubator(){
    	return $this->hasMany('App\Inkubator');
    }

    public function Kalender(){
    	return $this->hasMany('App\Kalender');
    }

    public function Pengumuman(){
    	return $this->hasMany('App\Pengumuman');
    }

    public function Popup(){
    	return $this->hasMany('App\Popup');
    }

    public function Portal(){
    	return $this->hasMany('App\Portal');
    }

    public function Prodi(){
    	return $this->hasMany('App\Prodi');
    }

    public function Repository(){
    	return $this->hasMany('App\Repository');
    }

    public function Senat(){
    	return $this->hasMany('App\Senat');
    }

    public function Slider(){
    	return $this->hasMany('App\Slider');
    }

    public function Tentang(){
    	return $this->hasMany('App\Tentang');
    }

    public function Ukm(){
    	return $this->hasMany('App\Ukm');
    }

    public function Video(){
    	return $this->hasMany('App\Video');
    }

    public function Warta(){
    	return $this->hasMany('App\Warta');
    }
}
