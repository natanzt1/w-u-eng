<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Pengumuman extends Model
{
    protected $table = "tb_pengumuman";
    
    public function getDates()
    {
        // Date::setLocale('id');
        return ['created_at'];
    }

    public function getCreatedAtAttribute($date)
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
