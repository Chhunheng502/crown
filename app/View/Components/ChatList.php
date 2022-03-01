<?php

namespace App\View\Components;

use App\Models\PrivateMsg;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class ChatList extends Component
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
        return view('components.chat-list', [
            'messages' => PrivateMsg::where('to_user_id', Auth::id())
                            ->with('sender')
                            ->get(),
        ]);
    }
}
