<?php

namespace App\Http\Controllers\RRC;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Libraries\Slug;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    public function index()
    {
        return view('rrc.slider.index');
    }

    public function create()
    {
        return view('rrc.slider.create');
    }
    public function edit($id)
    {
        return view('rrc.slider.edit', ['id' => $id]);
    }
    
}
