<?php

namespace App\Http\Controllers\RRC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index(){
        return view('rrc.slider.index');
    }
   
    public function create(){
        return view('rrc.slider.create');
    }
    public function edit($id){
        return view('rrc.slider.edit',['id' => $id]);
       }
}
