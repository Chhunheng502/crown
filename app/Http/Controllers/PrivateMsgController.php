<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\PrivateMsg;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateMsgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chat', [
            'user' => Auth::user(),
        ]);
    }

    public function fetchMessage()
    {
        return view('chat', [
            'messages' => Auth::user()->messages,
        ]);
    }

    public function sendMessage(Request $request, User $receiver)
    {
        $user = Auth::user();

        $message = $user->messages->create([
            'to_user_id' => $receiver->id,
            'content' => $request->input('message'), 
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();
      
        return ['status' => 'Message Sent!'];
    }
}
