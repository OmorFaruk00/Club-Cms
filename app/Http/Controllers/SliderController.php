<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSlider;
use App\Http\Requests\UpdateSlider;
use App\Repository\SliderRepository;

class SliderController extends Controller
{
    public $sliderRepository;

    public function __construct(SliderRepository $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;
    }

    public function list($type)
    {
        return  $this->sliderRepository->dataList($type);
    }
    public function store(CreateSlider $request)
    {
        return  $this->sliderRepository->dataStore($request);
    }

    public function findItem($id)
    {
        return  $this->sliderRepository->dataFind($id);
    }
    public function update(UpdateSlider $request, $id)
    {
        return  $this->sliderRepository->dataUpdate($request, $id);
    }
    public function delete($id)
    {
        return  $this->sliderRepository->dataDelete($id);
    }
}
