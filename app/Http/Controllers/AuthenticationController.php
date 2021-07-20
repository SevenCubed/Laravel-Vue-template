<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



//This could probably be inside a User Controller, but I'm opting to keep it outside for now, to keep the learning process somewhat organized.
//Users are used for a lot more in this project than just logging in, after all
class AuthenticationController extends Controller
{
    public function register(Request $request){
        //TODO: Custom Request Validation
        $request->validate([
            'name'=> ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6']
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(60),
        ]);
    }
    
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials)){
            // $request->session()->regenerate();
            return response()->json(Auth::user(), 200); //200 = success
        }
        //TODO Probably fold this into the custom validation?
        throw ValidationException::withMessages([
            'email' =>['Incorrect credentials']
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
    }

    public function activeUser(Request $request){
        $user = User::firstWhere('api_token', $request->token);
        return $user;
    }
}
