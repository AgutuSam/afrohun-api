<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Models\Group;
use App\Models\Groupy;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GroupChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Groupy::all();
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
        $request->validate([
            'name'=> 'required',
            'user_id'=>'nullable',
            
        ]);


        $user=User::find(Auth::id());

        $group= new Groupy();
        
        $group->name=$request->name;
        $group->created_by=$user->id;


        $result=$group->save();
        
        if($result){
            return response()->json(['success'=>true, 'data' => $group]);
        }else{
            return response()->json(['success'=>false]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Groupy::find($id);
    }

    public function showGroupUsers(string $id)
    {
        $group= Groupy::find($id);

        $user=User::where('id', $group->user_id)->get();
        

        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
   
     public function addUser(Request $request, string $id)
     {
         $request->validate([
             'user_id' => 'required|array',
             'user_id.*' => 'exists:users,id',
         ]);
         
         $group = Groupy::findOrFail($id);
         $userIds = $request->input('user_id');
     
         foreach ($userIds as $userId) {
            echo "\nUserId : ".$userId;
             $user = User::findOrFail($userId);
            //  $group->users()->attach($user);
            $group->user_id= $userId;
            
         }
         $group->save();
         
         return $group;
     }
     
     // public function addUser(Request $request, string $id)
    // {
    //     $request->validate([
    //         'user_id'=>'nullable|exists:users,id',
            
    //     ]);
        
    //     $group=Groupy::findorfail($id);
    //     echo "Group name".$group->name;
    //     foreach($request->input('user_id') as $user){

    //         $group->user_id=$user;
            
        
    //     }
    //     $group->save();
    //     // $user=$request->input('user_id');
    //     // $group->user_id=$user;
        
    //     return $group;
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mem= User::find($id);
        $mem->update($request->all());
        return $mem;
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return User::destroy($id);
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
