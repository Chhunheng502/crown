<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAllPosts($initialVal, $endVal)
    {
        return $this->postRepository->getAllLatest($initialVal, $endVal);
    }

    public function getUserPosts($user_id)
    {
        return $this->postRepository->getUserLatest($user_id);
    }

    public function store(Request $request)
    {
        $this->postRepository->create($request);

        return ['status' => 'success'];
    }

    public function update($id, Request $request)
    {
        $this->postRepository->update($id, $request);

        return ['status' => 'success'];
    }

    public function destroy($id)
    {
        $this->postRepository->delete($id);

        return ['status' => 'success'];
    }
}
