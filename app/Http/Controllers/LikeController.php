<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function fetchLikes(Request $request)
    {
        return Like::where('post_id', $request->post_id ?? -1)
                    ->orWhere('share_id', $request->share_id ?? -1)
                    ->get();
    }

    public function likePost(Request $request)
    {
        $like = new Like();

        $like->user_id = Auth::id();
        $like->post_id = $request->post_id;
        $like->share_id = $request->share_id;

        $like->save();

        return ['status' => 'success'];
    }

    public function unlikePost(Request $request)
    {
        $like = Like::where('user_id', Auth::id())
                        ->where(function($query) use($request) {
                            $query->where('post_id', $request->post_id ?? -1)
                                    ->orWhere('share_id', $request->share_id ?? -1);
                        });

        $like->delete();

        return ['status' => 'success'];
    }

    public function isLiked(Request $request)
    {
        $is_liked = Like::where('user_id', Auth::id())
                            ->where(function($query) use($request) {
                                $query->where('post_id', $request->post_id ?? -1)
                                        ->orWhere('share_id', $request->share_id ?? -1);
                            })->exists();
        
        if($is_liked)
        {
            return true;
        }

        return false;

        return $request->all();
    }
}
