<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAbout;
use App\Http\Requests\UpdateAbout;
use App\Repository\AboutRepository;

class AboutController extends Controller
{

    public $aboutRepository;

    public function __construct(AboutRepository $aboutRepository)
    {
        $this->aboutRepository = $aboutRepository;
    }

    public function list($type)
    {
        return  $this->aboutRepository->dataList($type);
    }
    public function store(CreateAbout $request)
    {
        return  $this->aboutRepository->dataStore($request);      
    }

    public function show($id)
    {
        return  $this->aboutRepository->dataFind($id);
    }
    public function update(UpdateAbout $request, $id)
    {
        return  $this->aboutRepository->dataUpdate($request, $id);      
    }
    public function delete($id)
    {
        return  $this->aboutRepository->dataDelete($id);        
    }
}
