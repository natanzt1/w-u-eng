<?php

namespace App;
use Config;
use DB;

class DatabaseConnection
{
    public static function setConnection($broker)
    {
        config(['database.connections.broker' => [
            'driver'    => 'mysql',
            'host'      => $broker->db_host,
            'database'  => $broker->db_name,
            'username'  => $broker->db_user,
            'password'  => $broker->db_pass
        ]]);
        return DB::connection('broker');
    }
}