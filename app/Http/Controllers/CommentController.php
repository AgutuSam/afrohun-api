<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Member;
use App\Models\Post;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;

class CommentController extends Controller
{
    use HttpResponses;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return $comments;

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
            'content' => 'required',
        ]);

        $post=Post::find($post_id);
        $mem=Member::find($mem_id);

        if(!$mem || !$post){
            return response()->json(['error' => 'Member not found'], 404);
        }else{

        $comment = new Comment;
        
        $comment->content = $request->content;
        $comment->post_id = $post_id;
        $comment->user_id = $mem_id;
        $comment->save();

        return response()->json([
            'message' => 'Comment created successfully',
            'data' => $comment
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
            return Comment::find($id);
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
    public function update(Request $request, string $mem_id, $post_id, $id)
    {
        $post=Post::find($post_id);
        $mem=Member::find($mem_id);

        if(!$mem || !$post){
            return response()->json(['error' => 'Member not found'], 404);
        }else{
        $comment=Comment::find($id);
        $comment->update($request->all());
        return $comment;
        }
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
        return Comment::destroy($id);
        }
    }

}
