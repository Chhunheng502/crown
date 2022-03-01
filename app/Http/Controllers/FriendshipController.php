<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function fetchFriends()
    {
        return Friendship::with('profile1', 'profile2')
                            ->where('user_id', Auth::id())
                            ->orWhere('user2_id', Auth::id())
                            ->get();
    }

    public function addFriend(Request $request)
    {
        $friend_request = new FriendRequest();

        $friend_request->from_user_id = Auth::id();
        $friend_request->to_user_id = $request->to_user_id;

        $friend_request->save();

        return ['status' => 'success'];
    }

    public function unfriend(Request $request)
    {
        $friend = Friendship::where(function($query) use($request) {
                                    $query->where('user_id', Auth::id())
                                    ->where('user2_id', $request->user_id);
                            })->orWhere(function($query) use($request) {
                                $query->where('user2_id', Auth::id())
                                ->where('user_id', $request->user_id);
                            });

        $friend->delete();

        return ['status' => 'success'];
    }

    public function isFriend(Request $request)
    {
        $friend = Friendship::where(function($query) use($request) {
                                    $query->where('user_id', Auth::id())
                                    ->where('user2_id', $request->user_id);
                            })->orWhere(function($query) use($request) {
                                $query->where('user2_id', Auth::id())
                                ->where('user_id', $request->user_id);
                            })->exists();

        $isFriend = false;

        if($friend)
        {
            $isFriend = true;
        }

        $friend_request = FriendRequest::where(function($query) use($request) {
                                        $query->where('from_user_id', Auth::id())
                                        ->where('to_user_id', $request->user_id);
                                })->orWhere(function($query) use($request) {
                                    $query->where('to_user_id', Auth::id())
                                    ->where('from_user_id', $request->user_id);
                                })->exists();

        $pending = false;

        if($friend_request)
        {
            $pending = true;
        }

        return [
            'isFriend' => $isFriend,
            'pending' => $pending,
        ];
    }

    public function fetchFriendRequests()
    {
        // return FriendRequest::with('fromUser')->where('to_user_id', Auth::id())->get();
        return FriendRequest::with('requester')->where('to_user_id', Auth::id())->get();
    }

    public function acceptFriendRequest(Request $request)
    {
        $friend_request = FriendRequest::find($request->id);

        $friend = new Friendship();

        $friend->user_id = Auth::id();
        $friend->user2_id = $friend_request->from_user_id;

        $friend->save();

        $friend_request->delete();

        return ['status' => 'success'];
    }

    public function deleteFriendRequest(Request $request)
    {
        $friend_request = FriendRequest::find($request->id);

        $friend_request->delete();

        return ['status' => 'success'];
    }
}
