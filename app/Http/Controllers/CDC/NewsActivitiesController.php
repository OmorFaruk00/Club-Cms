<?php

namespace App\Http\Controllers\CDC;

use App\Libraries\Slug;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NewsActivitie;
use Illuminate\Validation\Rule;
use App\Http\Requests\Activities;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NewsActivitiesController extends Controller
{
    public function index()
    {
        return view('cdc.newsactivities.index');
    }

    public function create()
    {
        return view('cdc.newsactivities.create');
    }
    public function edit($id)
    {
        return view('cdc.newsactivities.edit', ['id' => $id]);
    }
    public function list($type)
    {
        return NewsActivitie::where('web', $type)->get();
    }
    public function store(Activities $request)
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

    public function findItem($id)
    {
        $NewsActivitie = NewsActivitie::find($id);

        if (!$NewsActivitie) {
            return abort(404);
        }
        return $NewsActivitie;
    }
    public function update(Activities $request, $id)
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
    public function delete($id)
    {
        $NewsActivitie = NewsActivitie::destroy($id);
        if (!$NewsActivitie) {
            return response()->json(['message' => 'NewsActivitie data not found'], 404);
        }
        return response()->json(['message' => 'Delete Successfully'], 200);
    }
}
