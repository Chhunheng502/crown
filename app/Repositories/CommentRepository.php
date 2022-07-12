<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\Comment as NotificationsComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CommentRepository extends AbstractRepository
{
    public function getComments($request)
    {
        $comments = Comment::with('user')
                        ->where('post_id', $request->post_id ?? -1)
                        ->orWhere('share_id', $request->share_id ?? -1)
                        ->get();
        
        return $comments;
    }

    public function create($request)
    {
        $comment = new Comment();

        $comment->user_id = Auth::id();
        $comment->post_id = $request->post_id;
        $comment->share_id = $request->share_id;
        $comment->content = $request->content;

        $comment->save();

        if(Auth::id() !== Post::find($request->post_id)->author->id)
        {
            Notification::send(Post::find($request->post_id)->author, new NotificationsComment($request->post_id));
        }

        return Comment::with('user')
                        ->where('id', $comment->id)
                        ->get();
    }

    public function update($id, $request)
    {
        $comment = $this->getbyId($id);

        $comment->content = $request->content;

        $comment->save();

        return true;
    }
}