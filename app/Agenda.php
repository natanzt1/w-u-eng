<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Agenda extends Model
{
    protected $table = "tb_agenda";

   
    public function getDates()
    {
        // Date::setLocale('id');
        return ['created_at','waktu_mulai','waktu_selesai'];
    }

    public function getCreatedAtAttribute($date)
    {
        return new Date($date);
    }

    public function getWaktuMulaiAttribute($date)
    {
        return new Date($date);
    }

    public function getWaktuSelesaiAttribute($date)
    {
        return new Date($date);
    }
    public function getUpdatedAtAttribute($date)
    {
        return new Date($date);
    }

    public function getPublishedAtAttribute($date)
    {
        return new Date($date);
    }   
    public function User(){
        return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }
}
