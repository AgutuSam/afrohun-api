<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Member;
use App\Traits\HttpResponses;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request){
        $request->validated($request->all());

        if(!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }
        $user = User::where('email', $request->email)->first();
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of' .$user->name)->plainTextToken
        ]);

    }
    public function register(StoreUserRequest $request){
        $request->validated($request->all());
        
        $user = user::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($user));
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of' .$user->name)->plainTextToken
        ]);
    }
    public function logout(Request $request){
        $request= auth()->user()->tokens()->delete();
           If ($request){ return $this->success([
                'message'=>'Logged out'
            ]);}
        // Member::logout();
        // return response()->json(['message' => 'Logged out successfully']);
    }
}
