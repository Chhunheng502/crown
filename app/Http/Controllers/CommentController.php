<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\Comment as NotificationsComment;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getComments(Request $request)
    {
        return $this->commentRepository->getComments($request);
    }

    public function store(Request $request)
    {
       return $this->commentRepository->create($request);
    }

    public function update($id, Request $request)
    {
        $this->commentRepository->update($id, $request);

        return ['status' => 'success'];
    }

    public function delete($id)
    {
        $this->commentRepository->delete($id);

        return ['status' => 'success'];
    }
}
