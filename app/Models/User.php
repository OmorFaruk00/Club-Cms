<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id',
        'created_by',
        'image',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }
    public function createtedBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }
    

    public static function haveCurrentRouteAccessPermissions($routeName, $user_id)
    {


        /**
         *   user will get access permission of courrent route if user is accessing common route for all user
         */
          $commonRouteNames = getAllLogedinUserCanAccessRouteNameAsArray();

        if (in_array($routeName, $commonRouteNames)) {
            return true;
        }

        $roleIds = \App\Models\UserRole::where('user_id', $user_id)->pluck('role_id')->toArray();
        $roles = \App\Models\Role::whereIn('id', $roleIds)->get();

        /**
         *   if user has role `su` then user can access all route :)
         */
        if ($roles->where('slug', 'su')->count()) return true;

        $permittedRouteName = [];

        foreach ($roles as $role) {
            if (trim($role->permissions))
                $permittedRouteName = array_merge($permittedRouteName, json_decode($role->permissions));
        }

        if (in_array($routeName, $permittedRouteName)) return true;

        $personalPermisssions = User::where('id', $user_id)->first()->permissions;
        if ($personalPermisssions) {
            return in_array($routeName, json_decode($personalPermisssions));
        }
        /**
         *   TASKS:
         *   =====
         *   1.add  route  permission that is permitted from $permittedRouteName
         *   2. remove route  permission that is not permitted $permittedRouteName
         */

        return in_array($routeName, $permittedRouteName);

    }

  

}
