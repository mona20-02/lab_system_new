<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function friends()
    {
        return $this->hasMany(Friend::class, 'user_id');
    }

    public function friendRequests()
    {
        return $this->hasMany(Friend::class, 'friend_id');
    }

    public function isFriend(User $user)
    {
        return $this->friends()->where('friend_id', $user->id)->where('accepted', true)->exists() ||
               $user->friends()->where('friend_id', $this->id)->where('accepted', true)->exists();
    }
    public function hasSentFriendRequestTo(User $user)
{
    return Friend::where('user_id', auth()->id())
        ->where('friend_id', $user->id)
        ->exists();
}
public function hasPendingFriendRequestFrom(User $user)
{
    return Friend::where('user_id', $user->id)
        ->where('friend_id', auth()->id())
        ->where('accepted', false)
        ->exists();
}
}