<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Member;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $like = Like::all();
        return $like;
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
    public function store(Request $request, $mem_id, $post_id)
    {
        $validatedData = $request->validate([
            
        ]);

        $post=Post::find($post_id);
        $mem=Member::find($mem_id);

        if(!$mem || !$post){
            return response()->json(['error' => 'post not found'], 404);
        }else{

        $like = new Like();
        $no= Like::all()->count();
        $active=$no+1;
        
        $like->active = $active;
        $like->post_id = $post_id;
        $like->user_id = $mem_id;
        $like->save();

        return response()->json([
            'message' => 'Like is added',
            'data' => $like
        ]);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $mem_id, $post_id, $id)
    {
        $post=Post::find($post_id);
        $mem=Member::find($mem_id);

        if(!$mem || !$post){
            return response()->json(['error' => 'Member not found'], 404);
        }else{
            return Like::find($id);
        }
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
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $mem_id, $post_id, $id)
    {
        $post=Post::find($post_id);
        $mem=Member::find($mem_id);

        if(!$mem || !$post){
            return response()->json(['error' => 'Member not found'], 404);
        }else{
        return Like::destroy($id);
        }
    }
}
