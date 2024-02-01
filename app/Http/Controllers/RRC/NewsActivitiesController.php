<?php

namespace App\Http\Controllers\RRC;

use App\Models\NewsActivitie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Libraries\Slug;
use Illuminate\Validation\Rule;
use App\Http\Requests\Activities;

class NewsActivitiesController extends Controller
{
    public function index()
    {
        return view('rrc.newsactivities.index');
    }

    public function create()
    {
        return view('rrc.newsactivities.create');
    }
    public function edit($id)
    {
        return view('rrc.newsactivities.edit', ['id' => $id]);
    }
    
}
