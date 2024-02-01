<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CacheClearController extends Controller
{
    public function cacheClear(){
        return view('setting.cache');
    }
}
