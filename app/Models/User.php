<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function detail()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    public function friends()
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function shares()
    {
        return $this->hasMany(Share::class, 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(PrivateMsg::class, 'from_user_id');
    }

    protected $with = ['detail', 'posts', 'shares'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn($query, $search) =>
            $query->where(fn($query) =>
                $query->where('name', 'like', '%' . $search . '%')
            )
        );

        $query->when($filters['post'] ?? false, fn($query, $post) =>
            $query->whereHas('posts', fn ($query) =>
                $query->where('id', $post)
            )
        );

        $query->when($filters['share'] ?? false, fn($query, $share) =>
            $query->whereHas('shares', fn ($query) =>
                $query->where('id', $share)
            )
        );
    }
}
