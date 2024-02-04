<?php

namespace App\Repository;

use App\Models\Team;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class TeamRepository
{
    public function dataList($type)
    {
        return Team::where('web', $type)->get();
    }

    public function dataStore($request)
    {
        $data = $request->validated();

        $files = $request->file('file');
        $extension = $files->getClientOriginalExtension();
        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
        $files->move(public_path('image/team'),   $file_name);
        $data['image_path'] = env('APP_URL') . "/image/team/{$file_name}";
        $data['created_by'] = Auth::id() ?? 0;
        Team::create($data);

        $message = "Created Successfully";
        return response()->json(['message' => $message], 200);
    }
    public function dataFind($id)
    {
        $team = Team::find($id);

        if (!$team) {
            return abort(404);
        }
        return $team;
    }
    public function dataUpdate($request, $id)
    {
        $data = $request->validated();

        $files = $request->file('file');
        if ($files) {
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(public_path('image/team'), $file_name);
            $data['image_path'] = env('APP_URL') . "/image/team/{$file_name}";
        }
        Team::find($id)->update($data);

        $message = "{$request->type} Updated Successfully";
        return response()->json(['message' => $message], 200);
    }
    public function dataDelete($id)
    {
        $team = Team::destroy($id);
        if (!$team) {
            return response()->json(['message' => 'Team data not found'], 404);
        }
        return response()->json(['message' => 'Delete Successfully'], 200);
    }
}
