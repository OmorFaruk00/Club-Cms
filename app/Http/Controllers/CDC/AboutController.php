<?php

namespace App\Http\Controllers\CDC;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AboutController extends Controller
{
    public function index()
    {
        return view('cdc.about.index');
    }

    public function create()
    {
        return view('cdc.about.create');
    }
    public function edit($id)
    {
        return view('cdc.about.edit', ['id' => $id]);
    }
    
}
