<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{
    public function getShares(Request $request)
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
