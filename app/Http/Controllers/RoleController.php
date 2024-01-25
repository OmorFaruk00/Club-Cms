<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
         return Role::all(['id','name']);

    }
    public function create()
    {
         return view('setting.role.index');

    }

  
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string|max:1000',
           
        ]);
        $data['slug'] = $request->name;
        $data['created_by'] = $request->auth->id ?? 0;
        $Role = Role::create($data);
        $message = "Role Created Successfully!!";
        return response()->json(['message' => $message], 200); ;
    }

    public function edit($id){
        return Role::find($id);
    }

  

  
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required|string|max:1000',
           
        ]);
        Role::find($id)->update($data);
        $message = "Role Updated Successfully!!";
        return response()->json(['message' => $message], 200);       
    }


    public function destroy(Role $Role)
    {
        $Role->delete();
        return response()->json([
            'message'=>'Role Deleted Successfully!!'
        ]);
    }
}
