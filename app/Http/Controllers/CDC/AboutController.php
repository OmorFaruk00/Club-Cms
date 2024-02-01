<?php

namespace App\Http\Controllers\CDC;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AboutController extends Controller
{
    public function index()
    {
        return view('cdc.about.index');
    }

    public function create()
    {
        return view('cdc.about.create');
    }
    public function edit($id)
    {
        return view('cdc.about.edit', ['id' => $id]);
    }
    public function list($type)
    {
        return About::where('type', $type)->get();
    }
    public function store(Request $request)
    {

        $data = $this->validate($request, [
            'title' => 'required|string|max:1000',
            'type' => 'required',
            'description' => 'required',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        $files = $request->file('file');             
        $extension = $files->getClientOriginalExtension();
        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
        $files->move(public_path('image/about'),   $file_name );       
        $data['image_path'] = env('APP_URL') . "/image/about/{$file_name}";         
         $data['created_by'] = Auth::id() ?? 0;
        About::create($data);

        $message = "Created Successfully";
        return response()->json(['message' => $message], 200);
    }

    public function show($id)
    {
        $About = About::find($id);

        if (!$About) {
            return abort(404);
        }
        return $About;
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
        $files->move(public_path('image/about'), $file_name);
        $data['image_path'] = env('APP_URL') . "/image/about/{$file_name}";
        }
        About::find($id)->update($data);

        $message = "{$request->type} Updated Successfully";
        return response()->json(['message' => $message], 200);
    }
    public function delete($id)
    {
        $About = About::destroy($id);
        if (!$About) {
            return response()->json(['message' => 'About data not found'], 404);
        }
        return response()->json(['message' => 'Delete successfully'], 200);
    }
}
