<?php

namespace App\Http\Controllers\YEC;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    public function index()
    {
        return view('yec.slider.index');
    }

    public function create()
    {
        return view('yec.slider.create');
    }
    public function edit($id)
    {
        return view('yec.slider.edit', ['id' => $id]);
    }
    
}
