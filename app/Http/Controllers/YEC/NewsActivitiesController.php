<?php

namespace App\Http\Controllers\YEC;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsActivitiesController extends Controller
{
    public function index()
    {
        return view('yec.newsactivities.index');
    }

    public function create()
    {
        return view('yec.newsactivities.create');
    }
    public function edit($id)
    {
        return view('yec.newsactivities.edit', ['id' => $id]);
    }
    
}
