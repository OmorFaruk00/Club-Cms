<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;
    // protected $dates = ['deleted_at'];
    protected $fillable = [
        'type',
        'title',
        'slug',
        'description',
        'date',
        'location',
        'image_path',
        'created_by',
    ];
}
