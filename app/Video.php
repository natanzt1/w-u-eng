<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = "tb_video";
    
    public function User(){
        return $this->belongsTo('App\Pegawai','user_id','pegawai_id');
    }

    public function getYoutubeId()
    {
        if(strlen($this->url) > 11)
        {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->url, $match))
            {
                return $match[1];
            }
            else
                return false;
        }

        return $this->url;
    }
}
