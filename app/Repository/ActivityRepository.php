<?php

namespace App\Repository;

use Illuminate\Support\Str;
use App\Models\NewsActivitie;
use Illuminate\Support\Facades\Auth;


class ActivityRepository
{
    public function dataList($type)
    {
        return NewsActivitie::where('web', $type)->get();
    }

    public function dataStore($request)
    {
        $data = $request->validated();
        $files = $request->file('file');
        $extension = $files->getClientOriginalExtension();
        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
        $files->move(public_path('image/newsActivitie'), $file_name);
        $data['created_by'] = Auth::id() ?? 0;
        $data['image_path'] = env('APP_URL') . "/image/newsActivitie/{$file_name}";
        NewsActivitie::create($data);

        $message = "Created Successfully";
        return response()->json(['message' => $message], 200);
    }
    public function dataFind($id)
    {
        $activity = NewsActivitie::find($id);

        if (!$activity) {
            return abort(404);
        }
        return $activity;
    }
    public function dataUpdate($request, $id)
    {
        $data = $request->validated();
        $files = $request->file('file');

        if ($files) {
            $files = $request->file('file');
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(public_path('image/activities'), $file_name);
            $image_url = env('APP_URL') . "/image/activities/{$file_name}";
            $data['image_path'] = $image_url;
        }
        NewsActivitie::find($id)->update($data);

        $message = "Updated Successfully";
        return response()->json(['message' => $message], 200);
    }
    public function dataDelete($id)
    {
        $activity = NewsActivitie::destroy($id);
        if (!$activity) {
            return response()->json(['message' => 'activity data not found'], 404);
        }
        return response()->json(['message' => 'Delete successfully'], 200);
    }
}
