<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class TokenAuthMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = trim($request->get('token'));

        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }




        $lastAccessTimeObj = ApiKey::where('apiKey',$token)->withTrashed()->first();

        if(!$lastAccessTimeObj) {
            return response()->json([
                'error' => 'Token not found.'
            ], 401);
        }

        if( $lastAccessTimeObj->deleted_at ) {
            return response()->json([
                'error' => 'Provided token is already expired.'
            ], 401);
        }

        $lastAccessTime = $lastAccessTimeObj->lastAccessTime ; 

        $session_expired_time = (int) getSystemSettingValue('session_expired_time');

        $duration = time() - $lastAccessTime;


        if( $duration  > $session_expired_time ){

            $lastAccessTimeObj->delete();

            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);
        }


        $explode_by = '.0.0.0.0.';
        $tokenArray = explode($explode_by, decrypt($token));
        $user_id = $tokenArray[0];
        $user_password = $tokenArray[1];
        $user = User::find($user_id);

        if( $user->password != $user_password){
            $lastAccessTimeObj->delete();
            return response()->json([
                'error' => 'Provided token is expired due to password change.'
            ], 400);
        }

        $request->auth = $user;

        $lastAccessTimeObj->save();
 
        // $currurnRouteName =     $request->route()[1]['as'];
        $currurnRouteName =  Route::currentRouteName();  
        // dd($currurnRouteName) ;

        if( ! User::haveCurrentRouteAccessPermissions($currurnRouteName, $user_id) ){
            return response()->json([
                'error' => 'Unauthorized Access'
            ], 401);
        }
        


        return $next($request);
    }


  
}
