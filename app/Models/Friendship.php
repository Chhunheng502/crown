<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Friendship extends Model
{
    use HasFactory;

    public function profile()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    public static function getLatestPosts()
    {
        $friends = FriendShip::where('user_id', Auth::id())->get();

        $latest_posts = [];

        foreach($friends as $friend)
        {
            $posts = Post::where('user_id', $friend->user2_id)->get();

            foreach($posts as $post)
            {
                array_push($latest_posts, $post);
            }
        }

        // return collect($latest_posts)->sortBy('updated_at')->toArray(); // might wanna add reverse()

        return $latest_posts;
    }
}
