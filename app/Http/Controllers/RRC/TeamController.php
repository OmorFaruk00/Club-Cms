<?php

namespace App\Http\Controllers\RRC;

use App\Models\Team;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        return view('rrc.team.index');
    }

    public function create()
    {
        return view('rrc.team.create');
    }
    public function edit($id)
    {
        return view('rrc.team.edit', ['id' => $id]);
    }
    
}
