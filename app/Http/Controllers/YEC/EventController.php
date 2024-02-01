<?php

namespace App\Http\Controllers\YEC;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function index()
    {
        return view('yec.event.index');
    }

    public function create()
    {
        return view('yec.event.create');
    }
    public function edit($id)
    {
        return view('yec.event.edit', ['id' => $id]);
    }
    
}
