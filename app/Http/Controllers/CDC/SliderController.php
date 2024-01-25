<?php

namespace App\Http\Controllers\CDC;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Libraries\Slug;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    public function index()
    {
        return view('cdc.slider.index');
    }

    public function create()
    {
        return view('cdc.slider.create');
    }
    public function edit($id)
    {
        return view('cdc.slider.edit', ['id' => $id]);
    }
    public function list($type)
    {
        return Slider::where('type', $type)->get();
    }
    public function store(Request $request)
    {

        $data = $this->validate($request, [
            'title' => 'required|string|max:1000',
            'type' => 'required',
            'description' => 'nullable',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        $files = $request->file('file');             
        $extension = $files->getClientOriginalExtension();
        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
        $files->move(storage_path('images/slider'), $file_name);        
        $data['image_path'] = env('APP_URL') . "/images/slider/{$file_name}";         
         $data['created_by'] = $request->auth->id ?? 0;
        Slider::create($data);

        $message = "created successfully";
        return response()->json(['message' => $message], 200);
    }

    public function findItem($id)
    {
        $Slider = Slider::find($id);

        if (!$Slider) {
            return abort(404);
        }
        return $Slider;
    }
    public function update(Request $request, $id)
    {

        $data = $this->validate($request, [
            'title' => 'required|string|max:1000',
            'description' => 'required|string',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $files = $request->file('file');
        if($files){
        $extension = $files->getClientOriginalExtension();
        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
        $files->move(storage_path('images/slider'), $file_name);
        $data['image_path'] = env('APP_URL') . "/images/slider/{$file_name}";
        }
        Slider::find($id)->update($data);

        $message = "{$request->type} Updated successfully";
        return response()->json(['message' => $message], 200);
    }
    public function delete($id)
    {
        $Slider = Slider::destroy($id);
        if (!$Slider) {
            return response()->json(['message' => 'Slider data not found'], 404);
        }
        return response()->json(['message' => 'Delete successfully'], 200);
    }
}
