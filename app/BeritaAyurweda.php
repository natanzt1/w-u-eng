<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class BeritaAyurweda extends Model
{
    
    protected $table = "tb_berita_ayurweda";

    public function getDates()
    {
        Date::setLocale('id');
        return ['created_at','tgl_rilis'];
    }

    public function getCreatedAtAttribute($date)
    {
        return new Date($date);
    }

    public function getUpdatedAtAttribute($date)
    {
        return new Date($date);
    }

    public function getTglRilisAttribute($date)
    {
        return new Date($date);
    }   
}
