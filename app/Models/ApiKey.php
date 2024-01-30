<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiKey extends Model
{
    protected $table = "apiKeys";

    use SoftDeletes;
	
    protected $fillable = [
        'employee_id',
        'apiKey',
        'lastAccessTime',
    ];

    public function relEmployee()
    {
        return $this->belongsTo(user::class, 'user_id', 'id');
    }
}
