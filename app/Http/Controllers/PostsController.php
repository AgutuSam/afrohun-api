<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Post;
use App\Models\Posts;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Database\Factories\PostsFactory;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Loader\Configurator\Traits\HostTrait;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HttpResponses;
    public function index()
    {
        
        $posts = Post::all();
        return $posts;


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
        $this->validate($request, array(
            'description' => 'required',
            'content' => 'required',
            'user_image' => 'required',
          ));
         
          if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        
          $post = new Post();
          $mem= User::find(Auth::id());
        
          $post->user_id = $mem->id;
        //   $post->user_image = $mem->profile_picture;
        $filename=$request->file('user_image')->store('posts','public');
          $post->content = $request->content;
          $post->user_image = $filename;
          $post->description = $request->description;
          $post->save();

          return $this->success([
            'data' => $post,
            'message'=>'posts created'
        ]);
    
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        $post= Post::find($id);
        return $post;
        
        
    }
    public function showUser(){

        $user = User::find(Auth::id());
        $post= Post::where('user_id', $user->id)->get();
        return $post;

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
    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'description' => 'required',
            'content' => 'required',
          ));
        $mem= User::find(Auth::id());

        $fileName = time().'_'.$request->file->getClientOriginalName();
            // $filePath = $request->file('profile_picture')->store('photos', $fileName, 'public');
        $filename=$request->file('profile_picture')->store('photos',$fileName, 'public');


        $post=Post::find($id);
        $post->user_id = $mem->id;
        $post->user_image = $mem->profile_picture;
        $post->content = $request->content;
        $post->description = $request->description;
        $post->update();
        return $post;
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mem=  User::find(Auth::id());
        if (!$mem){
        return response()->json(['error' => 'Member not found'], 404);
        } else{return Post::destroy($id);}
    }

}
