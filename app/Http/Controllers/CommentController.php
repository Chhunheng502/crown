<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function fetchComments(Request $request)
    {
        return Comment::with('user')
                        ->where('post_id', $request->post_id ?? -1)
                        ->orWhere('share_id', $request->share_id ?? -1)
                        ->get();
    }

    public function storeComment(Request $request)
    {
        $comment = new Comment();

        $comment->user_id = Auth::id();
        $comment->post_id = $request->post_id;
        $comment->share_id = $request->share_id;
        $comment->content = $request->content;

        $comment->save();

        return Comment::with('user')
                        ->where('id', $comment->id)
                        ->get();
    }

    public function deleteComment(Request $request)
    {
        $comment = Comment::find($request->comment_id);

        $comment->delete();

        return ['status' => 'success'];
    }

    public function editComment(Request $request)
    {
        $comment = Comment::find($request->comment_id);

        $comment->content = $request->content;

        $comment->save();

        return ['status' => 'success'];
    }

    public function fetchRepliedComments(Request $request)
    {
        return CommentReply::with('commenter', 'replier')
                            ->where('comment_id', $request->comment_id)
                            ->get();
    }

    public function replyComment(Request $request)
    {
        $replied_comment = new CommentReply();

        $replied_comment->comment_id =$request->comment_id;
        $replied_comment->from_user_id = Auth::id();
        $replied_comment->to_user_id = $request->to_user_id;
        $replied_comment->content = $request->content;

        $replied_comment->save();

        return CommentReply::with('commenter', 'replier')
                        ->where('id', $replied_comment->id)
                        ->get();
    }

    public function editRepliedComment(Request $request)
    {
        $replied_comment = CommentReply::find($request->reply_id);

        $replied_comment->content = $request->content;

        $replied_comment->save();

        return ['status' => 'success'];
    }

    public function deleteRepliedComment(Request $request)
    {
        $comment = CommentReply::find($request->reply_id);

        $comment->delete();

        return ['status' => 'success'];
    }
}
