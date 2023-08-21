<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

public function __construct()
{
  $this->middleware('auth');
}

/**
 * Show chats
 *
 * @return \Illuminate\Http\Response
 */
public function index()
{
  return Message::with('user')->get();
}

/**
 * Fetch all messages
 *
 * @return Message
 */
public function fetchMessages()
{

    $user= User::find(Auth::id());

  return Message::where('user_id', $user->id)->get();

}

/**
 * Persist message to database
 *
 * @param  Request $request
 * @return Response
 */
public function sendPrivateMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = new Message();
        $message->user_id = Auth::id();
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;
        $message->save();

        return response()->json(['message' => 'Private message sent successfully.', 'data' => $message], 201);
    }

// public function getPrivateMessage(Request $request, $rd )
    public function getPrivateMessage()
    {
        // $request->validate([
        //     'receiver_id' => 'required|exists:users,id',
        // ]);
        $user=User::find(Auth::id());

        // $messages = $user->messages()->where('receiver_id', $rd)->get();

        // return $messages;
        return Message::where('receiver_id', $user->id)->get();
    }
    public function putPrivateMessage(Request $request, $id ){

        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }else{
        $chat= Message::find($id);
        $chat->update($request->all());
        return $chat;
        }

    }

    public function delPrivateMessage(Request $request, $id ){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }else{
        return Message::destroy($id);
        }
    }

    public function sendGroupMessage(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:group_y_s,id',
            'content' => 'required|string',
        ]);

        $group = Group::find($request->group_id);
        if (!$group) {
            return response()->json(['message' => 'Group not found.'], 404);
        }

        $user = Auth::user();
        if (!$group->users()->where('users.id', $user->id)->exists()) {
            return response()->json(['message' => 'You are not a member of this group.'], 403);
        }
        $message = Message::create([
            'sender_id' => $user->id,
            'group_id' => $request->group_id,
            'content' => $request->content,
        ]);

        return response()->json(['message' => 'Group message sent successfully.', 'data' => $message], 201);
    }

}
