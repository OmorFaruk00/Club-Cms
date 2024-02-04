<?php

namespace App\Http\Controllers\CDC;

use App\Models\Team;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        return view('cdc.team.index');
    }

    public function create()
    {
        return view('cdc.team.create');
    }
    public function edit($id)
    {
        return view('cdc.team.edit', ['id' => $id]);
    }
    
    
}
