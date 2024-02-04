<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Requests\CreateActivities;
use App\Http\Requests\UpdateActivities;
use App\Repository\ActivityRepository;

class NewsActivitiesController extends Controller
{
   
    public $activityRepository;

    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    public function list($type)
    {
        return  $this->activityRepository->dataList($type);
    }
    public function store(CreateActivities $request)
    {
        return  $this->activityRepository->dataStore($request);
    }

    public function findItem($id)
    {
        return  $this->activityRepository->dataFind($id);
    }
    public function update(UpdateActivities $request, $id)
    {
        return  $this->activityRepository->dataUpdate($request, $id);
    }
    public function delete($id)
    {
        return  $this->activityRepository->dataDelete($id);
    }
}
