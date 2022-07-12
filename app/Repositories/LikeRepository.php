<?php

namespace App\Repositories;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeRepository extends AbstractRepository
{
    public function getLikes($request)
    {
        $likes = Like::where('post_id', $request->post_id ?? -1)
                        ->orWhere('share_id', $request->share_id ?? -1)
                        ->get();

        return $likes;
    }

    public function exist($request)
    {
        $is_liked = $this->model->where('user_id', Auth::id())
                    ->where(function($query) use($request) {
                        $query->where('post_id', $request->post_id ?? -1)
                                ->orWhere('share_id', $request->share_id ?? -1);
                    })->exists();
        
        if($is_liked)
        {
            return true;
        }

        return false;
    }

    public function create($request)
    {
        $like = new Like();

        $like->user_id = Auth::id();
        $like->post_id = $request->post_id;
        $like->share_id = $request->share_id;

        $like->save();

        return true;
    }

    public function unlike($request)
    {
        $like = $this->model->where('user_id', Auth::id())
                ->where(function($query) use($request) {
                    $query->where('post_id', $request->post_id ?? -1)
                            ->orWhere('share_id', $request->share_id ?? -1);
        });

        $like->delete();

        return true;
    }
}