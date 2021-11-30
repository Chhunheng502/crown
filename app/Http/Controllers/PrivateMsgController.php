<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PrivateMsgController extends Controller
{
    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Inertia::render('Chat/ChatBox', [
        'from_user' => Auth::user(),
        'chats' => Chat::with('sender', 'receiver')
                        ->where('user_id', Auth::id())
                        ->orWhere('user2_id', Auth::id())
                        ->get(),
      ]);
    }

    public function createChat(Request $request)
    {
      $chat = new Chat();

      $chat->user_id = Auth::id();
      $chat->user2_id = $request->friend_id;

      $chat->save();

      return ['status' => 'success'];
    }
    
    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages(Request $request)
    {
      // should use with chat id instead
      // naming in here is not consistent
        $data = Chat::with('sender', 'receiver', 'messages')
                    ->where(function ($query) use($request) {
                      $query->where('user_id', Auth::id())
                            ->where('user2_id', $request->id);
                    })->orWhere(function ($query) use($request) {
                      $query->where('user_id', $request->id)
                            ->where('user2_id', Auth::id());
                    })->get();

        return $data;
    }
    
    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
      $chats = Chat::where(function ($query) use($request) {
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
    }
}
