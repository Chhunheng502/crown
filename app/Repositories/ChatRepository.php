<?php

namespace App\Repositories;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatRepository extends AbstractRepository
{
    public function getChat()
    {
        $chat = $this->model->with('sender', 'receiver')
                    ->where('user_id', Auth::id())
                    ->orWhere('user2_id', Auth::id())
                    ->get();

        return $chat;
    }

    public function getMessages($user_id)
    {
        // should use with chat id instead
        // naming in here is not consistent
        $data = $this->model->with('sender', 'receiver', 'messages')
            ->where(function ($query) use($user_id) {
                $query->where('user_id', Auth::id())
                    ->where('user2_id', $user_id);
        })->orWhere(function ($query) use($user_id) {
            $query->where('user_id', $user_id)
                ->where('user2_id', Auth::id());
        })->get();

        return $data;
    }

    public function sendMessage($request)
    {
        $chats = $this->model->where(function ($query) use($request) {
            $query->where('user_id', Auth::id())
                  ->where('user2_id', $request->to_user_id);
          })->orWhere(function ($query) use($request) {
            $query->where('user_id', $request->to_user_id)
                  ->where('user2_id', Auth::id());
          })->get();

        $message = User::find(Auth::id())->messages()->create([
        'chat_id' => $chats->first()->id,
        'to_user_id' => $request->to_user_id,
        'content' => $request->content
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return true;
    }

    public function create($request)
    {
        $chat = new Chat();

        $chat->user_id = Auth::id();
        $chat->user2_id = $request->friend_id;
    
        $chat->save();

        return true;
    }
}