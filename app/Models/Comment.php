<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // With post_id in fillable, a crafted POST to that admin endpoint could move a comment onto a different post
    protected $fillable = [
        'author',
        'email',
        'photo',
        'body',
        'is_active'
    ];

    public function replies() {
        return $this->hasMany(CommentReply::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
