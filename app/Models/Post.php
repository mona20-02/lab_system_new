<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id'
    ];

    public function post_likes() {
        return $this->hasMany(PostLike::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function isVisibleToUser(User $user): bool {
        return $user->id === $this->user_id || 
               $user->friends()->where('friend_id', $this->user_id)->where('accepted', true)->exists() ||
               $this->user->friends()->where('friend_id', $user->id)->where('accepted', true)->exists();
    }
}
