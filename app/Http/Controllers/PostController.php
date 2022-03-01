<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Share;
use App\Models\User;
use App\Models\UserDetail;
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

    public function updateProfile(Request $request)
    {
        $user = User::find($request->user_id);

        $user->profile_photo_path = $request->file('photo')->store('images', ['disk' => 'public']);

        $user->save();

        $post = new Post();

        $post->user_id = $request->user_id;
        $post->content = $request->content;
        $post->photo = $user->profile_photo_path;

        $post->save();

        return ['status' => 'success'];
    }

    public function updateCover(Request $request)
    {
        $user_detail = UserDetail::find($request->id);

        $user_detail->cover = $request->file('photo')->store('images', ['disk' => 'public']);

        $user_detail->save();

        $post = new Post();

        $post->user_id = $user_detail->user_id;
        $post->content = $request->content;
        $post->photo = $user_detail->cover;

        $post->save();

        return ['status' => 'success'];
    }
}
