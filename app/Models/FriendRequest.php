<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    use HasFactory;

    public function requester() {

        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function receiver() {

        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::createFromTimeStamp(strtotime($created_at) )->diffForHumans();
    }
}
