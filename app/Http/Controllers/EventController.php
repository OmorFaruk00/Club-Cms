<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Libraries\Slug;

class EventController extends Controller
{
    public function index(){
        return view('cdc.event.index');
    }
    public function list(){
        return Event::get();
    }
    public function create(){
        return view('cdc.event.create');
    }
    public function store(Request $request){

        $data = $this->validate($request, [
            'title' => 'required|string|max:1000',
            'description' => 'required|string',
            'date' => 'required',
            'location' => 'required',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);
       
           $files = $request->file('file');
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(storage_path('images/cdc/event'), $file_name);
            $data['type'] = 'cdc';
            $data['created_by'] = $request->auth->id ?? 0;
            $data['image_path'] = env('APP_URL') . "/images/cdc/event/{$file_name}";
            Event::create($data);
           
            $message = "{$request->type} created successfully";
           return response()->json(['message' => $message], 200);
    }
    public function edit($id){
        return $id;
     return view('cdc.event.edit',['id' => $id]);
    }
    public function delete($id){
        $newsActivities = Event::destroy($id);
        if (!$newsActivities) {
            return response()->json(['message' => 'Event data not found'], 404);
        }
        return response()->json(['message' => 'Delete successfully'], 200);
    }
}
