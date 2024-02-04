<?php

namespace App\Repository;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class EventRepository
{
    public function dataList($type)
    {
        return Event::where('type', $type)->get();
    }

    public function dataStore($request)
    {
        $data = $request->validated();

        $files = $request->file('file');
        $extension = $files->getClientOriginalExtension();
        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
        $files->move(public_path('image/event'), $file_name);
        $data['created_by'] = Auth::id() ?? 0;
        $data['image_path'] = env('APP_URL') . "/image/event/{$file_name}";
        Event::create($data);

        $message = "Created Successfully";
        return response()->json(['message' => $message], 200);
    }
    public function dataFind($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return abort(404);
        }
        return $event;
    }
    public function dataUpdate($request, $id)
    {
        $data = $request->validated();

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

        $message = "Updated Successfully";
        return response()->json(['message' => $message], 200);
    }
    public function dataDelete($id)
    {
        $event = Event::destroy($id);
        if (!$event) {
            return response()->json(['message' => 'Event data not found'], 404);
        }
        return response()->json(['message' => 'Delete Successfully'], 200);
    }
}
