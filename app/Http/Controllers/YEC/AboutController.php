<?php

namespace App\Http\Controllers\YEC;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        return view('yec.about.index');
    }

    public function create()
    {
        return view('yec.about.create');
    }
    public function edit($id)
    {
        return view('yec.about.edit', ['id' => $id]);
    }
   
}
