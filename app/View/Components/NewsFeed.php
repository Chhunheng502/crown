<?php

namespace App\View\Components;

use App\Models\Friendship;
use Illuminate\View\Component;

class NewsFeed extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.news-feed', [
            'posts' => Friendship::getLatestPosts(),
        ]);
    }
}
