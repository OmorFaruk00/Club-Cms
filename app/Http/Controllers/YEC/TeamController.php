<?php

namespace App\Http\Controllers\YEC;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function index()
    {
        return view('yec.team.index');
    }

    public function create()
    {
        return view('yec.team.create');
    }
    public function edit($id)
    {
        return view('yec.team.edit', ['id' => $id]);
    }
    
}
