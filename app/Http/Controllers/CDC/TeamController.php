<?php

namespace App\Http\Controllers\CDC;

use App\Models\Team;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        return view('cdc.team.index');
    }

    public function create()
    {
        return view('cdc.team.create');
    }
    public function edit($id)
    {
        return view('cdc.team.edit', ['id' => $id]);
    }
    public function list($type)
    {
        return Team::where('web', $type)->get();
    }
    public function store(Request $request)
    {

        $data = $this->validate($request, [
            'name' => 'required|string|max:1000',
            'web' => 'required',
            'designation' => 'required',
            'profile_link' => 'nullable',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        $files = $request->file('file');
        $extension = $files->getClientOriginalExtension();
        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
        $files->move(public_path('image/team'),   $file_name);
        $data['image_path'] = env('APP_URL') . "/image/team/{$file_name}";
        $data['created_by'] = Auth::id() ?? 0;
        Team::create($data);

        $message = "created successfully";
        return response()->json(['message' => $message], 200);
    }

    public function findItem($id)
    {
        $Team = Team::find($id);

        if (!$Team) {
            return abort(404);
        }
        return $Team;
    }
    public function update(Request $request, $id)
    {

        $data = $this->validate($request, [
            'name' => 'required|string|max:1000',
            'designation' => 'required',
            'profile_link' => 'nullable',
            'file' => 'nullable'
        ]);

        $files = $request->file('file');
        if ($files) {
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(public_path('image/team'), $file_name);
            $data['image_path'] = env('APP_URL') . "/image/team/{$file_name}";
        }
        Team::find($id)->update($data);

        $message = "{$request->type} Updated successfully";
        return response()->json(['message' => $message], 200);
    }
    public function delete($id)
    {
        $Team = Team::destroy($id);
        if (!$Team) {
            return response()->json(['message' => 'Team data not found'], 404);
        }
        return response()->json(['message' => 'Delete successfully'], 200);
    }
}
