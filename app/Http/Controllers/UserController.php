<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return User::find($id);
    }


    public function update(StoreMemberRequest $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $user = User::find(Auth::id());
        $request->validate([
            // 'name' => 'string',
            // 'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'firstname'=> 'nullable',
            'lastname'=> 'nullable',
            'institution'=> 'nullable',
            'school'=> 'nullable',
            'faculty'=> 'nullable',
            'course'=>'nullable',
            'speciality'=> 'nullable',
            'organisation'=> 'nullable',
            'title'=> 'nullable',
            'age'=> 'numeric',
            'gender'=> 'nullable',
            'location'=> 'nullable',
            'grad_year'=> 'nullable',
            'bio'=>'nullable',
            'interests'=>'nullable',
            'post_url'=> 'nullable',
            'profile_picture'=> 'nullable',
        ]);

        // if ($request->hasFile('profile_picture')) {

        //     $fileName = time().'_'.$request->file->getClientOriginalName();
        //     $filePath = $request->file('profile_picture')->store('photos', $fileName, 'public');
        // //     $profilePhoto = $request->file('profile_picture');
        // // $profilePhotoPath = $profilePhoto->store('photos', 'public');

        // // // Delete the previous profile photo if it exists
        // if ($user->profile_picture) {
        //     Storage::disk('public')->delete($user->profile_picture);
        // }

        // // $data['profile_picture'] = $profilePhotoPath;
        // }else{
        //     $fileName=Null;
        // }


        $postUrl = url("/post");

        $user->post_url = $postUrl;
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('firstname')) {
            $user->firstname=$request->firstname;
        }
        if ($request->has('lastname')) {
            $user->lastname=$request->lastname;
        }
        if($request->hasFile('user_image')){
            $filename=$request->file('user_image')->store('profiles','public');
            $user->profile_picture= $filename;
        }else{
            $filename=Null;
        }

        if ($request->has('institution')) {
            $user->institution=$request->institution;
        }

        if ($request->has('age')) {
            $user->age=$request->age;
        }

        if ($request->has('gender')) {
            $user->gender=$request->gender;
        }

        if ($request->has('location')) {
            $user->location=$request->location;
        }

        if ($request->has('faculty')) {
            $user->faculty=$request->faculty;
        }

        if ($request->has('grad_year')) {
            $user->grad_year=$request->grad_year;
        }

        if ($request->has('course')) {
            $user->course=$request->course;
        }

        if ($request->has('bio')) {
            $user->bio=$request->bio;
        }

        if ($request->has('interests')) {
            $user->interests=$request->interests;
        }



        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }


        $user->update();

        return $user;


    }

    public function updateAdmin(StoreMemberRequest $request, $id)
    {


        $user = User::find($id);
        if(Auth::user()->role === 'SuperAdmin'){
        $request->validate([
            'role' => 'required',


            // 'name' => 'required|string',
            // 'email' => 'required|email|unique:users,email,',

        ]);


        $user->role =$request->role;
        // $user->approved=$request->approved;


        $user->update();

        return $user;
    }

    }


    public function destroy()
    {
        return User::destroy(Auth::id());
    }

    public function search($name)
    {
        if($name){

        $search= User::select("id", "name", "lastname")
            ->orWhere(DB::raw("concat(name, ' ', lastname)"), 'LIKE', "%".$name."%")
            ->get();
        }
        return $search;
    }

}
