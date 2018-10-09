<?php

namespace App\Http\Middleware;

use Closure;
use App\SSO\AuthRequest;
use App\User;
use Auth;
use App\DatabaseConnection;

class AuthMiddleware extends AuthRequest
{

    public function handle($request, Closure $next)
    {
        $this->authenticate();

        if (!isset($_SESSION['isUserLogin']) || !Auth::check()) {
            Auth::guard()->logout();
            session()->invalidate();

            $user = (array) $_SESSION['authUser'];

            $auth_user = User::where('flag', 1)
                ->where('sso_id', $user['ssoId'])
                ->first();

            session(['brokerAuth' => $auth_user]);
            if (empty($auth_user)) {
                return response()->view('errors.noaccess');
            }


            if (!session()->has('role')) {
                $sso = collect((object)[
                    'db_host' => '206.189.91.110', 
                    'db_name' => 'db_identity', 
                    'db_user' => 'auth',
                    'db_pass' => 'authsso'
                ]);

                $sso = json_decode(json_encode($sso));

                $ssoConnection = DatabaseConnection::setConnection($sso);
                try{
                    $ssoConnection->getPdo();
                    $userrole = $ssoConnection->table('tb_user_mapping')
                        ->where([
                            'user_id'  => $user['ssoId'],
                            'kode_broker'  => config('app.code')
                        ])
                        ->select(
                            'brokerrole_id', 
                            'nama_role', 
                            'is_default',
                            'program_id',
                            'prodi_id',
                            'fakultas_id'
                        )
                        ->orderBy('is_default', 'desc')
                        ->get();

                    if ($userrole->count()) {
                        $currentRole = $userrole->first();
                    }else{
                        return response()->view('errors.noaccess');
                    }

                } catch (PDOExeption $e){
                    return response()->json([
                        'error' => 'the system is trying to connect to sso server, but failed'
                    ]);
                }

                Auth::loginUsingId($auth_user->user_id);
                $_SESSION['isUserLogin'] = 1;

                session()->put('role', $userrole);
                session()->put('currentRole', $currentRole);
            }

            
        }

        return $next($request);
    }
}