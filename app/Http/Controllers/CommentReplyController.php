<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\User;
use App\Notifications\CommentReply as NotificationsCommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CommentReplyController extends Controller
{
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

        Notification::send(
            User::find($request->to_user_id), new NotificationsCommentReply(
                Comment::find($request->comment_id)->post->id
            )
        );

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
