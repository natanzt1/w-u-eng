<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'rbac_user';
    protected $primaryKey = 'user_id';

    public function mhs(){
        return $this->hasOne('App\Mahasiswa', 'nim', 'identifier');
    }

    public function dosen(){
        return $this->hasOne('App\Dosen', 'nip', 'identifier');
    }

    public function pegawai(){
        return $this->hasOne('App\Pegawai', 'nip', 'identifier');
    }
}