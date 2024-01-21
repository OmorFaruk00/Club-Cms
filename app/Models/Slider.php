<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "sliders";
    protected $fillable = [        
        'title',       
        'description', 
        'type',  
        'image_path',
        'created_by',
    ];
}
