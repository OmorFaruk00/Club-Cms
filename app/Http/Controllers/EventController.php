<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEvent;
use App\Http\Requests\UpdateEvent;
use App\Repository\EventRepository;

class EventController extends Controller
{

    public $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function list($type)
    {
        return $this->eventRepository->dataList($type);
    }
    public function store(CreateEvent $request)
    {
        return $this->eventRepository->dataStore($request);
    }

    public function findItem($id)
    {
        return $this->eventRepository->dataFind($id);
    }
    public function update(UpdateEvent $request, $id)
    {
        return $this->eventRepository->dataUpdate($request, $id);
    }
    public function delete($id)
    {
        return $this->eventRepository->dataDelete($id);
    }
}
