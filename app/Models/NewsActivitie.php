<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsActivitie extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "newsActivities";
    protected $fillable = [        
        'type',  
        'title',       
        'description', 
        'web',  
        'image_path',
        'created_by',
    ];
}
