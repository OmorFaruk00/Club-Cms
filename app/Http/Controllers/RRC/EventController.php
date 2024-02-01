<?php

namespace App\Http\Controllers\RRC;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Libraries\Slug;

class EventController extends Controller
{
    public function index()
    {
        return view('rrc.event.index');
    }

    public function create()
    {
        return view('rrc.event.create');
    }
    public function edit($id)
    {
        return view('rrc.event.edit', ['id' => $id]);
    }
    
}
