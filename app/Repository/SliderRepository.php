<?php

namespace App\Repository;

use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class SliderRepository
{
    public function dataList($type)
    {
        return Slider::where('type', $type)->get();
    }

    public function dataStore($request)
    {
        $data = $request->validated();

        $files = $request->file('file');
        $extension = $files->getClientOriginalExtension();
        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
        $files->move(public_path('image/slider'),   $file_name);
        $data['image_path'] = env('APP_URL') . "/image/slider/{$file_name}";
        $data['created_by'] = Auth::id() ?? 0;
        Slider::create($data);

        $message = "created successfully";
        return response()->json(['message' => $message], 200);
    }
    public function dataFind($id)
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return abort(404);
        }
        return $slider;
    }
    public function dataUpdate($request, $id)
    {
        $data = $request->validated();

        $files = $request->file('file');
        if ($files) {
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(public_path('image/slider'), $file_name);
            $data['image_path'] = env('APP_URL') . "/image/slider/{$file_name}";
        }
        Slider::find($id)->update($data);

        $message = "{$request->type} Updated successfully";
        return response()->json(['message' => $message], 200);
    }
    public function dataDelete($id)
    {
        $slider = Slider::destroy($id);
        if (!$slider) {
            return response()->json(['message' => 'Slider data not found'], 404);
        }
        return response()->json(['message' => 'Delete successfully'], 200);
    }
}
