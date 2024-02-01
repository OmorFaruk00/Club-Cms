<?php

namespace App\Http\Controllers\CDC;

use App\Models\Event;
use App\Libraries\Slug;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        return view('cdc.event.index');
    }

    public function create()
    {
        return view('cdc.event.create');
    }
    public function edit($id)
    {
        return view('cdc.event.edit', ['id' => $id]);
    }
    public function list($type)
    {
        return Event::where('type', $type)->get();
    }
    public function store(Request $request)
    {        

        $data = $this->validate($request, [
            'title' => 'required|string|max:1000',
            'description' => 'required|string',
            'date' => 'nullable',
            'type' => 'required',
            'location' => 'nullable',
            'button' => 'nullable',
            'button_link' => 'nullable',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        $files = $request->file('file');
        $extension = $files->getClientOriginalExtension();
        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
        $files->move(public_path('image/event'), $file_name);
        $data['created_by'] = Auth::id() ?? 0;
        $data['image_path'] = env('APP_URL') . "/image/event/{$file_name}";
        Event::create($data);

        $message = "created successfully";
        return response()->json(['message' => $message], 200);
    }

    public function findItem($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return abort(404);
        }
        return $event;
    }
    public function update(Request $request, $id)
    {

        $data = $this->validate($request, [
            'title' => 'required|string|max:1000',
            'description' => 'required|string',
            'date' => 'required',
            'location' => 'required',
            'file' => 'nullable', 
            'button' => 'nullable',
            'button_link' => 'nullable',
        ]);

        $files = $request->file('file');

        $image_url = $request->image_path ?? '';

        if ($files) {
        $extension = $files->getClientOriginalExtension();
        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
        $files->move(public_path('image/event'), $file_name);
        $image_url = env('APP_URL') . "/image/event/{$file_name}";
        $data['image_path'] = $image_url;
        }
        Event::find($id)->update($data);

        $message = "Updated successfully";
        return response()->json(['message' => $message], 200);
    }
    public function delete($id)
    {
        $event = Event::destroy($id);
        if (!$event) {
            return response()->json(['message' => 'Event data not found'], 404);
        }
        return response()->json(['message' => 'Delete successfully'], 200);
    }
}
