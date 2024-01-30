<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{

    use SoftDeletes;

    protected $table = "user_roles";

    use SoftDeletes;

    protected $fillable = [
        'role_id',
        'user_id',
        'created_by',
    ];

    public function relRole()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function reluser()
    {
        return $this->belongsTo('App\user', 'user_id', 'id');
    }

    public function relCreatedBy()
    {
        return $this->belongsTo('App\user', 'created_by', 'id');
    }

    public function relDeletedBy()
    {
        return $this->belongsTo('App\user', 'deleted_by', 'id');
    }

    public static function isAdmin($user_id)
    {
        $role = self::with('relRole')->where('userid', $user_id)->first();

        if( $role->relRole->slug=='admin' || $role->relRole->slug == 'su')
        {
            return true;
        }

        else return false;
    }
}
