<?php

namespace App\Http\Controllers\CDC;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Libraries\Slug;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    public function index()
    {
        return view('cdc.slider.index');
    }

    public function create()
    {
        return view('cdc.slider.create');
    }
    public function edit($id)
    {
        return view('cdc.slider.edit', ['id' => $id]);
    }
    
}
