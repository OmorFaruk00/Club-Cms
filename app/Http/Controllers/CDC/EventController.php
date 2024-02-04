<?php

namespace App\Http\Controllers\CDC;

use App\Models\Event;
use App\Libraries\Slug;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        return view('cdc.event.index');
    }

    public function create()
    {
        return view('cdc.event.create');
    }
    public function edit($id)
    {
        return view('cdc.event.edit', ['id' => $id]);
    }
}
