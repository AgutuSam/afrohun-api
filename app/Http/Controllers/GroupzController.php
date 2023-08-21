<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupz;
use App\Models\User;
use App\Models\GroupMembership;
use App\Models\GroupMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GroupzController extends Controller
{

    public function __construct()
{
  $this->middleware('auth');
}


    public function createGroup(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'group_image' => 'image|mimes:jpeg,png,jpg,gif', // Adjust the image validation rules as needed
        ]);

        // Handle group image upload
        $groupImage = null;
        if ($request->hasFile('group_image')) {
            $groupImage = $request->file('group_image')->store('group_images', 'public');
        }

        // $user= User::find(Auth::id());
        $user = Auth::user();
        // Create a new group
        $groupz = new Groupz([
            'name' => $request->name,
            'admin_id' => $user->id,
            'group_image' => $groupImage,
        ]);
        $groupz->save();

        // Add the user as the admin of the group
        $user = Auth::user();
        $groupz->members()->attach($user, ['is_admin' => true]);

        // Return the created group as a JSON response
        return response()->json($groupz, 201);
    }


    public function getGroupsWithMembers()
    {
        // Get the list of groups along with their connected information (including members)
        $groups = Groupz::with('members:id,name,profile_picture') // Include user information with specific fields (id, name, profile_picture)
            ->get();

        return response()->json($groups, 200);
    }

    public function getGroupz()
    {
        // Fetch all available groups
        $groupz = Groupz::all();

        // Return the groups as a JSON response
        return response()->json($groupz);
    }

    public function getGroupsForAuthenticatedUser(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Get the groups for the user
        $groups = $user->groups;

        return response()->json($groups);
    }

    // Implement other functions for joining, leaving, and sending group messages

    public function joinGroup(Request $request, $groupId)
    {
        $groupz = Groupz::find($groupId);

        // Check if the group exists
        if (!$groupz) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        // Check if the user is already a member of the group
        $user = Auth::user();
        if ($user->groups()->where('groupz_id', $groupId)->exists()) {
            return response()->json(['message' => 'User is already a member of the group'], 400);
        }

        // Add the user to the group
        $groupz->members()->attach($user);

        return response()->json(['message' => 'User joined the group successfully'], 200);
    }


    public function leaveGroup(Request $request, $groupId)
    {
        $groupz = Groupz::find($groupId);

        // Check if the group exists
        if (!$groupz) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        // Check if the user is a member of the group
        $user = Auth::user();
        if (!$user->groups()->where('groupz_id', $groupId)->exists()) {
            return response()->json(['message' => 'User is not a member of the group'], 400);
        }

        // Remove the user from the group
        $groupz->members()->detach($user);

        return response()->json(['message' => 'User left the group successfully'], 200);
    }

    public function deleteGroup(Request $request, $groupId)
    {
        $groupz = Groupz::find($groupId);

        // Check if the group exists
        if (!$groupz) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        // Check if the user is the admin of the group
        $user = Auth::user();
        if ($groupz->admin_id !== $user->id) {
            return response()->json(['message' => 'Only the group admin can delete the group'], 403);
        }

        // Delete the group
        $groupz->delete();

        return response()->json(['message' => 'Group deleted successfully'], 200);
    }

    public function inviteToGroup(Request $request, $groupId)
    {
        $groupz = Groupz::find($groupId);

        // Check if the group exists
        if (!$groupz) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        // Check if the user is the admin of the group
        $user = Auth::user();
        if ($groupz->admin_id !== $user->id) {
            return response()->json(['message' => 'Only the group admin can invite users'], 403);
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid user ID'], 400);
        }

        // Check if the user is already a member of the group
        $userId = $request->input('user_id');
        if ($groupz->members()->where('user_id', $userId)->exists()) {
            return response()->json(['message' => 'User is already a member of the group'], 400);
        }

        // Add the user to the group
        $groupz->members()->attach($userId);

        return response()->json(['message' => 'User invited to the group successfully'], 200);
    }

    //  Messages
    public function sendMessage(Request $request, $groupId)
    {
        $groupz = Groupz::find($groupId);

        // Check if the group exists
        if (!$groupz) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        // Check if the user is a member of the group
        $user = Auth::user();
        if (!$user->groups()->where('groupz_id', $groupId)->exists()) {
            return response()->json(['message' => 'User is not a member of the group'], 400);
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid message content'], 400);
        }

        // Create and save the group message
        $message = new GroupMessage([
            'groupz_id' => $groupId,
            'user_id' => $user->id,
            'content' => $request->input('content'),
        ]);
        $message->save();

        return response()->json(['message' => 'Message sent successfully'], 200);
    }

    public function getGroupMessages($groupId)
    {
        $groupz = Groupz::find($groupId);

        // Check if the group exists
        if (!$groupz) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        // Check if the user is a member of the group
        $user = Auth::user();
        if (!$user->groups()->where('groupz_id', $groupId)->exists()) {
            return response()->json(['message' => 'User is not a member of the group'], 400);
        }

        // Fetch all messages from the group, along with the user who sent each message
        $messages = GroupMessage::with('user')
            ->where('groupz_id', $groupId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}
