<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    public function profile1()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function profile2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }
}
