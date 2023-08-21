<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use HttpResponses;
    public function register(StoreUserRequest $request){

        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type'=> $request->type,
            'institution'=> $request->institution,
            'school'=> $request->school,
            'faculty'=> $request->faculty,
            'course'=>$request->course,
            'speciality'=> $request->speciality,
            'organisation'=> $request->organisation,
            'title'=> $request->title,
            'availability'=> $request->availability,
            'approved' => $request->type === 'Organisation' ? 0 : 1,
        ]);

        if($user->id === 1){
            $user->role='SuperAdmin';
            $user->save();

        }



        event(new Registered($user));

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('basic' .$user->name)->plainTextToken

        ]);
    }
}
