<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Share;
use App\Repositories\PostRepository;
use App\Repositories\ShareRepository;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    protected $shareRepository;
    protected $postRepository;

    public function __construct(
        ShareRepository $shareRepository,
        PostRepository $postRepository
    )
    {
        $this->shareRepository = $shareRepository;
        $this->postRepository = $postRepository;
    }

    public function countShares($post_id)
    {
        return $this->postRepository->getbyId($post_id)->shares->count();
    }

    public function store(Request $request)
    {
        $this->shareRepository->create($request);

        return ['status' => 'success'];
    }

    public function update($id, Request $request)
    {
        $this->shareRepository->update($id, $request);

        return ['status' => 'success'];
    }

    public function delete($id)
    {
        $this->shareRepository->delete($id);

        return ['status' => 'success'];
    }
}
