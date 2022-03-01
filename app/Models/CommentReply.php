<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    use HasFactory;

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function replier()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function commenter()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
