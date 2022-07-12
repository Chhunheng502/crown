<?php

namespace App\Http\Controllers;

use App\Repositories\LikeRepository;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    protected $likeRepository;

    public function __construct(LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    public function getLikes(Request $request)
    {
        return $this->likeRepository->getLikes($request);
    }

    public function isLiked(Request $request)
    {
        return $this->likeRepository->exist($request);
    }

    public function store(Request $request)
    {
        $this->likeRepository->create($request);

        return ['status' => 'success'];
    }

    public function destroy(Request $request)
    {
        $this->likeRepository->unlike($request);

        return ['status' => 'success'];
    }
}
