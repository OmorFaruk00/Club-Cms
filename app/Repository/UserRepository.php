<?php

namespace App\Repository;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;


class UserRepository
{
    public function dataList()
    {
        $users =  User::with('role', 'createtedBy')->get();
        if($users){
            return  UserResource::collection($users);
        }else{
            return abort(404);
        }
    }

    public function dataStore($request)
    {
        $data = $request->validated();

        $files = $request->file('file');

        $extension = $files->getClientOriginalExtension();
        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
        $files->move(public_path('image/user'), $file_name);
        $data['image'] = env('APP_URL') . "/image/user/{$file_name}";


        $data['password'] = bcrypt($request->password);
        $data['created_by'] = Auth::id() ?? 0;
        $user = User::create($data);
        $role = [
            'role_id' => $request->role_id,
            'user_id' => $user->id,
            'created_by' => Auth::id() ?? 0,
        ];
        UserRole::create($role);
        $message = "User Created Successfully!!";
        return response()->json(['message' => $message], 200);
    }
    public function dataShow($id)
    {
        $user = User::find($id);

        if (!$user) {
            return abort(404);
        }
        return $user;
    }
    public function dataUpdate($request, $id)
    {
        $data =$request->validated();

        $files = $request->file('file');
        if ($files) {
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(public_path('image/user'), $file_name);
            $data['image'] = env('APP_URL') . "/image/user/{$file_name}";
        }

        User::find($id)->update($data);
        $message = "User Updated Successfully!!";
        return response()->json(['message' => $message], 200);
    }
    public function dataDelete($id)
    {
        $user = User::destroy($id);
        if (!$user) {
            return response()->json(['message' => 'User data not found'], 404);
        }
        return response()->json(['message' => 'Delete successfully'], 200);
    }
}
