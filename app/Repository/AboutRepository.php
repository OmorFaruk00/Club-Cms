<?php

namespace App\Repository;

use App\Models\About;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AboutRepository
{
    public function dataList($type)
    {
        return About::where('type', $type)->get();
    }

    public function dataStore($request)
    {
        $data = $request->validated();

        $files = $request->file('file');
        $extension = $files->getClientOriginalExtension();
        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
        $files->move(public_path('image/about'), $file_name);
        $data['image_path'] = env('APP_URL') . "/image/about/{$file_name}";
        $data['created_by'] = Auth::id() ?? 0;
        About::create($data);

        $message = "Created Successfully";
        return response()->json(['message' => $message], 200);
    }
    public function dataFind($id)
    {
        $about = About::find($id);

        if (!$about) {
            return abort(404);
        }
        return $about;
    }
    public function dataUpdate($request, $id)
    {
        $data = $request->validated();

        $files = $request->file('file');
        if ($files) {
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(public_path('image/about'), $file_name);
            $data['image_path'] = env('APP_URL') . "/image/about/{$file_name}";
        }
        About::find($id)->update($data);

        $message = "{$request->type} Updated Successfully";
        return response()->json(['message' => $message], 200);
    }
    public function dataDelete($id)
    {
        $about = About::destroy($id);
        if (!$about) {
            return response()->json(['message' => 'About data not found'], 404);
        }
        return response()->json(['message' => 'Delete successfully'], 200);
    }
}
