<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('users.index', compact('users'));
    }
    public function sendRequest(User $user)
    {
        if (Friend::where('user_id', auth()->id())
            ->where('friend_id', $user->id)
            ->exists()) {
            return redirect()->back()->with('error', 'Friend request already sent.');
        }
    
        Friend::create([
            'user_id' => auth()->id(),
            'friend_id' => $user->id,
        ]);
    
        return redirect()->back()->with('success', 'Friend request sent.');
    }
    public function deleteRequest(User $user)
{
    Friend::where('user_id', auth()->id())
        ->where('friend_id', $user->id)
        ->delete();

    return redirect()->back()->with('success', 'Friend request deleted.');
}
public function acceptRequest(User $user)
{
    $friendRequest = Friend::where('user_id', $user->id)
        ->where('friend_id', auth()->id())
        ->first();

    $friendRequest->update(['accepted' => true]);

    return redirect()->back()->with('success', 'Friend request accepted.');
}

public function rejectRequest(User $user)
{
    $friendRequest = Friend::where('user_id', $user->id)
        ->where('friend_id', auth()->id())
        ->first();

    $friendRequest->delete();

    return redirect()->back()->with('success', 'Friend request rejected.');
}
}