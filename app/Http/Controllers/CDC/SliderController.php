<?php

namespace App\Http\Controllers\CDC;

use App\Models\Slider;
use App\Libraries\Slug;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $files->move(public_path('image/slider'),   $file_name );       
        $data['image_path'] = env('APP_URL') . "/image/slider/{$file_name}";         
         $data['created_by'] = Auth::id() ?? 0;
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
            'description' => 'nullable',
            'file' => 'nullable'
        ]);

        $files = $request->file('file');
        if($files){
        $extension = $files->getClientOriginalExtension();
        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
        $files->move(public_path('image/slider'), $file_name);
        $data['image_path'] = env('APP_URL') . "/image/slider/{$file_name}";
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
