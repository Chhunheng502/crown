<?php

namespace App\Repositories;

use App\Models\Friendship;
use App\Models\Post;
use App\Models\Share;
use Illuminate\Support\Facades\Auth;

class PostRepository extends AbstractRepository
{
    public function getAllLatest($initialVal, $endVal)
    {
        $latest_posts = [];

        $user_posts = Post::where('user_id', Auth::id())->with('author')->get();

        $user_shares = Share::with('user', 'post.author')
                                ->where('user_id', Auth::id())
                                ->get();

        $latest_posts = [...$user_posts, ...$user_shares];

        $friends = Friendship::where('user_id', Auth::id())
                                ->orWhere('user2_id', Auth::id())
                                ->get();

        foreach($friends as $friend)
        {
            $friend_id = Auth::id() == $friend->user_id ? $friend->user2_id : $friend->user_id;

            $friend_posts = Post::where('user_id', $friend_id)->with('author')->get();

            $friend_shares = Share::where('user_id', $friend_id)->with('user', 'post.author')->get();

            $latest_posts = [...$latest_posts, ...$friend_posts, ...$friend_shares];
        }

        return array_splice($latest_posts, $initialVal, $endVal);
    }

    public function getUserLatest($id)
    {
        $posts = Post::with('author')->where('user_id', $id)->get();

        $shares = Share::with('user', 'post.author')->where('user_id', $id)->get();

        return [...$posts, ...$shares];
    }

    public function create($request)
    {
        $post = new Post();

        $post->user_id = $request->user_id;
        $post->content = $request->content;
        $post->photo = $request->file('photo')?->store('images', ['disk' => 'public']);

        $post->save();

        return true;
    }

    public function update($id, $request)
    {
        $post = $this->model->find($id);

        $post->content = $request->content;

        $post->save();

        return true;
    }
}