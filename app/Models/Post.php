<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public static function getLatestPosts()
    {
        $latest_posts = [];

        $user_posts = Post::where('user_id', Auth::id())->with('author')->get();

        $user_shares = Share::with('user', 'post.author')
                                ->where('user_id', Auth::id())
                                ->get();

        $latest_posts = [...$user_posts, ...$user_shares];

        $friends = FriendShip::where('user_id', Auth::id())
                                ->orWhere('user2_id', Auth::id())
                                ->get();

        foreach($friends as $friend)
        {
            $friend_id = Auth::id() == $friend->user_id ? $friend->user2_id : $friend->user_id;

            $friend_posts = Post::where('user_id', $friend_id)->with('author')->get();

            $friend_shares = Share::where('user_id', $friend_id)->with('user', 'post.author')->get();

            $latest_posts = [...$latest_posts, ...$friend_posts, ...$friend_shares];
        }

        return $latest_posts;
    }

    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::createFromTimeStamp(strtotime($created_at) )->diffForHumans();
    }
}
