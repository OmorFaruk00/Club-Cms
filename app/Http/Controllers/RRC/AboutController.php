<?php

namespace App\Http\Controllers\RRC;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AboutController extends Controller
{
    public function index()
    {
        return view('rrc.about.index');
    }

    public function create()
    {
        return view('rrc.about.create');
    }
    public function edit($id)
    {
        return view('rrc.about.edit', ['id' => $id]);
    }
   
}
