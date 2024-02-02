<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;


class UserController extends Controller
{

    public function index()
    {
        $users =  User::with('role', 'createtedBy')->get();
        return  UserResource::collection($users);
    }

    public function user()
    {
        return view('setting.user.index');
    }
    public function create()
    {
        $roles = Role::all(['id', 'name']);
        return view('setting.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string|max:1000',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-])/',
            ],
            'role_id' => 'required',
            'phone' => 'required',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB

        ]);

        $files = $request->file('file');

        $extension = $files->getClientOriginalExtension();
        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
        $files->move(public_path('image/user'), $file_name);
        $data['image'] = env('APP_URL') . "/image/user/{$file_name}";


        $data['password'] = bcrypt($request->password);
        $data['created_by'] = Auth::id() ?? 0;
        // return $data;
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

    public function userEdit($id)

    {
        $roles = Role::all(['id', 'name']);
        return view('setting.user.edit', ['id' => $id], compact('roles'));
    }
    public function show($id)
    {
        return User::find($id);
    }

    public function update(Request $request, $id)
    {

        $data = $this->validate($request, [
            'name' => 'required|string|max:1000',
            'email' => 'required|email|unique:users,email,'. $id,
            'role_id' => 'required',
            'phone' => 'required',

        ]);

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

    public function destroy(User $User)
    {
        $User->delete();
        return response()->json([
            'message' => 'User Deleted Successfully!!',
        ]);
    }
}
