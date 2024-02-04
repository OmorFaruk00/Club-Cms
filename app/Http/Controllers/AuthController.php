<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function authenticate()
    {

        $user = User::where('email', $this->request->input('email'))
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Email does not exist.'], 400);
        }

        if ($user->activestatus == '0') {
            return response()->json(['error' => 'You are Released!'], 400);
        }

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

            $token_string = $user->id . '.0.0.0.0.' . $user->password . '.0.0.0.0.' . $user->office_email . uniqid() . time();

            $token = encrypt($token_string);

            $presentTime = time();
            $device = substr($this->request->header('User-Agent'), 0, 7) ?? '';

            $apiKey = new ApiKey();
            $apiKey->user_id = $user->id;
            $apiKey->apiKey = $token;
            $apiKey->lastAccessTime = $presentTime;
            $apiKey->created_by = $user->id;
            $apiKey->updated_by = $user->id;
            $apiKey->device_agent = $device ?? '';
            $apiKey->save();

            Session::put('token', $token);
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => "Password Doesn't Match"], 401);
        }
    }

    public function logout()
    {

        // Additional logout logic, if any
        Session::flush();
        // Redirect to the login page
        return redirect()->route('home');
    }


    public function changePassword(){
        return view('setting.change-password');
    }
    public function changePasswordStore(){
        $this->validate($this->request, [ 
                'old_password'=>'required',             
                'password' => [
                    'required','confirmed',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-])/',
                ],
                
    
            ]);        

        if (Auth::check() && Hash::check(request('old_password'), Auth::user()->password)) {
          
            User::find(Auth::id())->update(['password'=>bcrypt($this->request->password)]);

            $message = "Password Change Successfully!!";
        return response()->json(['message' => $message], 200);
        } else {
            return response()->json(['error' => "Old Password Doesn't Match"], 400);
        }
    }
}
