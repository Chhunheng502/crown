<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\Share;
use App\Notifications\Share as NotificationsShare;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ShareRepository extends AbstractRepository
{
    public function create($request)
    {
        $share = new Share();

        $share->user_id = Auth::id();
        $share->post_id = $request->post_id;
        $share->content = $request->content;

        $share->save();

        Notification::send(Post::find($request->post_id)->author, new NotificationsShare($share->id));

        return true;
    }

    public function update($id, $request)
    {
        $share = $this->model->find($id);

        $share->content = $request->content;

        $share->save();

        return true;
    }
}