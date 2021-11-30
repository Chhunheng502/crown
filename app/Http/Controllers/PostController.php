<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Share;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function fetchPosts()
    {
        return Post::getLatestPosts();
    }

    public function fetchUserPosts(Request $request)
    {
        $posts = Post::with('author')->where('user_id', $request->user_id)->get();

        $shares = Share::with('user', 'post.author')->where('user_id', $request->user_id)->get();

        return [...$posts, ...$shares];
    }

    public function createPost(Request $request)
    {
        $post = new Post();

        $post->user_id = $request->user_id;
        $post->content = $request->content;
        $post->photo = $request->file('photo')?->store('images', ['disk' => 'public']);

        $post->save();

        return ['status' => 'success'];
    }

    public function editPost(Request $request)
    {
        $post = Post::find($request->post_id);

        $post->content = $request->content;

        $post->save();

        return ['status' => 'success'];
    }

    public function deletePost(Request $request)
    {
        Post::find($request->post_id)->delete();

        return ['status' => 'success'];
    }
}
