<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeam;
use App\Http\Requests\UpdateTeam;
use App\Repository\TeamRepository;

class TeamController extends Controller
{
   
    public $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function list($type)
    {
        return  $this->teamRepository->dataList($type);
    }
    public function store(CreateTeam $request)
    {
        return  $this->teamRepository->dataStore($request);
    }

    public function findItem($id)
    {
        return  $this->teamRepository->dataFind($id);
    }
    public function update(UpdateTeam $request, $id)
    {
        return  $this->teamRepository->dataUpdate($request, $id);
    }
    public function delete($id)
    {
        return  $this->teamRepository->dataDelete($id);
    }
}
