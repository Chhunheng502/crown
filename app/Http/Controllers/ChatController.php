<?php

namespace App\Http\Controllers;

use App\Repositories\ChatRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatController extends Controller
{
  protected $chatRepository;

  public function __construct(ChatRepository $chatRepository)
  {
    $this->chatRepository = $chatRepository;
  }
  
  public function index()
  {
    return Inertia::render('Chat/ChatBox', [
      'from_user' => Auth::user(),
      'chats' => $this->chatRepository->getChat()
    ]);
  }

  public function getMessages($user_id)
  {
    return $this->chatRepository->getMessages($user_id);
  }
    
  public function sendMessage(Request $request)
  {
    $this->chatRepository->sendMessage($request);
  }

  public function store(Request $request)
  {
    $this->chatRepository->create($request);

    return ['status' => 'success'];
  }
}
