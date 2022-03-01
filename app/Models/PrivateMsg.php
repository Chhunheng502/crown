<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PrivateMsg extends Model
{
    use HasFactory;

    protected $fillable = ['chat_id', 'to_user_id', 'content'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    // public static function getMessages($user_id)
    // {
    //     $outgoing_messages = PrivateMsg::with('sender', 'receiver')
    //                             ->where('from_user_id', Auth::id())
    //                             ->where('to_user_id', $user_id);
    //     $incoming_messages = PrivateMsg::with('sender', 'receiver')
    //                             ->where('to_user_id', Auth::id())
    //                             ->where('from_user_id', $user_id);

    //     return $outgoing_messages->union($incoming_messages)->get();
    // }
}
