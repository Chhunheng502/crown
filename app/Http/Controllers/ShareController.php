<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Share;
use App\Notifications\Share as NotificationsShare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ShareController extends Controller
{
    public function fetchShares(Request $request)
    {
        $shares = Post::find($request->post_id)->shares->count();

        return $shares;
    }

    public function sharePost(Request $request)
    {
        $share = new Share();

        $share->user_id = Auth::id();
        $share->post_id = $request->post_id;
        $share->content = $request->content;

        $share->save();

        Notification::send(Post::find($request->post_id)->author, new NotificationsShare($share->id));

        return ['status' => 'success'];
    }

    public function editShare(Request $request)
    {
        $share = Share::find($request->share_id);

        $share->content = $request->content;

        $share->save();

        return ['status' => 'success'];
    }

    public function deleteShare(Request $request)
    {
        Share::find($request->share_id)->delete();

        return ['status' => 'success'];
    }
}
