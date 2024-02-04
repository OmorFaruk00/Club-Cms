<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repository\UserRepository;

class UserController extends Controller
{
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return  $this->userRepository->dataList();
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
        return  $this->userRepository->dataStore($request);
       
    }

    public function userEdit($id)

    {
        $roles = Role::all(['id', 'name']);
        return view('setting.user.edit', ['id' => $id], compact('roles'));
    }
    public function show($id)
    {
        return  $this->userRepository->dataShow($id);
        
    }

    public function update(UpdateUser $request, $id)
    {

        return  $this->userRepository->dataUpdate($request, $id);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'User Deleted Successfully!!',
        ]);
    }
}
