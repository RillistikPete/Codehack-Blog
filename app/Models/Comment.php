<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [

        'post_id',
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
