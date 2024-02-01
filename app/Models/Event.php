<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'type',
        'title',
        'description',
        'date',
        'location',
        'button',
        'button_link',
        'image_path',
        'created_by',
    ];
}
