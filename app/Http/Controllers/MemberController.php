<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Member::all();
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
    public function store(StoreMemberRequest $request)
    {
        $request->validate([
            'firstname'=> 'required',
            'lastname'=> 'required',
            'password'=> 'required',
            'email'=> 'required', 'email',
            'experience'=> 'nullable',
            'expertise'=> 'nullable',
            'innovations'=> 'nullable',
            'links'=> 'nullable',
            'certs'=> 'nullable',
            'address'=> 'nullable|string',
            'latitude'=> 'nullable|numeric',
            'longitude'=> 'nullable|numeric',
            'profile_picture'=>['nullable']
            
        ]);

        
        if($request->hasFile('profile_picture')){
            $filename=$request->file('profile_picture')->store('photos','public');
        }else{
            $filename=Null;
        }
        $images= new Member();
        
        $images->firstname=$request->firstname;
        $images->lastname=$request->lastname;
        $images->profile_picture=$filename;
        $images->latitude=$request->latitude;
        $images->longitude=$request->longitude;
        $images->address=$request->address;
        $images->certs=$request->certs;
        $images->links=$request->links;
        $images->innovations=$request->innovations;
        $images->expertise=$request->expertise;
        $images->experience=$request->experience;
        $images->email=$request->email;
        $images->password=$request->password;


        $result=$images->save();
        
        if($result){
            return response()->json(['success'=>true, 'data' => $result]);
        }else{
            return response()->json(['success'=>false]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Member::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mem= Member::find($id);
        $mem->update($request->all());
        return $mem;
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Member::destroy($id);
    }

    public function search($name)
    {
        if($name){

        $search= Member::select("id", "firstname", "lastname")
            ->orWhere(DB::raw("concat(firstname, ' ', lastname)"), 'LIKE', "%".$name."%")
            ->get();
        }
        return $search;
    }
}
