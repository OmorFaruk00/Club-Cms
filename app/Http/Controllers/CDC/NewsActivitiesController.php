<?php

namespace App\Http\Controllers\CDC;

use App\Libraries\Slug;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NewsActivitie;
use Illuminate\Validation\Rule;
use App\Http\Requests\Activities;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NewsActivitiesController extends Controller
{
    public function index()
    {
        return view('cdc.newsactivities.index');
    }

    public function create()
    {
        return view('cdc.newsactivities.create');
    }
    public function edit($id)
    {
        return view('cdc.newsactivities.edit', ['id' => $id]);
    }
   
    
}
